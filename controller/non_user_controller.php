<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;


if($page==='home')
{
	require('view/home/home.php');
}

elseif($page==='post')
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

elseif($page==='category')
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

elseif($page==='sign_in')
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

elseif($page==='user.home')
{
	if($user_manager->logged())
	{

		$connect_id = $user_manager->getUserId();
		$posts = $post_manager->getWithUserId($connect_id);
		require('view/user/home.php');
	}
	else
	{
		$incorrect=true;
		require('view/home/sign_in.php');
	}
}
elseif($page==='user.edit')
{

}
elseif($page==='user.post.edit')
{
	$post = $post_manager->getOne($_GET['id']);
	if(empty($_POST))
	{
		if(!empty($_GET['valid']) OR !empty($_GET['delete']))
		{
			switch ($_GET)
			{
				case !empty($_GET['valid']) :
				$comment_manager->valid(($_GET['valid']));
				break ;
				case !empty($_GET['delete']) : 
				$comment_manager->delete(($_GET['delete']));
				break ;
			}
		}
		$comments = $comment_manager->getNotYetValid($_GET['id']);
		$categories = $category_manager->getAll();
		require('view/user/post/edit.php');
		
	}
	else
	{
		switch ($_POST)
		{
				case !empty($_POST['titleChange']) :
			$post->setTitle(htmlspecialchars($_POST['titleChange'])); 

				case !empty($_POST['categorieChange']) :
					if (($_POST['categorieChange'])!= null)
						{
							$category_id = $category_manager->getCategoryId($_POST['categorieChange']);
							$post->setCategory_id(htmlspecialchars($category_id));
						}
				case !empty($_POST['chapoChange']) :	
			$post->setChapo(htmlspecialchars($_POST['chapoChange'])); 

				case !empty($_POST['contentChange']) :
			$post->setContent(htmlspecialchars($_POST['contentChange']));

				case !empty($_POST['pictureChange']) :
			$post->setPicture(htmlspecialchars($_POST['pictureChange']));
		}
		$post_manager->edit($post);
		header('Location:index.php?p=user.home');
	}
}
elseif($page==='user.post.add')
{

	$categories = $category_manager->getAll();
	require('view/user/post/add.php');

}
elseif($page==='user.com.edit')
{

}
elseif($page==='admin.home')
{

}
