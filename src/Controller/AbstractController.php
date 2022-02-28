<?php

namespace BlogApp\Controller;

abstract class AbstractController
{
    protected $twig;
    protected $instance;
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
}
