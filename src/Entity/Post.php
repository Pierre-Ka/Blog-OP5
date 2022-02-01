<?php
namespace BlogApp\Entity;

use BlogApp\Manager\CommentManager;

class Post extends Entity
{
	private $id;
	private string $title;
	private int $idUser;
	private string $type;
	private string $chapo;
	private string $content;
	private string $picture;
	private datetime $lastUpdate;
	private datetime $createDate;

	private string $category;
	private string $user;

	//GETTERS//

	public function getId() 
	{
		return $this->id;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function getUser_id()
	{
		return $this->user_id;
	}
	public function getCategory_id()
	{
		return $this->category_id;
	}
	public function getChapo()
	{
		return $this->chapo;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function getPicture()
	{
		return $this->picture;	
	}
	public function getLast_update()
	{
		return $this->last_update;
	}
	public function getCreate_date()
	{
		return $this->create_date;
	}

	//SETTERS//

	public function setId($id) // setId(int $id) : void
	{
		if(ctype_digit($id))
		{
			$this->id = $id;
		}
	}

	public function setTitle($title)
	{
		if (is_string($title))
		{
			$this->title= $title;
		}
	}

	public function setUser_id($user_id)
	{
		$user_id= (int) $user_id;
		if ($user_id>0)
		{
			$this->user_id = $user_id;
		}
	}

	public function setCategory_id($category_id)
	{
		$category_id= (int) $category_id;
		if ($category_id>0)
		{
			$this->category_id= $category_id;
		}
	}

	public function setChapo($chapo)
	{
		if (is_string($chapo))
		{
			$this->chapo= $chapo;
		}
	}

	public function setContent($content)
	{
		if (is_string($content))
		{
			$this->content= $content;
		}
	}

	public function setPicture($picture)
	{
		if (is_string($picture))
		{
			$this->picture= $picture;
		}
	}

	public function setLast_update($last_update)
	{
		/*$last_update=strtotime(($last_update));
		if ($last_update = (int)$last_update)*/
		{
			$this->last_update = $last_update;
		}
	}
	public function setCreate_date($create_date)
	{
		/*$create_date=strtotime(($create_date));
		if ($create_date = (int)$create_date)*/
		{
			$this->create_date = $create_date;
		}
	}

	// FIN DES SETTERS //

	// RECUPERATION DES JOINTURES //

	public function getCategory()
	{
		return $this->category ;
	}
	public function setCategory($category)
	{
		$this->category = $category ;
	}
	public function getUser()
	{
		return $this->user;
	}
	public function setUser($user)
	{
		$this->user = $user ;
	}

	public function getCommentNotYetValid() 
	{
		$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
		$comment_manager = new CommentManager($db) ;
		$count = $comment_manager->countNotYetValid($this->id) ;
          return $count ;
	}
}
