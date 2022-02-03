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
    public $categories_header;
    protected $twig;

    public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        $this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
        $this->categories_header = $this->categoryManager->getAll();
        $loader = new \Twig\Loader\FilesystemLoader('../template');
        $twig = new \Twig\Environment($loader, [
        'debug' => true
        //'cache' => '/path/to/cache',
         ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig = $twig ;
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
