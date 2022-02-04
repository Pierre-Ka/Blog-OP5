<?php
use BlogApp\Controller\FrontController;
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
		$frontController->home();
		break ;

		case $page==='post' : 
		$frontController->post();
		break ;

		case $page==='single' : 
		$frontController->single();
		break ;

		case $page==='category' : 
		$frontController->category();
		break ;

		case $page==='sign_in' : 
		$frontController->signIn();
		break ;

		default : header('Location:index.php?p=home'); break ;
	}
}
else
{
	$backController = new BackController($postManager, $userManager, $categoryManager, $commentManager) ;
	switch ($page) 
	{ 
		case $page==='user.home' : 
		$backController->userHome();
		break ;

		case $page==='user.edit' : 
		$backController->editUser();
		break ;

		case $page==='user.post.edit' : 
		$backController->editPost();
		break ;

		case $page==='user.post.add' : 
		$backController->addPost();
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

