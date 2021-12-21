<?php
class UsersManager
{
	private $_db; // Instance de PDO

	public function __construct($db)
	{
		$this->setDb($db);
	}
// NO GETTER, ONLY SETTER
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
// OPERATION EN BDD
	// ajouter un user
	// modifier un user
	// valider un user
	// supprimer un user
	// getList all trier par plus recent

	public function add(UsersManager $user)

	public function count()

	public function delete(UsersManager $user)

	public function exists($info)

	public function get($info)

	public function getList ($nom)

	public function update(UsersManager $user)

}