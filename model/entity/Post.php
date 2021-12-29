<?php
class Post extends Entity
{
	private $id,
			$title,
			$id_user,
			$type,
			$chapo,
			$content,
			$picture,
			$last_update,
			$create_date;

/* AMELIORATION future: TYPEHINT

	private int $id;
	private string $title;
	private int $idUser;
	private string $type;
	private string $chapo;
	private string $content;
	private string $picture;
	private datetime $lastUpdate;
	private datetime $createDate;

*/

	//GETTERS//

	public function getId()
	{
		return $this->id;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function getId_user()
	{
		return $this->id_user;
	}
	public function getType()
	{
		return $this->type;
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

	public function setId($id)
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

	public function setId_user($id_user)
	{
		$id_user= (int) $id_user;
		if ($id_user>0)
		{
			$this->id_user = $id_user;
		}
	}

	public function setType($type)
	{
		if (is_string($type))
		{
			$this->type= $type;
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
}