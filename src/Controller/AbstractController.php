<?php

namespace BlogApp\Controller;

abstract class AbstractController
{
    protected $twig;
    protected $instance;
    protected bool $isConnect;
    protected $requestGet = [];
    protected $requestPost = [];

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../template');
        $twig = new \Twig\Environment($loader, [
            'debug' => true
            //'cache' => '/path/to/cache',
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig = $twig;
        if (isset($_GET)) {
            foreach ($_GET as $key => $value) {
                $this->requestGet[$key] = htmlspecialchars($value);
            }
        }
        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->requestPost[$key] = htmlspecialchars($value);
            }
        }
        if (isset($_SESSION)) {
            $this->isConnect = true;
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

    protected function getDataFromPost()
    {
        $data = [];
        foreach ($_POST as $value) {
            $data[] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function isMethodPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getDataFromGet()
    {
        $data = [];
        foreach ($_GET as $value) {
            $data[] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function isMethodGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
