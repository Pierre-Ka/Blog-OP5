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
		$adminPostDelete = $_POST['admin_post_delete'] ?? null;

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
			header('Location:admin.home');
		}
		if($adminPostDelete)
	    {
	        $this->postManager->delete($adminPostDelete);
	        $this->commentManager->deletePerPost($adminPostDelete);
	    }
	    $connect_id = $this->userManager->getUserId();
	    $posts = $this->postManager->getAllAdmin();

	    echo $this->twig->render('admin/home.twig', [
			'posts' => $posts,
			'categories_header' => $this->categories_header
				]);
	}

	public function manageUsers()
	{
		$adminUserDelete = $_POST['admin_user_delete'] ?? null;

		if(!empty($_GET['valid']))
		{
			$this->userManager->valid(($_GET['valid']));
		}
		if($adminUserDelete)
		{
			$this->userManager->delete($adminUserDelete);
		}
		$users = $this->userManager->getList();

		echo $this->twig->render('admin/manage_user.twig', [
			'users' => $users,
			'categories_header' => $this->categories_header
				]);

	}

	public function manageCategories()
	{
		$categoryEdit = $_POST['categoryEdit'] ?? null;
        $categoryCreate = $_POST['categoryCreate'] ?? null;
        $adminCategoryDelete = $_POST['admin_category_delete'] ?? null;

		if(empty($_POST))
		{
			$categories = $this->categoryManager->getAll();

			echo $this->twig->render('admin/manage_category.twig', [
			'categories' => $categories,
			'categories_header' => $this->categories_header
				]);
		}

		else
		{
			switch($_POST)
			{
				case $categoryEdit : 
				$categorie = $this->categoryManager->getOne($_GET['id']);
				$categorie->setName(htmlspecialchars($categoryEdit));
				$this->categoryManager->edit($categorie);
				break ;

				case $categoryCreate :
				$category = new Category([
					'name'=> htmlspecialchars($categoryCreate)
					]);
				$this->categoryManager->add($category);
				break ; 

				case $adminCategoryDelete :
				$this->categoryManager->delete($adminCategoryDelete);
				break ; 
			}
			header('Location:admin.home');
		}
	}
}

