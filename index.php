<?php
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


// ORIENTATION GENERALE

if($page==='home')
{
	//$controller = new PostController() ;
	//$controller->home();
	require('controller/home_controller.php');
}
elseif($page==='post')
{
	//$controller = new PostController();
	//$controller->post();
	require('controller/home_controller.php');
}
elseif($page==='single')
{
	//$controller = new PostController ;
	//$controller->single();
	require('controller/home_controller.php');
}
elseif($page==='category')
{
	//$controller = new PostController ;
	//$controller->category();
	require('controller/home_controller.php');
}
elseif($page==='sign_in')
{
	//$controller = new PostController ;
	//$controller->sign_in();
	//$controller->sign_up();
	require('controller/home_controller.php');
}
elseif($page==='user.home')
{
	//$controller = new UserController ;
	//$controller->home();
	require('controller/user_controller.php');
}
elseif($page==='user.edit')
{
	//$controller = new UserController ;
	//$controller->edit();
	require('controller/user_controller.php');
}
elseif($page==='user.post.edit')
{
	//$controller = new UserController ;
	//$controller->editpost();
	//$controller->managecom();
	require('controller/user_controller.php');
}
elseif($page==='user.post.add')
{
	//$controller->addpost();
	require('controller/user_controller.php');
}
elseif($page==='admin.home')
{
	require('controller/admin_controller.php');
}
elseif($page==='admin.manage_user')
{
	require('controller/admin_controller.php');
}

elseif($page==='admin.manage_category')
{
	require('controller/admin_controller.php');
}









elseif($page==='faker_user')
{
	require('model/faker/faker_user.php');
}

elseif($page==='faker_post')
{
	require('model/faker/faker_post.php');
}

elseif($page==='faker_comment')
{
	require('model/faker/faker_comment.php');
}


/*
if (isset($_SESSION['user'])) // Si la session de l'utilisateur existe, on restaure l'objet.
{
  	$user = $_SESSION['user'];
  	if (isset($_GET['sign_out']))
	{
		session_destroy();
		// DESTRUCTION DU COOKIE ?
		// 	setcookie('pseudo', '');
		//  setcookie('pass', '');
		unset($user);
		header('Location: .');
		exit();
	}
	else
	{
		require('controller/user_controller.php');
	}

}

else
{
	require('controller/home_controller.php');
}
*/


