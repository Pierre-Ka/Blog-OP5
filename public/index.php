<?php
use BlogApp\Router\Router;
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

if(!empty($_GET['p']))
{
	$page = $_GET['p'];
}
elseif(isset($_GET['disconnect']))
{
	session_destroy();
    header('Location:sign_in');
    exit;
}
else
{
	$page = 'home';
}

//////////////////////////////// ORIENTATION AVEC ROUTER //////////////////////////////////////////////////////////
///


$id = $_GET['id'] ?? null;
$pagination = ($_GET['page']) ?? null ;
$router = new Router($page, $id, $pagination);

if (!isset($_SESSION['auth']))
{
    switch ($page)
    {
        case $page==='home' :
            $homeController = new HomeController($postManager, $userManager, $categoryManager);
            $router->get('/home', static function () use ($homeController)
                {   echo $homeController->home();  }
            );
            break ;

        case $page==='mail' :
            $homeController = new HomeController($postManager, $userManager, $categoryManager) ;
            $router->post('/mail', static function () use ($homeController)
                {   echo $homeController->mail();   }
            );
            break ;

        case $page==='post' :
            $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/post/', static function () use ($postController)
            {  echo $postController->list();  },
            );
            $router->get('/post/:page', static function (int $page) use ($postController)
                {  echo $postController->list();  },
                    ['page' => '^\d+$']
            );
            break ;


        case $page==='single' :
            $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/single/:id', static function (int $id) use ($postController)
                {   echo $postController->show();    },
                    ['id' => '^\d+$']
            );
            $router->get('/single/:id/:page', static function (int $id, int $page) use ($postController)
            {   echo $postController->show();    },
                ['id' => '^\d+$',
                    'page' => '^\d+$']
            );
            break ;

        case $page==='comment_create' :
            $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->post('/comment_create/:id', static function (int $id) use ($commentController)
                {   echo $commentController->create();   },
                    ['id' => '^\d+$']
            );
            break ;

        case $page==='category' :
            $categoryController = new CategoryController($postManager, $categoryManager) ;
            $router->get('/category/:id', static function (int $id) use ($categoryController)
                {   echo $categoryController->listByCategory();    },
                    ['id' => '^\d+$']
            );
            $router->get('/category/:id/:page', static function (int $id, int $page) use ($categoryController)
            {   echo $categoryController->listByCategory();    },
                ['id' => '^\d+$',
                    'page' => '^\d+$']
            );
            break ;

        case $page==='sign_in' :
            $securityController = new SecurityController($userManager, $categoryManager) ;
            $router->get('/sign_in', static function () use ($securityController)
            {   echo $securityController->signIn();  }
            );
            $router->post('/sign_in', static function () use ($securityController)
                {   echo $securityController->signIn();  }
            );
            break ;

        case $page==='sign_up' :
            $userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->post('/sign_up', static function () use ($userController)
                {   echo $userController->create();   }
            );
            break ;

        default : header('Location:index.php?p=home'); break ;
    }
}
else
{
    switch ($page)
    {
        case $page==='user.home' :
            $homeController = new HomeController($postManager, $userManager, $categoryManager) ;
            $router->get('/user.home', static function () use ($homeController)
                {   echo $homeController->homeConnect();  }
            );
            break ;

        case $page==='user.post_delete' :
            $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->post('/user.post_delete/:id', static function (int $id) use ($postController)
                {   echo $postController->delete();  }
            );
            break ;

        case $page==='user.edit' :
            $userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/user.edit', static function () use ($userController)
            {   echo $userController->edit();  }
            );
            $router->post('/user.edit/:id', static function (int $id) use ($userController)
                {   echo $userController->edit();  }
            );
            break ;

        case $page==='user.edit_picture' :
            $userController = new UserController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->post('/user.edit_picture/:id', static function (int $id) use ($userController)
            {   echo $userController->editPicture();  }
            );
            break ;

        case $page==='user.post.edit' :
            $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/user.post.edit/:id', static function (int $id) use ($postController)
            {   echo $postController->edit();  }
            );
            $router->post('/user.post.edit/:id', static function (int $id) use ($postController)
            {   echo $postController->edit();  }
            );
            break ;

        case $page==='user.comment_valid' :
            $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/user.comment_valid/:id', static function (int $id) use ($commentController)
            {   echo $commentController->valid();  }
            );
            break ;

        case $page==='user.comment_delete' :
            $commentController = new CommentController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/user.comment_delete/:id', static function (int $id) use ($commentController)
            {   echo $commentController->delete();  }
            );
            break ;

        case $page==='user.post.add' :
            $postController = new PostController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/user.post.add', static function () use ($postController)
            {   echo $postController->create();  }
            );
            $router->post('/user.post.add', static function () use ($postController)
            {   echo $postController->create();  }
            );
            break ;

        case $page==='admin.home' :
            $adminHomeController = new HomeAdminController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->get('/admin.home', static function () use ($adminHomeController)
            {   echo $adminHomeController->home();  }
            );
            break ;

        case $page==='admin.delete_post' :
            $postAdminController = new PostAdminController($postManager, $userManager, $categoryManager, $commentManager) ;
            $router->post('/admin.delete_post', static function () use ($postAdminController)
            {   echo $postAdminController->delete();  }
            );
            break ;

        case $page==='admin.manage_user' :
            $adminUserController = new UserAdminController( $userManager, $categoryManager) ;
            $router->get('/admin.manage_user', static function () use ($adminUserController)
            {   echo $adminUserController->list();  }
            );
            break ;

        case $page==='admin.valid_user' :
            $adminUserController = new UserAdminController( $userManager, $categoryManager) ;
            $router->get('/admin.valid_user/:id', static function (int $id) use ($adminUserController)
            {   echo $adminUserController->valid();  }
            );
            break ;

        case $page==='admin.delete_user' :
            $adminUserController = new UserAdminController( $userManager, $categoryManager) ;
            $router->post('/admin.delete_user', static function () use ($adminUserController)
            {   echo $adminUserController->delete();  }
            );
            break ;

        case $page==='admin.manage_category' :
            $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
            $router->get('/admin.manage_category', static function () use ($adminCategoryController)
            {   echo $adminCategoryController->list();  }
            );
            break ;

        case $page==='admin.edit_category' :
            $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
            $router->post('/admin.edit_category/:id', static function (int $id) use ($adminCategoryController)
            {   echo $adminCategoryController->edit();  }
            );
            break ;

        case $page==='admin.delete_category' :
            $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
            $router->post('/admin.delete_category/:id', static function (int $id) use ($adminCategoryController)
            {   echo $adminCategoryController->delete();  }
            );
            break ;

        case $page==='admin.create_category' :
            $adminCategoryController = new CategoryAdminController($userManager, $categoryManager) ;
            $router->post('/admin.create_category', static function () use ($adminCategoryController)
            {   echo $adminCategoryController->create();  }
            );
            break ;

        default :
            session_destroy();
            header("Refresh:0");
            break ;

       /* default :
            header('Location:index.php?disconnect');
            exit;
            break ;*/
    }
}

$router->run();

/*
/////////////////////////////////////////// ORIENTATION TRADITIONNELLE ////////////////////////////////////////////////////
///



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
*/
