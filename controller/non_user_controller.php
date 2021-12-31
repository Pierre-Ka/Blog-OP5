<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;

/* ICI COMMENCE L'ORIENTATION
SI !ISSET($_SESSION) ---> IL N'Y A PAS DE CONNECTEE*/

// Liste tous les articles
if (isset($_GET['list_all']))
	{
		$q_total=$post_manager->totalAllPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$posts=$post_manager->getAll($actual_page);
		require('view/list_post.php');
	}

// Liste les articles de certaines catégories
elseif (isset($_GET['list']) AND !empty($_GET['list']))
	{
		$infoType=htmlspecialchars($_GET['list']);
		$typePossible= array("type1", "type2", "type3");
		if (in_array($infoType, $typePossible))
		{
			$q_total=$post_manager->totalTypePages($infoType);
			if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
			{
				$actual_page =intval($_GET['page']);
			}
			else 
			{
				$actual_page = 1 ;
			}
			$posts=$post_manager->getType($infoType,$actual_page);
			require('view/list_post.php');
		}
		else
		{
			header('Location: index.php?list_all');
		}
	}

elseif (isset($_GET['post']) AND !empty($_GET['post']))
	{
		$IdPost=htmlspecialchars(($_GET['post']));

		// A FAIRE !!!!!!!!!!
		// VERIF DU $_GET['post'] SIMILAIRE AU GET['page'] ci dessous à faire puis dans le else renvoyer vers list_all


		// Soumission du formulaire de creation d'un commentaire
		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'id_post'=> $IdPost,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$comment_manager->add($comment);
		}

		$post=$post_manager->getOne($IdPost);
		$q_total=$comment_manager->totalPages($IdPost);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$comments = $comment_manager->get($IdPost,$actual_page);
		require('view/post.php');
	}

elseif (isset($_GET['sign_in'])) 
	{
		require('view/sign_in.php');
	}
elseif (isset($_GET['sign_up'])) 
	{
		require('view/sign_up.php');
	}

else 
	{
	 	require('view/home.php');
	} 
