<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Category;
use BlogApp\Faker\FakeData;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class AdminController extends BackController
{

	public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        parent::__construct($postManager, $userManager, $categoryManager, $commentManager);
		if(!$this->userManager->isAdmin())
		{
			$this->forbidden();
		}
	}

	public function adminHome()
	{
		$faker = $_GET['faker'] ?? null;
		$adminPostDelete = $_POST['admin_post_delete'] ?? null;

		if (isset($faker))
		{
			header('Location: ../template/admin/faker.php');
		}
		if($adminPostDelete)
	    {
	        $this->postManager->delete($adminPostDelete);
	        $this->commentManager->deletePerPost($adminPostDelete);
	    }
	    $posts = $this->postManager->getAllAdmin();

	    return $this->twig->render('admin/home.twig', [
			'posts' => $posts,
			'categories_header' => $this->categoriesHeader
				]);
	}

	public function manageUsers()
	{
		$adminUserDelete = $_POST['admin_user_delete'] ?? null;
		$idUserValid = $_GET['valid'] ?? null;

		if(!empty($idUserValid))
		{
			$this->userManager->valid($idUserValid);
		}
		if($adminUserDelete)
		{
			$this->userManager->delete($adminUserDelete);
		}
		$users = $this->userManager->getList();

		return $this->twig->render('admin/manage_user.twig', [
			'users' => $users,
			'categories_header' => $this->categoriesHeader
				]);
	}

	public function manageCategories()
	{
		$categoryEdit = $_POST['categoryEdit'] ?? null;
        $categoryCreate = $_POST['categoryCreate'] ?? null;
        $adminCategoryDelete = $_POST['admin_category_delete'] ?? null;
        $idCategory = $_GET['id'] ?? null;

        if(!($_POST))
		{
			$categories = $this->categoryManager->getAll();
			return $this->twig->render('admin/manage_category.twig', [
			'categories' => $categories,
			'categories_header' => $this->categoriesHeader
				]);
		}
		else
		{
	        if (isset($_FILES['categoryPicture']) && $categoryCreate)
		    {
		    	$category = new Category([
					'name'=> htmlspecialchars($categoryCreate)
						]);
				$this->categoryManager->add($category);
				$newId = $this->categoryManager->getLastInsertId();

				if (($_FILES['categoryPicture']['error'] == 0) && ($_FILES['categoryPicture']['size'] <= 5000000)) 
				{
		            $infosfichier = pathinfo($_FILES['categoryPicture']['name']);
		            $extensionUpload = $infosfichier['extension'];
		            $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
		            if (in_array($extensionUpload, $extensionsAutorisees))
		            {
		            	$pictureName = 'DEFAULT_IMG_'. $newId .'.jpg';
		            	$picturePath = '../var/media/post/'. $pictureName ;
		   				move_uploaded_file($_FILES['categoryPicture']['tmp_name'], $picturePath);	

		                $widgetPath = '../var/media/post/MINI_DEFAULT_IMG_'. $newId .'.jpg' ;
		                //resizeImageWithCrop
		                $picture = $category->resizeImage($picturePath, $widgetPath, 60, 60);
		                $message = 'La categorie a bien été ajoutée';
		            }
		        }

				$categories = $this->categoryManager->getAll();
				$categoriesHeader = $this->categoryManager->getAll();
				if (!$message) { $message = 'Erreur' ;}

	        	return $this->twig->render('admin/manage_category.twig', [
		        	'message' => $message,
					'categories' => $categories,
					'categories_header' => $categoriesHeader
						]);    
			}
			if($categoryEdit)
			{ 
				$categorie = $this->categoryManager->getOne($idCategory);
				$categorie->setName(htmlspecialchars($categoryEdit));
				$this->categoryManager->edit($categorie);
				$message = 'La categorie a bien été modifiée';

				$categories = $this->categoryManager->getAll();
				$categoriesHeader = $this->categoryManager->getAll();

			    return $this->twig->render('admin/manage_category.twig', [
		        	'message' => $message,
					'categories' => $categories,
					'categories_header' => $categoriesHeader
						]);   
			}
			if($adminCategoryDelete)
			{
				$this->categoryManager->delete($idCategory);
				$message = 'La categorie a bien été supprimée';
				/*		Optionnelement créer un systeme de suppression des photos des categories suprrimées : 
				if (file_exists($filename)) {
    					unlink($filename);	}			*/
				$categories = $this->categoryManager->getAll();
				$categoriesHeader = $this->categoryManager->getAll(); 

	        	return $this->twig->render('admin/manage_category.twig', [
		        	'message' => $message,
					'categories' => $categories,
					'categories_header' => $categoriesHeader
						]); 
			}
		}
	}
}
