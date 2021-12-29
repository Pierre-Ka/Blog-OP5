<?php
class CommentsManager extends Manager
{
	// OPERATION EN BDD : add - valid - delete - total_pages - get

	public function add(Comment $comment)
	{
		$q = $this->_db->prepare('INSERT INTO comments(id_post,author,content, create_date) VALUES(:id_post,:author,:content, NOW())');
		$q->bindValue('id_post', $comment->getId_post());
		$q->bindValue('author', $comment->getAuthor());
		$q->bindValue('content', $comment->getContent());
		$q->execute();
	}

	public function valid($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('UPDATE comments SET is_valid=1 WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function delete($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('DELETE FROM comments WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function totalPages (int $id_post)
	{ 
		$com_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM comments WHERE is_valid=1 AND id_post= ' .$id_post) ;
		$com_total = $q->rowCount(); 
		$total_com_pages = ceil($com_total/$com_per_page); 
		return $total_com_pages;
	}

	public function get (int $id_post, int $actual_page)
	{	
		$comments=[];
		$com_per_page = 4 ;
		$start = ( $actual_page-1)*$com_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur

		$q = $this->_db->query('SELECT id,id_post, author, content, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%i\') AS create_date FROM comments WHERE is_valid=1 AND id_post= "' .$id_post. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d%Hh%i\') DESC LIMIT ' . $start . ',' . $com_per_page);
		while ($data=$q->fetch(PDO::FETCH_ASSOC)) 
		{
			$comments[]= new Comment ($data) ; 
		}
		return $comments;
	}
}