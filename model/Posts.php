<?php
class Posts
{
	private $_id,
			$_title,
			$_id_user,
			$_type,
			$_content,
			$_picture,
			$_last_update,
			$_create_date;

	// Declaration des constances const
	// Hydratation de la classe

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value)
		{
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

	//GETTERS//

	public function getId()
	{
		return $this->_id;
	}
	public function getTitle()
	{
		return $this->_title;
	}
	public function getId_user()
	{
		return $this->_id_user;
	}
	public function getType()
	{
		return $this->_type;
	}
	public function getContent()
	{
		return $this->_content;
	}
	public function getPicture()
	{
		return $this->_picture;	
	}
	public function getLast_update()
	{
		return $this->_last_update;
	}
	public function getCreate_date()
	{
		return $this->_create_date;
	}

	//SETTERS//

	public function setId($id)
	{
		if(ctype_digit($id))
		{
			$this->_id = $id;
		}
	}

	public function setTitle($title)
	{
		if (is_string($title))
		{
			$this->_$title= $title;
		}
	}

	public function setId_user($id_user)
	{
		$id_user= (int) $id_user;
		if ($id_user>0)
		{
			$this->_id_user = $id_user;
		}
	}

	public function setType($type)
	{
		if (is_string($type))
		{
			$this->_$type= $type;
		}
	}

	public function setContent($content)
	{
		if (is_string($content))
		{
			$this->_$content= $content;
		}
	}

	public function setPicture($picture)
	{
		if (is_string($picture))
		{
			$this->_$picture= $picture;
		}
	}

	public function setLast_update($last_update)
	{
		$last_update=strtotime(($last_update))
		if ($last_update = (int)$last_update)
		{
			$this->_last_update = $last_update;
		}
	}
	public function setCreate_date($create_date)
	{
		$create_date=strtotime(($create_date))
		if ($create_date = (int)$create_date)
		{
			$this->_create_date = $create_date;
		}
	}

	// FIN DES SETTERS //
}