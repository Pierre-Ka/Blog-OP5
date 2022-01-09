<?php
namespace Project5;

class CommentManager extends Manager
{
	// OPERATION EN BDD : add - valid - delete - totalPages - get - getNotYetValid - countNotYetValid

	public function add(Comment $comment)
	{
		$q = $this->_db->prepare('INSERT INTO comments(post_id,author,content, create_date) VALUES(:post_id,:author,:content, NOW())');
		$q->bindValue('post_id', $comment->getPost_id());
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

	public function totalPages (int $post_id)
	{ 
		$com_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM comments WHERE is_valid=1 AND post_id= ' .$post_id) ;
		$com_total = $q->rowCount(); 
		$total_com_pages = ceil($com_total/$com_per_page); 
		return $total_com_pages;
	}

	public function get (int $post_id, int $actual_page)
	{	
		$comments=[];
		$com_per_page = 4 ;
		$start = ( $actual_page-1)*$com_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur

		$q = $this->_db->query('SELECT id,post_id, author, content, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%i\') AS create_date FROM comments WHERE is_valid=1 AND post_id= "' .$post_id. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d%Hh%i\') DESC LIMIT ' . $start . ',' . $com_per_page);
		while ($data=$q->fetch(\PDO::FETCH_ASSOC)) 
		{
			$comments[]= new Comment ($data) ; 
		}
		return $comments;
	}

	public function getNotYetValid (int $post_id)
	{	
		$comments=[];
		$q = $this->_db->query('SELECT id,post_id, author, content, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%i\') AS create_date FROM comments WHERE is_valid=0 AND post_id= "' .$post_id. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d%Hh%i\')');
		while ($data=$q->fetch(\PDO::FETCH_ASSOC)) 
		{
			$comments[]= new Comment ($data) ; 
		}
		return $comments;
	}

	public function countNotYetValid (int $post_id)
	{	
		$comments=[];
		$q = $this->_db->query('SELECT * FROM comments WHERE is_valid=0 AND post_id= "' .$post_id . '"');
		$total = $q->rowCount(); 
		return $total;
	}
}