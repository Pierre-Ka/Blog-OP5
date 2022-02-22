<?php

namespace BlogApp\Controller;

use BlogApp\Entity\Post;
use BlogApp\Manager\CategoryManager;
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;

class PostController extends AbstractController
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

    public function list($id = null, $page = null)
    {
        $maxPage = $this->postManager->totalPages();
        $actualPage = $page ?? 1;
        if (0 > $actualPage || $maxPage < $actualPage) {
            $actualPage = 1;
        }
        $posts = $this->postManager->getAll($actualPage);

        return $this->render('home/list.html.twig', [
            'posts' => $posts,
            'max_page' => $maxPage,
            'actual_page' => $actualPage,
            'categories_header' => $this->categoryManager->getAll(),
            'last5Posts' => $this->postManager->getAll(1)
        ]);
    }

    public function show($id, $page = null): string
    {
        $post = $this->postManager->getOne($id);
        if (!$post) {
            header('Location:index.php?p=home');
        }
        $authorId = $post->getUser_id();
        $author = $this->userManager->getOne($authorId);
        $maxPage = $this->commentManager->totalPages($id);
        $actualPage = $page ?? 1;
        if (0 > $actualPage || $maxPage < $actualPage) {
            $actualPage = 1;
        }
        $comments = $this->commentManager->get($id, $actualPage);

        return $this->render('home/single.html.twig', [
            'post' => $post,
            'author' => $author,
            'comments' => $comments,
            'max_page' => $maxPage,
            'actual_page' => $actualPage,
            'categories_header' => $this->categoryManager->getAll(),
            'last5Posts' => $this->postManager->getAll(1)
        ]);
    }

    public function edit($postId)
    {
        if (!$this->userManager->logged()) {
            $this->forbidden();
        }
        $post = $this->postManager->getOne($postId);
        $comments = $this->commentManager->getNotYetValid($postId);
        $categories = $this->categoryManager->getAll();

        if (!($_POST) && !($_FILES)) {

            return $this->render('user/post_edit.html.twig', [
                'post' => $post,
                'comments' => $comments,
                'categories' => $categories,
                'categories_header' => $this->categoryManager->getAll()
            ]);

        } else {
            if (isset($_FILES['pictureChange']) && ($_FILES['pictureChange']['error'] == 0) && ($_FILES['pictureChange']['size'] <= 5000000)) {
                $infosfichier = pathinfo($_FILES['pictureChange']['name']);
                $extensionUpload = $infosfichier['extension'];
                $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extensionUpload, $extensionsAutorisees)) {
                    move_uploaded_file($_FILES['pictureChange']['tmp_name'], '../var/media/post/POST_IMG_' . $postId . '.' . $extensionUpload);

                    $pictureName = 'POST_IMG_' . $postId . '.' . $extensionUpload;
                    $post->setPicture($pictureName);
                    $this->postManager->edit($post);
                    $widgetPath = '../var/media/post/MINI_POST_IMG_' . $postId . '.' . $extensionUpload;
                    $picturePath = '../var/media/post/POST_IMG_' . $postId . '.' . $extensionUpload;
                    $picture = $post->resizeImage($picturePath, $widgetPath, 60, 60);
                    $message = 'L\'image a été modifié avec succès';
                }
            }
            if ($_POST) {
                $titleChange = $this->requestPost['titleChange'] ?? null;
                $categoryChange = $this->requestPost['categoryChange'] ?? null;
                $chapoChange = $this->requestPost['chapoChange'] ?? null;
                $contentChange = $this->requestPost['contentChange'] ?? null;

                $post->setTitle(htmlspecialchars($titleChange));
                $post->setCategory_id($categoryChange);
                $post->setChapo(htmlspecialchars($chapoChange));
                $post->setContent(htmlspecialchars($contentChange));
                $this->postManager->edit($post);
                if (isset($message)) {
                    $message .= '<br/>Le post a été modifié avec succès';
                } else {
                    $message = 'Le post a été modifié avec succès';
                }
            }
            return $this->render('user/post_edit.html.twig', [
                'message' => $message,
                'post' => $post,
                'comments' => $comments,
                'categories' => $categories,
                'categories_header' => $this->categoryManager->getAll()
            ]);
        }
    }

    public function create()
    {
        if (!$this->userManager->logged()) {
            $this->forbidden();
        }
        if (!$_POST) {
            return $this->render('user/post_edit.html.twig', [
                'categories' => $this->categoryManager->getAll(),
                'categories_header' => $this->categoryManager->getAll()
            ]);
        } else {
            $title = $this->requestPost['title'] ?? null;
            $category = $this->requestPost['category'] ?? null;
            $chapo = $this->requestPost['chapo'] ?? null;
            $content = $this->requestPost['content'] ?? null;
            $categories = $this->categoryManager->getAll();

            $post = new Post([
                'title' => htmlspecialchars($title),
                'user_id' => $this->userManager->getUserId(),
                'category_id' => ($category),
                'chapo' => htmlspecialchars($chapo),
                'content' => htmlspecialchars($content)
            ]);

            $this->postManager->add($post);
            $newId = $this->postManager->getLastInsertId();

            if (isset($_FILES['picture']) && ($_FILES['picture']['error'] == 0) && ($_FILES['picture']['size'] <= 5000000)) {
                $infosfichier = pathinfo($_FILES['picture']['name']);
                $extensionUpload = $infosfichier['extension'];
                $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extensionUpload, $extensionsAutorisees)) {
                    $pictureName = 'POST_IMG_' . $newId . '.' . $extensionUpload;
                    $picturePath = '../var/media/post/' . $pictureName;
                    move_uploaded_file($_FILES['picture']['tmp_name'], $picturePath);
                    $post->setPicture($pictureName);
                    $post->setId($newId);
                    $this->postManager->edit($post);
                    $widgetPath = '../var/media/post/MINI_POST_IMG_' . $newId . '.' . $extensionUpload;
                    $picture = $post->resizeImage($picturePath, $widgetPath, 60, 60);
                    $message = ' L\'article et l\'image ont été ajouté avec succès ';

                    return $this->render('user/post_edit.html.twig', [
                        'categories' => $categories,
                        'message' => $message,
                        'categories_header' => $this->categoryManager->getAll()
                    ]);
                } else {
                    $message = ' L\'article a été rajouté avec succès ';
                    return $this->render('user/post_edit.html.twig', [
                        'categories' => $categories,
                        'message' => $message,
                        'categories_header' => $this->categoryManager->getAll()
                    ]);
                }
            } else {
                $message = ' L\'article a été rajouté avec succès';
                return $this->render('user/post_edit.html.twig', [
                    'categories' => $categories,
                    'message' => $message,
                    'categories_header' => $this->categoryManager->getAll()
                ]);
            }
        }
    }

    public function delete($idPostDelete)
    {
        if (!$this->userManager->logged()) {
            $this->forbidden();
        }
        $idPostDelete = $this->requestPost['id_delete'] ?? null;
        if ($idPostDelete) {
            $this->postManager->delete($idPostDelete);
            $this->commentManager->deletePerPost($idPostDelete);
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
