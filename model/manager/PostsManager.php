<?php
namespace Project5;

class PostsManager extends Manager
{
	// OPERATION EN BDD :  add  edit   getOne   delete   totalAllPage   totalTypePage  GetAll GetType
	
	public function add(Post $post)
	{
		$q = $this->_db->prepare('INSERT INTO posts(title, id_user, type, chapo, content, picture, create_date) VALUES(:title,:id_user,:type, :chapo, :content, :picture, CURDATE())');
		$q->bindValue('title', $post->getTitle());
		$q->bindValue('id_user', $post->getId_user());
		$q->bindValue('type', $post->getType());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->bindValue('picture', $post->getPicture());
		$q->execute();
	}

	public function edit(Post $post)
	{
		$q = $this->_db->prepare('UPDATE posts SET title = :title, type = :type, chapo = :chapo, content = :content, picture = :picture, last_update = CURDATE() WHERE id = :id');
		$q->bindValue('id', $user->getId());
		$q->bindValue('title', $user->getTitle());
		$q->bindValue('type', $user->getType());
		$q->bindValue('chapo', $post->getChapo());
		$q->bindValue('content', $post->getContent());
		$q->bindValue('picture', $user->getPicture());
		$q->execute();
	}

	public function getOne($id_post)
	{ 
		if (ctype_digit($id_post))
		{
			$q = $this->_db->query('SELECT * FROM posts WHERE id=' .$id_post);
			$data=$q->fetch();
			return new Post($data);
		}
	}

	public function delete($id_post)
	{
		if (ctype_digit($id_post))
		{
			$q = $this->_db->exec('DELETE FROM posts WHERE id=' .$id_post);
		}
	}

	public function totalAllPages ()
	{
		$post_per_page = 4 ;
		$q = $this->_db->query('SELECT id FROM posts') ;
		$post_total = $q->rowCount(); 
		$total_all_pages = ceil($post_total/$post_per_page);
		return $total_all_pages;
	}

	public function totalTypePages ($infoType)
	{ 
		$typePossible= array("type1", "type2", "type3");
		if (in_array($infoType, $typePossible))
		{
			$post_per_page = 4 ;
			$q = $this->_db->query('SELECT id FROM posts WHERE type= "' .$infoType. '"') ;
			$post_total = $q->rowCount(); 
			$total_type_pages = ceil($post_total/$post_per_page);
			return $total_type_pages;
		}
	}

// AMELIORATION : sortir les posts comme des objets
// avec une boucle while ($post = new Posts)

	public function getAll($actual_page) 
	{
		$posts=[];
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur

		$q = $this->_db->query('SELECT id, title, id_user, type, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%Y\') AS create_date,  DATE_FORMAT(last_update, \'%d/%m/%Y\') AS last_update  FROM posts ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC LIMIT ' . $start . ',' . $post_per_page);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}


	public function getType ($infoType, $actual_page)
	{
		$posts=[];
		$post_per_page = 4 ;
		$start = ( $actual_page-1)*$post_per_page; 
		
		$q = $this->_db->query('SELECT id, title, id_user, type, chapo, content, picture, DATE_FORMAT(create_date, \'%d/%m/%y\') AS create_date,  DATE_FORMAT(last_update, \'%d/%m/%y\') AS last_update FROM posts WHERE type= "' .$infoType. '" ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC LIMIT ' . $start . ',' . $post_per_page);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}
}