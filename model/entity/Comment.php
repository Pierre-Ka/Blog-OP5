<?php
namespace Project5 ;

class Comment extends Entity
{
	private $id,
			$id_post,
			$author,
			$content,
			$is_valid,
			$create_date;

/* AMELIORATION future: TYPEHINT

	private int $id;
	private int $idPost;
	private string $author;
	private string $content;
	private bool $isValid;
	private datetime $createDate;

*/
	//GETTERS//

	public function getId()
	{
		return $this->id;
	}
	public function getId_post()
	{
		return $this->id_post;
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

	public function setId_post($id_post)
	{
		$id_post= (int) $id_post;
		if ($id_post>0)
		{
			$this->id_post = $id_post;
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