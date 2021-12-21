<?php
class PostsManager
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
	// ajouter un post
	// modif un post
	// supprimer un post
	// systeme de pagination : 
	//	- la fonction totalPostPages ();=$pagestotales;
	//  - la fonction actualPostPage ();=$pagecourante;
	//  - la fonction getPostPerPage (); =$comReq;
	//	-

	public function add(Posts $post)

	public function count()

	public function delete(Posts $post)

	public function exists($info)

	public function get($info)

	public function getList ($nom)

	public function update(Posts $post)

}