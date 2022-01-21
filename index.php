<?php
use BlogApp\Controller\HomeController;
use BlogApp\Controller\UserController;
use BlogApp\Controller\AdminController;

require_once('init.php');
session_start();

if(isset($_GET['p']))
{
	$page = $_GET['p']; 
}
elseif(isset($_GET['disconnect']))
{
	session_destroy();
	$page = 'home';
}
else
{
	$page = 'home';
}



if($page==='home')
{
	require('src/controller/home_controller.php');
}
elseif($page==='post')
{
	require('src/controller/home_controller.php');
}
elseif($page==='single')
{
	require('src/controller/home_controller.php');
}
elseif($page==='category')
{
	require('src/controller/home_controller.php');
}
elseif($page==='sign_in')
{
	require('src/controller/home_controller.php');
}


elseif($page==='user.home')
{
	require('src/controller/user_controller.php');
}
elseif($page==='user.edit')
{
	require('src/controller/user_controller.php');
}
elseif($page==='user.post.edit')
{
	require('src/controller/user_controller.php');
}
elseif($page==='user.post.add')
{
	require('src/controller/user_controller.php');
}


elseif($page==='admin.home')
{
	require('src/controller/admin_controller.php');
}
elseif($page==='admin.manage_user')
{
	require('src/controller/admin_controller.php');
}
elseif($page==='admin.manage_category')
{
	require('src/controller/admin_controller.php');
}
elseif($page==='faker_user')
{
	require('src/faker/faker_user.php');
}

elseif($page==='faker_post')
{
	require('src/faker/faker_post.php');
}

elseif($page==='faker_comment')
{
	require('src/faker/faker_comment.php');
}

/* 
Le passage aux classes controllers pose problème à cause de la présence de manager dans les views ; la variable manager étant alors inconnue : 
template - basic_template : foreach ( $categoryManager->getAll() as $categorie )
home - category : $categoryManager->getCategoryName($post->getCategory_id());  et 
					$userManager->getAuthorName($post->getUser_id()); dans foreach
home - post : $categoryManager->getCategoryName($post->getCategory_id()); et
					$userManager->getAuthorName($post->getUser_id()); dans foreach
home - single : $userManager->getAuthorName($post->getUser_id());
user - home : $categoryManager->getCategoryName($post->getCategory_id()); et 
				$commentManager->countNotYetValid($post->getId()); dans foreach
admin - home : $categoryManager->getCategoryName((int)$post->getCategory_id()); dans foreach
*/ 
				


/*
if (!isset($_SESSION['auth']))
{ 
	$homeController = new HomeController($postManager, $userManager, $categoryManager, $commentManager) ;
	if($page==='home')
	{
		$homeController->home();
	}
	elseif($page==='post')
	{
		$homeController->post();
	}
	elseif($page==='single')
	{
		$homeController->single();
	}
	elseif($page==='category')
	{
		$homeController->category();
	}
	elseif($page==='sign_in')
	{
		$homeController->sign_in();
	}
	else
	{
		$homeController->home();
	}
}
else
{
	$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
	if($page==='user.home')
	{
		$userController->userHome();
	}
	elseif($page==='user.edit')
	{
		$userController->editUser();
	}
	elseif($page==='user.post.edit')
	{
		$userController->editPost();
	}
	elseif($page==='user.post.add')
	{
		$userController->addPost();
	}

	elseif($page==='admin.home' || $page==='admin.manage_user' || $page==='admin.manage_category')
	{
		$adminController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
		if($page==='admin.home')
		{
			$adminController->adminHome();
		}
		elseif($page==='admin.manage_user')
		{
			$adminController->manageUsers();
		}
		elseif($page==='admin.manage_category')
		{
			$adminController->manageCategories();
		}
		elseif($page==='faker_user')
		{
			require('src/faker/faker_user.php');
		}

		elseif($page==='faker_post')
		{
			require('src/faker/faker_post.php');
		}

		elseif($page==='faker_comment')
		{
			require('src/faker/faker_comment.php');
		}
	}
	else
	{
		header('Location:index.php?disconnect');
	}
}
*/











