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

    public function create()
    {
        $authorCom = $this->requestPost['author_com'] ?? null;
        $contentCom = $this->requestPost['com'] ?? null;
        $postId= $this->requestGet['id'];
        if ($authorCom && $contentCom)
        {
            $comment= new Comment ([
                'post_id'=> $postId,
                'author'=> htmlspecialchars($authorCom ),
                'content'=>htmlspecialchars($contentCom),
            ]);
            $this->commentManager->add($comment);
        }
        $post=$this->postManager->getOne($postId);
        $authorId = $post->getUser_id();
        $author = $this->userManager->getOne($authorId);

        $maxPage=$this->commentManager->totalPages($postId);
        $comments = $this->commentManager->get($postId, 1);

        return $this->render('home/single.html.twig', [
            'post' => $post,
            'author' => $author,
            'comments' => $comments,
            'max_page' => $maxPage,
            'actual_page' => 1,
            'categories_header' => $this->categoryManager->getAll(),
            'last5Posts' => $this->postManager->getAll(1)
        ]);
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
