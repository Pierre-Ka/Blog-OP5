<?php

namespace BlogApp\Controller\Admin;

use BlogApp\Controller\AbstractController;
use BlogApp\Manager\CategoryManager;
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;

class PostAdminController extends AbstractController
{
    protected UserManager $userManager;
    protected PostManager $postManager;
    protected CommentManager $commentManager;
    protected CategoryManager $categoryManager;

    public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->categoryManager = $categoryManager;
        if (!$this->userManager->isAdmin()) {
            $this->forbidden();
        }
    }

    public function delete()
    {
        $adminPostDelete = $this->requestPost['admin_post_delete'] ?? null;
        if ($adminPostDelete) {
            $this->postManager->delete($adminPostDelete);
            $this->commentManager->deletePerPost($adminPostDelete);
        }
        $posts = $this->postManager->getAllAdmin();

        return $this->render('admin/home.html.twig', [
            'posts' => $posts,
            'categories_header' => $this->categoryManager->getAll()
        ]);
    }
}
