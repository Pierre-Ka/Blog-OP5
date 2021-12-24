<?php
// ROUTEUR

require_once('init.php');
session_start();

// ICI COOKIE

if (isset($_SESSION['user'])) // Si la session de l'utilisateur existe, on restaure l'objet.
{
  $perso = $_SESSION['user'];
}

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




/* ICI COMMENCE L'ORIENTATION
PREMIEREMENT POUR LES NON CONNECTES
SI !ISSET($_SESSION) ---> IL N'Y A PAS DE CONNECTEE*/

// CREATION D'UN CONTROLLER DEDIE
	if (isset($_GET['list_all']))
	{
		$q_total=$post_manager->total_all_post_pages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$q_post=$post_manager->get_all_post($actual_page);
		require('view/list_post.php');
	}
	elseif (isset($_GET['list']))
	{
		// VERIF DU $_GET['list'] SIMILAIRE AU GET['page'] ci dessous à faire puis dans le else renvoyer vers list_all
		$info=$_GET['list'];
		$q_total=$post_manager->total_type_post_pages($info);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$q_post=$post_manager->get_type_post($info,$actual_page);
		require('view/list_post.php');
	}

	elseif (isset($_GET['post']))
	{
		// VERIF DU $_GET['post'] SIMILAIRE AU GET['page'] ci dessous à faire puis dans le else renvoyer vers list_all

		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comments ([
			'id_post'=> $_GET['post'],
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$comment_manager->add_com($comment);

		}

		$info=$_GET['post'];
		$post=$post_manager->get_post($info);
		$q_total=$comment_manager->total_com_pages($info);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$q_comment=$comment_manager->get_com($info,$actual_page);
		require('view/post.php');
	}

	elseif (isset($_GET['sign_in'])) 
	{
		require('view/sign_in.php');
	}

	else 
	{
	 	require('view/home.php');
	} 

/* ICI L'ORIENTATION POUR LES NON-CONNECTES EST FINIE

DEUXIEMEMENT ORIENTATION POUR LES CONNECTES

SI ISSET($_SESSION) ---> IL Y A UN CONNECTEE
	AND IF $_session('type')='admin'
		REQUIRE VIEW ADMIN TOTAL
	SI $_GET('AJOUT')
		REQUIRE AJOUT
	SI $_GET('MODIF')
		REQUIRE MODIF
	SI $_GET('SUPPRIM')
		REQUIRE SUPPRIM
	SI $_GET('PROFIL')
		REQUIRE PROFIL
	ELSE 
		REQUIRE MENU

// FIN DE L'ORIENTATION
// OPERATION EN BDD POUR CONNECTES

IF $_POST('createcom
	enregistrement bdd statut non verif

IF $_POST('pseudo and $_POST('password
	verif connexion

IF $_POST('newpseudo, $_POST('newpassword, $_POST('email
	$_POST('blabla, $_POST('blabla, 
	create new member statut non verif

DEUXIEMEMENT OPERATIONS QUI REQUIERENT LA CONNEXION
condition : isset($_session) AND not null

IF $_POST('ajout
	ajout post

IF $_POST('modif
	modif post

IF $_POST('delete
	delete post

IF $_POST('profilediting
	update profil_user

IF $_GET('confirm_id_com')
	comm is_valid

TROISIEMENT OPERATIONS QUI REQUIERENT LA CONNEXION ET LE TYPE 'ADMIN'
condition : isset($_session) + $_session('type')='admin'

IF $_GET('confirm_id_user')
	user is_valid


FIN DU ROUTEUR
*/


