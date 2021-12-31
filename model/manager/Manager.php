<?php
namespace Project5;

abstract class Manager
{
	protected $_db; // Instance de PDO

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function setDb(\PDO $db)
	{
		$this->_db = $db;
	}
}