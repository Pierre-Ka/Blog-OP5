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

		/*
		switch ($_GET['list'])
		{
			case $_GET['list']==NULL:
			$number_page=$post_manager->total_post_pages('*');
			LISTPOST ()
			REQUIRE LIST POST VIEW
			break ;

			case $_GET['list'])==type1:
			$number_page=$post_manager->total_post_pages('type1');
			LISTPOST ()
			REQUIRE LIST POST VIEW
			break ;

			case $_GET['list'])==type2:
			$number_page=$post_manager->total_post_pages('type2');
			LISTPOST ()
			REQUIRE LIST POST VIEW
			break ;

			case $_GET['list'])==type3:
			$number_page=$post_manager->total_post_pages('type3');
			LISTPOST ()
			REQUIRE LIST POST VIEW
			break ;

		}

	SI $_GET('un_post')
		GETONEPOST ()
		REQUIRE UN POST VIEW

	SI $_GET('CONNEXION')
		REQUIRE CONNEXION VIEW

	*/

	else 
	{
	 	require('view/home.php');
	} 

	/*
		

DEUXIEMEMENT POUR LES CONNECTES
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
// DEBUT DES OPERATIONS EN BASE DE DONNEES
// $_POST('blabla')
PREMIERMENT OPERATION SANS ETRE CONNECTER

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


