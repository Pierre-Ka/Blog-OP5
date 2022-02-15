<?php
use BlogApp\Controller\CategoryController;
use BlogApp\Controller\CommentController;
use BlogApp\Controller\HomeController;
use BlogApp\Controller\PostController;
use BlogApp\Controller\SecurityController;
use BlogApp\Controller\UserController;
use BlogApp\Controller\Admin\CategoryAdminController;
use BlogApp\Controller\Admin\HomeAdminController;
use BlogApp\Controller\Admin\UserAdminController;
use BlogApp\Controller\Admin\PostAdminController;


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
		$homeController = new HomeController($postManager, $userManager, $categoryManager) ;
		$render = $homeController->home();
		break ;

        case $page==='mail' :
        $homeController = new HomeController($postManager, $userManager, $categoryManager) ;
        $render = $homeController->mail();
        break ;

		case $page==='post' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->list();
		break ;

		case $page==='single' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->show();
		break ;

        case $page==='comment_create' :
        $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $commentController->create();
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
		$render = $userController->create();
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
        $homeController = new HomeController($postManager, $userManager, $categoryManager) ;
        $render = $homeController->homeConnect();
		break ;

        case $page==='user.post_delete' :
        $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $postController->delete();
        break ;

		case $page==='user.edit' :
		$userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $userController->edit();
		break ;

        case $page==='user.edit_picture' :
        $userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $userController->editPicture();
        break ;

		case $page==='user.post.edit' : 
		$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->edit();
		break ;

        case $page==='user.comment_valid' :
        $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $commentController->valid();
        break ;

        case $page==='user.comment_delete' :
        $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $commentController->delete();
        break ;

		case $page==='user.post.add' : 
				$postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $postController->create();
		break ;

		case $page==='admin.home' : 
		$adminHomeController = new HomeAdminController($postManager, $userManager, $categoryManager, $commentManager) ;
		$render = $adminHomeController->home();
		break ;

        case $page==='admin.delete_post' :
        $postAdminController = new PostAdminController($postManager, $userManager, $categoryManager, $commentManager) ;
        $render = $postAdminController->delete();
        break ;

		case $page==='admin.manage_user' : 
		$adminUserController = new UserAdminController( $userManager, $categoryManager) ;
		$render = $adminUserController->list();
		break ;

        case $page==='admin.valid_user' :
        $adminUserController = new UserAdminController( $userManager, $categoryManager) ;
        $render = $adminUserController->valid();
        break ;

        case $page==='admin.delete_user' :
        $adminUserController = new UserAdminController( $userManager, $categoryManager) ;
        $render = $adminUserController->delete();
        break ;

		case $page==='admin.manage_category' : 
		$adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
		$render = $adminCategoryController->list();
		break ;

        case $page==='admin.edit_category' :
        $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
        $render = $adminCategoryController->edit();
        break ;

        case $page==='admin.delete_category' :
        $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
        $render = $adminCategoryController->delete();
        break ;

        case $page==='admin.create_category' :
        $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
        $render = $adminCategoryController->create();
        break ;

        default : header('Location:index.php?disconnect');  break ;
	}
	echo $render ;
}
