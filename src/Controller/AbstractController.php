<?php
namespace BlogApp\Controller;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

abstract class AbstractController
{ 
    protected $twig;
    protected $instance;
    protected bool $idConnect; 
    protected $requestGet = []; 
    protected $requestPost = []; 

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../template');
        $twig = new \Twig\Environment($loader, [
            'debug' => true                 //'cache' => '/path/to/cache',
                ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig = $twig ;

        if (isset($_GET))
        {
            foreach ($_GET as $key => $value) 
            {
                $this->requestGet[$key] = htmlspecialchars($value) ;
            }
        }
        if (isset($_POST))
        {
            foreach ($_POST as $key => $value) 
            {
                $this->requestPost[$key] = htmlspecialchars($value) ;
            }
        }

        if (isset($_SESSION))
        {
            $this->isConnect = true ;
        }
    }

    protected function render(string $template, array $params = [])
    {
        return $this->twig->render($template, $params);
    }
    
    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Acces interdit');
    }


    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('Page introuvable');
    }
}

