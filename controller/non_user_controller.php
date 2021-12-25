<?php

/* ICI COMMENCE L'ORIENTATION
SI !ISSET($_SESSION) ---> IL N'Y A PAS DE CONNECTEE*/

// CONTROLLER DEDIE AU CAS GENERAL

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
elseif (isset($_GET['list']) AND !empty($_GET['list']))
	{
		$info=htmlspecialchars($_GET['list']);
		$type= array("type1", "type2", "type3");
		if (in_array($info, $type))
		{
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
			$comment= new Comments ([
			'id_post'=> $info,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$comment_manager->add_com($comment);

		}

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
