<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;

class AdminController extends UserController
{
	public function __construct()
	{
		parent::__construct();
		// Be sure is connect
		if(!$user_manager->is_admin())
		{
			$this->forbidden();
		}
	}

	public function home()
	{
		require('view/admin/home.php');
	}

	

}
