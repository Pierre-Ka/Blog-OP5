<?php
use BlogApp\Controller\CategoryController;
use BlogApp\Controller\HomeController;
use BlogApp\Controller\PostController;
use BlogApp\Controller\SecurityController;
use BlogApp\Controller\UserController;
use BlogApp\Controller\Admin\CategoryAdminController;
use BlogApp\Controller\Admin\HomeAdminController;
use BlogApp\Controller\Admin\UserAdminController;

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
	switch ($page) 
	{ 
		case $page==='home' : 
		$homeController = new HomeController($postManager, $categoryManager,) ;
		$render = $homeController->home();
		break ;

		case $page==='post' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->list();
		break ;

		case $page==='single' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->single();
		break ;

		case $page==='category' : 
		$categoryController = new CategoryController($postManager, $categoryManager) ;
		$render = $categoryController->listByCategory();
		break ;

		case $page==='sign_in' : 
		$securityController = new SecurityController($userManager, $categoryManager) ;
		$render = $securityController->signIn();
		break ;

		case $page==='sign_up' : 
		$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $userController->add();
		break ;

		default : header('Location:index.php?p=home'); break ;
	}
	echo $render ;
}
else
{
	switch ($page) 
	{ 
		case $page==='user.home' : 

		$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $userController->userHome();
		break ;

		case $page==='user.edit' :

				$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $userController->editUser();
		break ;

		case $page==='user.post.edit' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->editPost();
		break ;

		case $page==='user.post.add' : 
				$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->addPost();
		break ;

		case $page==='admin.home' : 
		$adminHomeController = new HomeAdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $adminHomeController->adminHome();
		break ;

		case $page==='admin.manage_user' : 
		$adminUserController = new UserAdminController( $userManager, $categoryManager) ;
		$render = $adminUserController->manageUsers();
		break ;

		case $page==='admin.manage_category' : 
		$adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
		$render = $adminCategoryController->manageCategories();
		break ;

		default : header('Location:index.php?disconnect');  break ;
	}
	echo $render ;
}
