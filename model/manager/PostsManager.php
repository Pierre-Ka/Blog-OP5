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
	// get post -> devient objet post
	// supprimer un post
	// systeme de pagination : 
	//	- la fonction totalPostPages ();=$pagestotales;
	//  - la fonction actualPostPage ();=$pagecourante;
	//  - la fonction getPostPerPage (); =$comReq;
	//	-

	public function addPost(Post $post)
	{
		$q = $this->_db->prepare('INSERT INTO posts(title, id_user, type, chapo, content, picture, create_date) VALUES(:title,:id_user,:type, :chapo, :content, :picture, CURDATE())');
		$q->bindValue('title', $post->getTitle());
		$q->bindValue('id_user', $post->getId_user());
		$q->bindValue('type', $post->getType());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->bindValue('picture', $post->getPicture());
		$q->execute();
		// ici : Hydratation ou pas ?
	}

	public function editPost(Post $post)
	{
		$q = $this->_db->prepare('UPDATE posts SET title = :title, type = :type, chapo = :chapo, content = :content, picture = :picture, last_update = CURDATE() WHERE id = :id');
		$q->bindValue('id', $user->getId());
		$q->bindValue('title', $user->getTitle());
		$q->bindValue('type', $user->getType());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->bindValue('picture', $user->getPicture());
		$q->execute();
		// ici : REhydratation
	}

	public function getPost($info)
	{ // Ici get s'obtient avec un $_GET id
		if (ctype_digit($info))
		{
			$q = $this->_db->query('SELECT * FROM posts WHERE id=' .$info);
			$data=$q->fetch()/*(PDO::FETCH_ASSOC)???*/;
			return new Post($data);
		}
	}

	public function deletePost($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->exec('DELETE FROM posts WHERE id=' .$info);
		}
	} // SI L'OBJET USER A ETE CREE IL FAUT ALORS L'UNSET?


/* 2 cas de figure : 
	on demande tous les posts
	on demande les posts d'une certaine categorie */

	public function totalAllPostPages ()
	{
		$post_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM posts') ;
		$post_total = $q->rowCount(); 
		$total_all_pages = ceil($post_total/$post_per_page);return $total_all_pages;
	}

	public function totalTypePostPages ($info)
	{ 
		$type= array("type1", "type2", "type3");
		if (in_array($info, $type))
		{

			$post_per_page = 4 ;
			$q = $this->_db->query('SELECT id FROM posts WHERE type= "' .$info. '"') ;
			$post_total = $q->rowCount(); 
			$total_type_pages = ceil($post_total/$post_per_page);
			return $total_type_pages;
		}
		else
		{
			throw new Exception("Error Processing Request", 1);
		}
	}

// AMELIORATION : sortir les posts comme des objets
// avec une boucle while ($post = new Posts)

	public function getAllPost($actual_page) 
	{
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur
		$q = $this->_db->query('SELECT id, title, id_user, type, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%y à %Hh%imin%ss\') AS create_date_format,  DATE_FORMAT(last_update, \'%d/%m/%y à %Hh%imin%ss\') AS last_update_format  FROM posts ORDER BY id DESC LIMIT ' . $start . ',' . $post_per_page);
		return $q;
	}
	public function getTypePost ($info, $actual_page)
	{
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; //$start est le depart du LIMIT, sa premiere valeur
		$q = $this->_db->query('SELECT id, title, id_user, type, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%y à %Hh%imin%ss\') AS create_date_format,  DATE_FORMAT(last_update, \'%d/%m/%y à %Hh%imin%ss\') AS last_update_format  FROM posts WHERE type= "' .$info. '" ORDER BY id DESC LIMIT ' . $start . ',' . $post_per_page);
		return $q;
	}


// Absence de balise PHP de fermeture
}