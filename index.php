<?php
use BlogApp\Controller\HomeController;
use BlogApp\Controller\UserController;
use BlogApp\Controller\AdminController;

/*
var_dump(function_exists('imagecreatefromjpeg'));
die();
*/

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


switch ($page) 
{ 
	case $page==='home' ||  $page==='post' || $page==='single' || $page==='category' || $page==='sign_in' : 
	require('src/controller/home_controller.php');
	break;

	case $page==='user.home' ||  $page==='user.edit' || $page==='user.post.edit' || $page==='user.post.add' : 
	require('src/controller/user_controller.php');
	break;

	case $page==='admin.home' ||  $page==='admin.manage_user' || $page==='admin.manage_category' : 
	require('src/controller/admin_controller.php');
	break;

	case $page==='faker_user' :  require('src/faker/faker_user.php'); break;
	case $page==='faker_post' :  require('src/faker/faker_post.php'); break;
	case $page==='faker_comment' :  require('src/faker/faker_comment.php'); break;
	case $page==='faker_category' :  require('src/faker/faker_category.php'); break;

	default : $page = 'home'; break ; 
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


