<?php
namespace BlogApp\Controller;

use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;


class HomeController extends AbstractController
{
	protected PostManager $postManager;
	protected CategoryManager $categoryManager;
	
	function __construct(PostManager $postManager, CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->postManager = $postManager;
		$this->categoryManager = $categoryManager;
	}
	
	
	public function mail()
	{
		$message = $this->requestPost['message'] ?? null;
        $messageEmail = $this->requestPost['message-email'] ?? null;

		if ($message && $messageEmail)  
		{
            $monmail = new MyMailer();
            $MessageFormat = $monmail->formatMail($messageEmail, $message);
            $return = $monmail->SendTheMail($MessageFormat); 
            echo $return ; 
            header('Location: home');  
        }

    }
	public function home()
	{
		return $this->render('home/home.html.twig', [
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
				]);				
	}

}
