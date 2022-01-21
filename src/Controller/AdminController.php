<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\Post;
use BlogApp\Entity\User;
use BlogApp\Entity\Category;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;


class AdminController extends AbstractController
{

	public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        parent::__construct($postManager, $userManager, $categoryManager, $commentManager);
		if(!$userManager->is_admin())
		{
			$this->forbidden();
		}
	}

	public function adminHome()
	{
	    if(( $userManager->logged() AND $userManager->isAdmin() ))
	    {
	        if(isset($_POST['admin_post_delete']))
	        {
	            $postManager->delete($_POST['admin_post_delete']);
	        }
	        $connect_id = $userManager->getUserId();
	        $posts = $postManager->getAllAdmin();
	        require('view/admin/home.php');
	    }
	    else
	    {
	        $incorrect=true;
	        require('view/home/sign_in.php');
	    }
	}

	public function manageUsers()
	{
		if(!empty($_GET['valid']))
		{
			$userManager->valid(($_GET['valid']));
		}
		if(isset($_POST['admin_user_delete']))
		{
			$userManager->delete($_POST['admin_user_delete']);
		}
		$users = $userManager->getList();
		require('view/admin/manage_user.php');
	}

	public function manageCategories()
	{
		if(empty($_POST))
		{
			$categories = $categoryManager->getAll();
			require('view/admin/manage_category.php');
		}
		else
		{
			switch($_POST)
			{
				case isset($_POST['categoryEdit']) : 
				$categorie = $categoryManager->getOne($_GET['id']);
				$categorie->setName(htmlspecialchars($_POST['categoryEdit']));
				$categoryManager->edit($categorie);
				break ;

				case isset($_POST['categoryCreate']) :
				$category = new Category([
					'name'=> htmlspecialchars($_POST['categoryCreate'])
					]);
				$categoryManager->add($category);
				break ; 

				case isset($_POST['admin_category_delete']) :
				$categoryManager->delete($_POST['admin_category_delete']);
				break ; 
			}
			header('Location:index.php?p=admin.home');
		}
	}

}
