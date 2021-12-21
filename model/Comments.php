<?php
class Comments
{
	private $_id,
			$_id_post,
			$_author,
			$_content,
			$_is_valid,
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
	public function getId_post()
	{
		return $this->_id_post;
	}
	public function getAuthor()
	{
		return $this->_author;
	}
	public function getContent()
	{
		return $this->_content;
	}
	public function getIs_valid()
	{
		return $this->_is_valid;	
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

	public function setId_post($id_post)
	{
		$id_post= (int) $id_post;
		if ($id_post>0)
		{
			$this->_id_post = $id_post;
		}
	}

	public function setAuthor($author)
	{
		if (is_string($author))
		{
			$this->_$author= $author;
		}
	}

	public function setContent($content)
	{
		if (is_string($content))
		{
			$this->_$content= $content;
		}
	}

	public function setIs_valid($is_valid)
	{
		$is_valid= (int) $is_valid;
		if ($id_post>=0 AND $id_post<2)
		{
			$this->_is_valid = $is_valid;
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