<?php
namespace BlogApp\Controller\Admin;

use BlogApp\Controller\AbstractController;
use BlogApp\Entity\Category;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class CategoryAdminController extends AbstractController
{
	protected UserManager $userManager;
	protected CategoryManager $categoryManager;

	public function __construct(UserManager $userManager, CategoryManager $categoryManager)
    {
		parent::__construct();
		$this->userManager = $userManager;
		$this->categoryManager = $categoryManager;
		if(!$this->userManager->isAdmin())
		{
			$this->forbidden();
		}
	}

    public function create()
    {
        $categoryCreate = $this->requestPost['categoryCreate'] ?? null;
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

            return $this->render('admin/manage_category.html.twig', [
                'message' => $message,
                'categories' => $categories,
                'categories_header' => $categoriesHeader
            ]);
        }
    }

    public function edit(){
        $idCategory = $this->requestGet['id'] ?? null;
        $categoryEdit = $this->requestPost['categoryEdit'] ?? null;
        if($categoryEdit)
        {
            $categorie = $this->categoryManager->getOne($idCategory);
            $categorie->setName(htmlspecialchars($categoryEdit));
            $this->categoryManager->edit($categorie);
            $message = 'La categorie a bien été modifiée';

            $categories = $this->categoryManager->getAll();
            $categoriesHeader = $this->categoryManager->getAll();

            return $this->render('admin/manage_category.html.twig', [
                'message' => $message,
                'categories' => $categories,
                'categories_header' => $categoriesHeader
            ]);
        }
    }

    public function delete(){
        $idCategory = $this->requestGet['id'] ?? null;
        $adminCategoryDelete = $this->requestPost['admin_category_delete'] ?? null;
        if($adminCategoryDelete)
        {
            $this->categoryManager->delete($idCategory);
            $message = 'La categorie a bien été supprimée';
            //		Optionnelement créer un systeme de suppression des photos des categories suprrimées :
            //if (file_exists($filename)) {
            //        unlink($filename);	}
            $categories = $this->categoryManager->getAll();
            $categoriesHeader = $this->categoryManager->getAll();

            return $this->render('admin/manage_category.html.twig', [
                'message' => $message,
                'categories' => $categories,
                'categories_header' => $categoriesHeader
            ]);
        }
    }

	public function list()
	{
			$categories = $this->categoryManager->getAll();
			return $this->render('admin/manage_category.html.twig', [
			'categories' => $categories,
			'categories_header' => $this->categoryManager->getAll()
				]);
	}
}
