<?php
namespace BlogApp\Manager;

abstract class Manager
{
	protected $_db;
	protected $uniqid;
	protected $instance;

	public function __construct($db)
	{
		$this->setDb($db);
		$this->uniqid = uniqid();
		//$this->instance = static::CLASS_NAME ;
		//$this->instance = get_class($this);
	}

	public function setDb(\PDO $db)
	{
		$this->_db = $db;
	}

	public function getLastInsertId()
	{
		return $this->_db->lastInsertId();
	}
}