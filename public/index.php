<?php
use BlogApp\Controller\FrontController;
use BlogApp\Controller\PostController;
use BlogApp\Controller\BackController;
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
	$frontController = new FrontController($postManager, $userManager, $categoryManager, $commentManager) ;
	switch ($page) 
	{ 
		case $page==='home' : 
		$render = $frontController->home();
		break ;

		case $page==='post' : 
		$render = $frontController->list();
		break ;

		case $page==='single' : 
		$render = $frontController->single();
		break ;

		case $page==='category' : 
		$render = $frontController->listByCategory();
		break ;

		case $page==='sign_in' : 
		$render = $frontController->signIn();
		break ;

		case $page==='sign_up' : 
		$render = $frontController->signUp();
		break ;

		default : header('Location:index.php?p=home'); break ;
	}
	echo $render ;
}
else
{
	$backController = new BackController($postManager, $userManager, $categoryManager, $commentManager) ;
	switch ($page) 
	{ 
		case $page==='user.home' : 
		$render = $backController->userHome();
		break ;

		case $page==='user.edit' : 
		$render = $backController->editUser();
		break ;

		case $page==='user.post.edit' : 
		$render = $backController->editPost();
		break ;

		case $page==='user.post.add' : 
		$render = $backController->addPost();
		break ;

		case $page==='admin.home' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $adminController->adminHome();
		break ;

		case $page==='admin.manage_user' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $adminController->manageUsers();
		break ;

		case $page==='admin.manage_category' : 
		$adminController = new AdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $adminController->manageCategories();
		break ;

		default : header('Location:index.php?disconnect');  break ;
	}
	echo $render ;
}

