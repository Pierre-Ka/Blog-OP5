<?php
use BlogApp\Controller\HomeController;
use BlogApp\Controller\UserController;
use BlogApp\Controller\AdminController;

require dirname(__DIR__).'/vendor/autoload.php';

$commentManager= new BlogApp\Manager\CommentManager();
$postManager= new BlogApp\Manager\PostManager();
$userManager= new BlogApp\Manager\UserManager();
$categoryManager= new BlogApp\Manager\CategoryManager();

session_start();

if(isset($_GET['p']))
{
	$page = $_GET['p']; 
}
elseif(isset($_GET['disconnect']))
{
	session_destroy();
	header('Location: home');
}
else
{
	$page = 'home';
}

		
if (!isset($_SESSION['auth']))
{ 
	$homeController = new HomeController($postManager, $userManager, $categoryManager, $commentManager) ;
	switch ($page) 
	{ 
		case $page==='home' : 
		$homeController->home();
		break ;

		case $page==='post' : 
		$homeController->post();
		break ;

		case $page==='single' : 
		$homeController->single();
		break ;

		case $page==='category' : 
		$homeController->category();
		break ;

		case $page==='sign_in' : 
		$homeController->signIn();
		break ;

		default : header('Location:index.php?p=home'); break ;
	}
}
else
{
	$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
	switch ($page) 
	{ 
		case $page==='user.home' : 
		$userController->userHome();
		break ;

		case $page==='user.edit' : 
		$userController->editUser();
		break ;

		case $page==='user.post.edit' : 
		$userController->editPost();
		break ;

		case $page==='user.post.add' : 
		$userController->addPost();
		break ;

		case $page==='admin.home' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$adminController->adminHome();
		break ;

		case $page==='admin.manage_user' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$adminController->manageUsers();
		break ;

		case $page==='admin.manage_category' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$adminController->manageCategories();
		break ;

		default : header('Location:index.php?disconnect');  break ;
	}
}








