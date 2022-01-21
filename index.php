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

/*
$homeController = new HomeController($post_manager, $user_manager, $category_manager, $comment_manager) ;
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

elseif($page==='user.home')
{
	$userController = new UserController($post_manager, $user_manager, $category_manager, $comment_manager) ;
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

elseif($page==='admin.home')
{
	$adminController = new UserController($post_manager, $user_manager, $category_manager, $comment_manager) ;
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
*/









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




