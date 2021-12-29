<?php
// ROUTEUR

require_once('init.php');
session_start();

// ICI COOKIE


if(isset($_GET['faker_user']))
{
	require('model/faker/faker_user.php');
}
if(isset($_GET['faker_post']))
{
	require('model/faker/faker_post.php');
}
if(isset($_GET['faker_com']))
{
	require('model/faker/faker_com.php');
}




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
	require('controller/non_user_controller.php');
}



