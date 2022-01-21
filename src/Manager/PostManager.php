<?php
namespace BlogApp\Manager;

use BlogApp\Entity\Post ;

class PostManager extends Manager
{
	// OPERATION EN BDD :  add  edit   getOne   delete   totalPages   totalPagesByCategory  GetAll   GetAllAdmin   getWithCategory   getWithUserId   getLastInsertId()
	
	public function add(Post $post)
	{
		$q = $this->_db->prepare('INSERT INTO posts(title, user_id, category_id, chapo, content, create_date) VALUES(:title,:user_id, :category_id, :chapo, :content, CURDATE())');
		$q->bindValue('title', $post->getTitle());
		$q->bindValue('user_id', $post->getUser_id());
		$q->bindValue('category_id', $post->getCategory_id());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->execute();
	}

	public function edit(Post $post)
	{
		$q = $this->_db->prepare('UPDATE posts SET title = :title, category_id = :category_id, chapo = :chapo, content = :content, picture = :picture, last_update = CURDATE() WHERE id = :id');
		$q->bindValue('id', $post->getId());
		$q->bindValue('title', $post->getTitle());
		$q->bindValue('category_id', $post->getCategory_id());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->bindValue('picture', $post->getPicture());
		$q->execute();
	}

	public function getOne($id)
	{ 
		if (ctype_digit($id))
		{
			$q = $this->_db->query('SELECT * FROM posts WHERE id=' .$id);
			$data=$q->fetch();
			return new Post($data);
		}
	}

	public function delete($id)
	{
		if (ctype_digit($id))
		{
			$q = $this->_db->exec('DELETE FROM posts WHERE id=' .$id);
		}
	}

	public function totalPages()
	{
		$post_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM posts') ;
		$post_total = $q->rowCount(); 
		$total_pages = ceil($post_total/$post_per_page);
		return $total_pages;
	}

	public function totalPagesByCategory ($category_id)
	{ 
		$post_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM posts WHERE category_id= "' .$category_id. '"') ;
		$post_total = $q->rowCount(); 
		$total_type_pages = ceil($post_total/$post_per_page);
		return $total_type_pages;
	}

	/*public function getAll($actual_page) 
	{
		$posts=[];
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 
		$q = $this->_db->query('SELECT id, title, user_id, category_id, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date,  DATE_FORMAT(last_update, \'%d/%m/%Y\') AS last_update  FROM posts ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC LIMIT ' . $start . ',' . $post_per_page);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}*/

	public function getAll($actual_page) 
	{
		$posts=[];
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 
		$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update, 
				c.name as categorie  
			FROM posts AS p
			RIGHT JOIN categories AS c
				ON p.category_id = c.id
			ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC 
			LIMIT ' . $start . ',' . $post_per_page
			);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))		
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}

	public function getAllAdmin() 
	{
		$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update, 
				c.name as categorie  
			FROM posts AS p
			RIGHT JOIN categories AS c
				ON p.category_id = c.id
			ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC'
			);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))		
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}


	public function getWithCategory ($category_id, $actual_page)
	{
		$posts=[];
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 		
		$q = $this->_db->query('SELECT id, title, user_id, category_id, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%y\') AS create_date,  DATE_FORMAT(last_update, \'%d/%m/%y\') AS last_update FROM posts WHERE category_id= "' .$category_id. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC LIMIT ' . $start . ',' . $post_per_page);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}

	public function getWithUserId ($connect_id)
	{
		$posts=[];		
		$q = $this->_db->query('SELECT id, title, user_id, category_id, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%y\') AS create_date,  DATE_FORMAT(last_update, \'%d/%m/%y\') AS last_update FROM posts WHERE user_id= "' .$connect_id. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC');
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}

	public function getLastInsertId()
	{
		return $this->_db->lastInsertId();
	}

}