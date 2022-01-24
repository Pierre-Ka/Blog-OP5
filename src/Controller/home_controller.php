<?php
use BlogApp\Entity\Comment;
use BlogApp\Entity\Post;
use BlogApp\Entity\User;
use BlogApp\Entity\Category;

if($page==='home')
	{
		require('view/home/home.php');
	}
elseif($page==='post')
	{
		$q_total=$postManager->totalPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$posts=$postManager->getAll($actual_page);
		require('view/home/post.php');
	}


elseif($page==='category')
	{
		$category_id=htmlspecialchars($_GET['id']);
		$category = $categoryManager->getOne($category_id);
		$q_total=$postManager->totalPagesByCategory($category_id);
			
		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
			{
				$actual_page =intval($_GET['page']);
			}
		else 
			{
				$actual_page = 1 ;
			}
		$posts=$postManager->getWithCategory($category_id,$actual_page);
		require('view/home/category.php');
	}
	

elseif($page==='single')
	{
		$post_id= $_GET['id'];
		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'post_id'=> $post_id,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$commentManager->add($comment);
		}

		$post=$postManager->getOne($post_id);
		$q_total=$commentManager->totalPages($post_id);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$comments = $commentManager->get($post_id,$actual_page);
		require('view/home/single.php');
	}

elseif($page==='sign_in')
	{
		$incorrect=false;
		if (!empty($_POST['email']) AND !empty($_POST['password']))
		{
			$logged = $userManager->login($_POST['email'], $_POST['password']);
			if($logged)
			{			
				header('Location:index.php?p=user.home');
			}
			else
			{
				$incorrect=true;
				require('view/home/sign_in.php');
			}
		}
		if ( isset($_POST['emailCreate']) AND !empty($_POST['emailCreate']) AND
			isset($_POST['nameCreate']) AND !empty($_POST['nameCreate']) AND
			isset($_POST['passwordCreate']) AND !empty($_POST['passwordCreate']) AND
			isset($_POST['passwordConfirm']) AND !empty($_POST['passwordConfirm']) AND
			isset($_POST['descriptionCreate']) AND !empty($_POST['descriptionCreate']))
		{
			if (($_POST['passwordCreate'])===($_POST['passwordConfirm']))
			{
				if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['emailCreate']))
				{
					$user = new User([
					'email'=> htmlspecialchars($_POST['emailCreate']),
					'password'=> htmlspecialchars($_POST['passwordConfirm']),
					'name'=> htmlspecialchars($_POST['nameCreate']),
					'description'=> htmlspecialchars($_POST['descriptionCreate'])
					]);
					$userManager->add($user);
					$message = 'enregistrement reussi';
					require('view/home/sign_in.php');

				}
				else
				{
					$incorrect=true;
					require('view/home/sign_in.php');
				}
			}
			else
			{
				$incorrect=true;
				require('view/home/sign_in.php');
			}
		}
		else 
		{
			require('view/home/sign_in.php');
		}
	}


