<?php

/* ICI COMMENCE L'ORIENTATION
SI !ISSET($_SESSION) ---> IL N'Y A PAS DE CONNECTEE*/

// CONTROLLER DEDIE AU CAS GENERAL

if (isset($_GET['list_all']))
	{
		$q_total=$post_manager->totalAllPostPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$q_post=$post_manager->getAllPost($actual_page);
		require('view/list_post.php');
	}
elseif (isset($_GET['list']) AND !empty($_GET['list']))
	{
		$info=htmlspecialchars($_GET['list']);
		$type= array("type1", "type2", "type3");
		if (in_array($info, $type))
		{
			$q_total=$post_manager->totalTypePostPages($info);
			if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
			{
				$actual_page =intval($_GET['page']);
			}
			else 
			{
				$actual_page = 1 ;
			}
			$q_post=$post_manager->getTypePost($info,$actual_page);
			require('view/list_post.php');
		}
		else
		{
			header('Location: index.php?list_all');
		}
	}

elseif (isset($_GET['post']) AND !empty($_GET['post']))
	{
		$info=htmlspecialchars(($_GET['post']));

		// A FAIRE !!!!!!!!!!
		// VERIF DU $_GET['post'] SIMILAIRE AU GET['page'] ci dessous à faire puis dans le else renvoyer vers list_all

		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'id_post'=> $info,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$comment_manager->addCom($comment);

		}

		$post=$post_manager->getPost($info);
		$q_total=$comment_manager->totalComPages($info);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$q_comment=$comment_manager->getCom($info,$actual_page);
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
