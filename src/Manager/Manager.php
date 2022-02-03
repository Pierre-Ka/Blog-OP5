<?php
namespace BlogApp\Manager;

abstract class Manager
{
	protected $_db;
	protected $uniqid;
	protected $instance;

	public function __construct($db) // __construct(\PDO $db) : void
	{
		$this->setDb($db);
		$this->uniqid = uniqid();
		//$this->instance = static::CLASS_NAME ;
		//$this->instance = get_class($this);
	}
	/*
			$this->db = new \PDO('mysql:host=localhost;dbname=project5_dev;charset=utf8', 'root', 'root');
		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
		// If $instance
	*/

	public function setDb(\PDO $db)
	{
		$this->_db = $db;
	}

	public function getLastInsertId()
	{
		return $this->_db->lastInsertId();
	}
}
