<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;

use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CommentManager;


class CommentController extends AbstractController
{
    protected PostManager $postManager;
    protected UserManager $userManager;
    protected CategoryManager $categoryManager;
    protected CommentManager $commentManager;

    function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        parent::__construct();
        $this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
    }

    public function valid()
    {
        if(!$this->userManager->logged())
        {
            $this->forbidden();
        }
        $commentId = $this->requestGet['id'] ?? null;

        $comment = $this->commentManager->getOne($commentId);
        $postId = $comment->getPost_id();

        $this->commentManager->valid($commentId);
        $post = $this->postManager->getOne($postId);
        $comments = $this->commentManager->getNotYetValid($postId);
        $categories = $this->categoryManager->getAll();

        return $this->render('user/post_edit.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'categories' => $categories,
            'categories_header' =>$this->categoryManager->getAll()
        ]);
    }
    public function delete()
    {
        if(!$this->userManager->logged())
        {
            $this->forbidden();
        }
        $commentId = $this->requestGet['id'] ?? null;

        $comment = $this->commentManager->getOne($commentId);
        $postId = $comment->getPost_id();

        $this->commentManager->delete($commentId);
        $post = $this->postManager->getOne($postId);
        $comments = $this->commentManager->getNotYetValid($postId);
        $categories = $this->categoryManager->getAll();

        return $this->render('user/post_edit.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'categories' => $categories,
            'categories_header' =>$this->categoryManager->getAll()
        ]);
    }
}
