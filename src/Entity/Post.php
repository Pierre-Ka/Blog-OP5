<?php

namespace BlogApp\Entity;

use BlogApp\Manager\CommentManager;

class Post extends Entity
{
    private $id;
    private string $title;
    private int $user_id;
    private int $category_id;
    private string $chapo;
    private string $content;
    private string $picture;
    private $last_update;
    private $create_date;

    private string $category;
    private string $user;
    private int $commentNotYetValid;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUser_id(): int
    {
        return $this->user_id;
    }

    public function getCategory_id(): int
    {
        return $this->category_id;
    }

    public function getChapo(): string
    {
        return $this->chapo;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getLast_update()
    {
        return $this->last_update;
    }

    public function getCreate_date()
    {
        return $this->create_date;
    }

    public function setId($id)
    {
        if (ctype_digit($id)) {
            $this->id = $id;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    public function setUser_id($user_id)
    {
        $user_id = (int)$user_id;
        if ($user_id > 0) {
            $this->user_id = $user_id;
        }
    }

    public function setCategory_id($category_id)
    {
        $category_id = (int)$category_id;
        if ($category_id > 0) {
            $this->category_id = $category_id;
        }
    }

    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->chapo = $chapo;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setPicture($picture)
    {
        if (is_string($picture)) {
            $this->picture = $picture;
        }
    }

    public function setLast_update($last_update)
    {
            $this->last_update = $last_update;
    }

    public function setCreate_date($create_date)
    {
            $this->create_date = $create_date;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setCommentNotYetValid($commentNotYetValid)
    {
        $this->commentNotYetValid = $commentNotYetValid;
    }

    public function getCommentNotYetValid(): int
    {
        return $this->commentNotYetValid;
    }

    /*public function getCommentNotYetValid(): int
    {
        $db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        $comment_manager = new CommentManager($db);
        $count = $comment_manager->countNotYetValid($this->id);
        return $count;
    }*/
}
