<?php

namespace BlogApp\Entity;

class Category extends Entity
{
    private $id;
    private string $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        if (ctype_digit($id)) {
            $this->id = $id;
        }
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
}
