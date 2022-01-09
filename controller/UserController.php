<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;

class UserController extends ControllerParent
{
	public function __construct()
	{
		parent::__construct();
		// Be sure is connect
		if(!$user_manager->logged())
		{
			$this->forbidden();
		}
	}

	public function home()
	{
		$connect_id = $user_manager->getUserId();
		$posts = $post_manager->getWithUserId($connect_id);
		require('view/user/home.php');
	}

	public function editPost()
	{

	}

	public function addPost()
	{

	}

		public function edit()
	{

	}
	

}
