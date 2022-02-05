<?php
namespace BlogApp\Controller;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

abstract class AbstractController
{ 
    protected PostManager $postManager;
    protected UserManager $userManager;
    protected CategoryManager $categoryManager;
    protected CommentManager $commentManager;
    public $categoriesHeader;
    protected $twig;
    protected $instance;
    protected $requestGet = []; 
    protected $requestPost = []; 

    public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        $this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
        $this->categoriesHeader = $this->categoryManager->getAll();
        $loader = new \Twig\Loader\FilesystemLoader('../template');
        $twig = new \Twig\Environment($loader, [
            'debug' => true
            //'cache' => '/path/to/cache',
                ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig = $twig ;
        if (isset($_GET))
        {
            foreach ($_GET as $key => $value) 
            {
                $this->requestGet[$key] = $value ;
            }
        }
        if (isset($_POST))
        {
            foreach ($_POST as $key => $value) 
            {
                $this->requestPost[$key] = $value ;
            }
        }
    }
    
    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }

   // $_POST[$truc] = $truc()

    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }



}
