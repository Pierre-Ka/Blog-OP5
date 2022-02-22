<?php

namespace BlogApp\Manager;

abstract class Manager
{
    protected $_db;
    public $uniqid;
    protected $instance;

    public function __construct()
    {
        if (empty($this->instance)) {
            $this->_db = new \PDO('mysql:host=localhost;dbname=project5_dev;charset=utf8', 'root', 'root');
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            $this->instance = $this->_db;
            $this->uniqid = uniqid();
        } else {
            $this->_db = $this->instance;
        }
    }

    public function getLastInsertId()
    {
        return $this->_db->lastInsertId();
    }
}
