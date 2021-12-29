<?php
class CommentsManager
{
	private $_db; // Instance de PDO

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

// OPERATION EN BDD
	// function add_com
	// function valid_com
	// function delete_com
	// function total_com_pages 
	// function get_com

	public function addCom(Comment $comment)
	{
		$q = $this->_db->prepare('INSERT INTO comments(id_post,author,content, create_date) VALUES(:id_post,:author,:content, CURDATE())');
		$q->bindValue('id_post', $comment->getId_post());
		$q->bindValue('author', $comment->getAuthor());
		$q->bindValue('content', $comment->getContent());
		$q->execute();
		// ici : Hydratation ou pas ?
	}

	public function validCom($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('UPDATE comments SET is_valid=1 WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function deleteCom($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('DELETE FROM comments WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function totalComPages ($info)
	{ 
		// $info est $_GET['id_post']
		$info = intval($info) ;
		$com_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM comments WHERE is_valid=1 AND id_post= ' .$info) ;
		$com_total = $q->rowCount(); 
		$total_com_pages = ceil($com_total/$com_per_page); 
		return $total_com_pages;
	}

// AMELIORATION : sortir les coms comme des objets avec une boucle while ($com = new Comment)

	public function getCom ($info, $actual_page)
	{	
		$com_per_page = 4 ;
		$start = ( $actual_page-1)*$com_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur
		$q = $this->_db->query('SELECT id,id_post, author, content, DATE_FORMAT(create_date, \'%d/%m/%y à %Hh%imin%ss\') AS create_date_format FROM comments WHERE is_valid=1 AND id_post= "' .$info. '" ORDER BY id DESC LIMIT ' . $start . ',' . $com_per_page);
		return $q;
	}
	
// Absence de balise PHP de fermeture
}