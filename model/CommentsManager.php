<?php
class CommentsManager
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

	public function add_com(Comments $comment)
	{
		$q = $this->_db->prepare('INSERT INTO comments(id_post,author,content, create_date) VALUES(:id_post,:author,:content, CURDATE())');
		$q->bindValue(':id_post', $comment->getId_post());
		$q->bindValue(':author', $comment->getAuthor());
		$q->bindValue(':content', $comment->getContent());
		$q->execute();
		// ici : Hydratation ou pas ?
	}

	public function valid_com($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('UPDATE comments SET is_valid=1 WHERE id=:id');
			$q->bindValue(':id', $info);
			$q->execute();
		}
	}

	public function delete_com($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('DELETE FROM comments WHERE id=:id');
			$q->bindValue(':id', $info);
			$q->execute();
		}
	}


// UNE REFLEXION S'IMPOSE AU SYSTEME DE PAGINATION

	public function total_com_pages ($info)
	{ // $info est $_GET['id_post']
		$info = intval($info) ;
		$com_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM comments WHERE id_post= ' .$info) ;
		$com_total = $q->rowCount(); 
		$total_pages = ceil($com_total/$com_per_page); 
		return $total_pages;
	}

// l'actual page n'a pas sa place dans le manager
// mais dans le controller

	public function actual_com_page ($info, $number_page) // $number_page est actual_page : ($_GET['page']
	{
		$total_pages = total_com_pages($info);
		if (isset($number_page) AND !empty($number_page) AND ($number_page)>0 AND ($number_page)<=$total_pages)
		{
			$number_page=intval($number_page);
			$actual_page = $number_page;
		}
		else 
		{
			$actual_page = 1 ;
		}
		return $actual_page;
	}

// AMELIORATION : sortir les coms comme des objets
// avec une boucle while ($com = new Comment)
	public function get_com_per_page ($info, $number_page)
	{	// $info est $_GET['id_post']
		$info = intval($info) ;
		$com_per_page = 4 ;
		$actual_page = actual_com_page($info, $number_page);
		$start = ( $actual_page-1)*$com_per_page; //$start est le depart du LIMIT, sa premiere valeur
		$q = $this->_db->query('SELECT id,id_post, author, content, is_valid, DATE_FORMAT(create_date, \'%d/%m/%y à %Hh%imin%ss\') AS create_date_format FROM comments WHERE id_post= ' . $info . ' ORDER BY id DESC LIMIT ' . $start . ',' . $com_per_page);
		return $q;
	}
// Absence de balise PHP de fermeture
/* FONCTIONS NON UTILISER
	public function count()

	public function exists($info)

	public function get($info)

	public function getList ($nom)

	public function update(Comments $comment)
*/
}