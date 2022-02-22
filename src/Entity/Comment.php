<?php

namespace BlogApp\Entity;

class Comment extends Entity
{
    private $id;
    private $post_id;
    private string $author;
    private string $content;
    private bool $is_valid;
    private $create_date;

    public function getId()
    {
        return $this->id;
    }

    public function getPost_id()
    {
        return $this->post_id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getIs_valid()
    {
        return $this->is_valid;
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

    public function setPost_id($post_id)
    {
        $post_id = (int)$post_id;
        if ($post_id > 0) {
            $this->post_id = $post_id;
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->author = $author;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setIs_valid($is_valid)
    {
        $is_valid = (int)$is_valid;
        if ($is_valid >= 0 && $is_valid < 2) {
            $this->is_valid = $is_valid;
        }
    }

    public function setCreate_date($create_date)
    {
        $this->create_date = $create_date;
    }
}
