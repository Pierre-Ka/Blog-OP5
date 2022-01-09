<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;

abstract class AuthController extends ControllerParent
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
}
