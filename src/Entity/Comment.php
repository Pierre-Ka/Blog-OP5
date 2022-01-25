<?php
namespace BlogApp\Entity;

class Comment extends Entity
{
/*	private $id,
			$post_id,
			$author,
			$content,
			$is_valid,
			$create_date;

 AMELIORATION future: TYPEHINT
*/
	private int $id;
	private int $idPost;
	private string $author;
	private string $content;
	private bool $isValid;
	private datetime $createDate;


	//GETTERS//

	public function getId()
	{
		return $this->id;
	}
	public function getPost_id()
	{
		return $this->post_id;
	}
	public function getAuthor()
	{
		return $this->author;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function getIs_valid()
	{
		return $this->is_valid;	
	}
	public function getCreate_date()
	{
		return $this->create_date;
	}

	//SETTERS//

	public function setId($id)
	{
		if(ctype_digit($id))
		{
			$this->id = $id;
		}
	}

	public function setPost_id($post_id)
	{
		$post_id= (int) $post_id;
		if ($post_id>0)
		{
			$this->post_id = $post_id;
		}
	}

	public function setAuthor($author)
	{
		if (is_string($author))
		{
			$this->author= $author;
		}
	}

	public function setContent($content)
	{
		if (is_string($content))
		{
			$this->content= $content;
		}
	}

	public function setIs_valid($is_valid)
	{
		$is_valid= (int) $is_valid;
		if ($id_post>=0 AND $id_post<2)
		{
			$this->is_valid = $is_valid;
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
}