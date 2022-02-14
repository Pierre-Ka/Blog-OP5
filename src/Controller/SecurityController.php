<?php
namespace BlogApp\Controller;

use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;


class SecurityController extends AbstractController
{
	protected UserManager $userManager;
	protected CategoryManager $categoryManager;
	
	function __construct(UserManager $userManager, CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->userManager = $userManager;
		$this->categoryManager = $categoryManager;
	}

	public function signIn()
	{
		if (!$_POST)
		{
			return $this->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoryManager->getAll()
					]);
		}
		else
		{
			$email = $this->requestPost['email'] ?? null;
	        $password = $this->requestPost['password'] ?? null;
			$incorrect=false;

			if ($email && $password)
			{
				$logged = $this->userManager->login($email, $password);
				if(!$logged)
				{			
					$incorrect=true;
					return $this->render('home/sign_in.html.twig', [
					'categories_header' => $this->categoryManager->getAll(),
					'incorrect' => $incorrect
						]);
				}
				else
				{
					header('Location: user.home'); 
				}	
			}
		}
	}
}
