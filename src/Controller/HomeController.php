<?php

namespace BlogApp\Controller;

use BlogApp\Mailer\MyMailer;
use BlogApp\Manager\CategoryManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;

class HomeController extends AbstractController
{
    protected PostManager $postManager;
    protected CategoryManager $categoryManager;
    protected UserManager $userManager;

    function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager)
    {
        parent::__construct();
        $this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
    }

    public function mail()
    {
        $message = $this->requestPost['message'] ?? null;
        $messageEmail = $this->requestPost['message-email'] ?? null;
        if ($message && $messageEmail) {
            $monmail = new MyMailer();
            $MessageFormat = $monmail->formatMail($messageEmail, $message);
            $return = $monmail->SendTheMail($MessageFormat);
            echo $return;
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

    public function homeConnect()
    {
        if (!$this->userManager->logged()) {
            $this->forbidden();
        }
        $connectId = $this->userManager->getUserId();
        $posts = $this->postManager->getByUserId($connectId);
        $user = $this->userManager->getOne($connectId);
        $admin = $this->userManager->isAdmin($connectId);

        return $this->render('user/home.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'admin' => $admin,
            'categories_header' => $this->categoryManager->getAll()
        ]);
    }
}
