<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;

class PostController extends ControllerParent
{
	public function home()
	{
		require('view/home/home.php');
	}

	public function post()
	{
		$q_total=$post_manager->totalPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$posts=$post_manager->getAll($actual_page);
		require('view/home/post.php');
	}

	public function category()
	{
		$category_id=htmlspecialchars($_GET['id']);
		$q_total=$post_manager->totalPagesByCategory($category_id);
			
		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
			{
				$actual_page =intval($_GET['page']);
			}
		else 
			{
				$actual_page = 1 ;
			}
		$posts=$post_manager->getWithCategory($category_id,$actual_page);
		require('view/home/category.php');
	}

	public function single()
	{
		$post_id= $_GET['id'];
		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'post_id'=> $post_id,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$comment_manager->add($comment);
		}

		$post=$post_manager->getOne($post_id);
		$q_total=$comment_manager->totalPages($post_id);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$q_total)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$comments = $comment_manager->get($post_id,$actual_page);
		require('view/home/single.php');
	}

	public function sign_in()
	{
		$incorrect=false;
		if (!empty($_POST['email']) AND !empty($_POST['password']))
		{
			$logged = $user_manager->login($_POST['email'], $_POST['password']);
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
		else 
		{
			require('view/home/sign_in.php');
		}	
	}

}
