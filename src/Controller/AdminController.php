<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Category;
use BlogApp\Faker\FakeData;
/*
use BlogApp\Entity\Comment;
use BlogApp\Entity\Post;
use BlogApp\Entity\User;
*/
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;


class AdminController extends UserController
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
		$categories_header = $this->categoryManager->getAll();
		if (isset($_GET['faker']))
		{
			$fake = new FakeData();
			switch($_GET['faker'])
			{
				case $_GET['faker']==="comment" : 
				$fake->fakeComment();
				break;
				case $_GET['faker']==="user" : 
				$fake->fakeUser();
				break;
				case $_GET['faker']==="post" : 
				$fake->fakePost();
				break;
			}
			header('Location:index.php?p=admin.home');
		}
		if(isset($_POST['admin_post_delete']))
	    {
	        $this->postManager->delete($_POST['admin_post_delete']);
	        $this->commentManager->deletePerPost($_POST['admin_post_delete']);
	    }
	    $connect_id = $this->userManager->getUserId();
	    $posts = $this->postManager->getAllAdmin();

	    echo $this->twig->render('admin/home.twig', [
			'posts' => $posts,
			'categories_header' => $categories_header
				]);
	}

	public function manageUsers()
	{
		$categories_header = $this->categoryManager->getAll();
		if(!empty($_GET['valid']))
		{
			$this->userManager->valid(($_GET['valid']));
		}
		if(isset($_POST['admin_user_delete']))
		{
			$this->userManager->delete($_POST['admin_user_delete']);
		}
		$users = $this->userManager->getList();

		echo $this->twig->render('admin/manage_user.twig', [
			'users' => $users,
			'categories_header' => $categories_header
				]);

	}

	public function manageCategories()
	{
		$categories_header = $this->categoryManager->getAll();
		if(empty($_POST))
		{
			$categories = $this->categoryManager->getAll();

			echo $this->twig->render('admin/manage_category.twig', [
			'categories' => $categories,
			'categories_header' => $categories_header
				]);

		}
		else
		{
			switch($_POST)
			{
				case isset($_POST['categoryEdit']) : 
				$categorie = $this->categoryManager->getOne($_GET['id']);
				$categorie->setName(htmlspecialchars($_POST['categoryEdit']));
				$this->categoryManager->edit($categorie);
				break ;

				case isset($_POST['categoryCreate']) :
				$category = new Category([
					'name'=> htmlspecialchars($_POST['categoryCreate'])
					]);
				$this->categoryManager->add($category);
				break ; 

				case isset($_POST['admin_category_delete']) :
				$this->categoryManager->delete($_POST['admin_category_delete']);
				break ; 
			}
			header('Location:index.php?p=admin.home');
		}
	}

}
