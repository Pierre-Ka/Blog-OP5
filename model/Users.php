<?php
class Users
{
	private $_id,
			$_email,
			$_password,
			$_picture,
			$_description,
			$_inscription_date,
			$_is_valid;

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
	public function getEmail()
	{
		return $this->_email;
	}
	public function getPassword()
	{
		return $this->_password;
	}
	public function getPicture()
	{
		return $this->_picture;
	}
	public function getDescription()
	{
		return $this->_description;
	}
	public function getInscription_date()
	{
		return $this->_inscription_date;
	}
	public function getIs_valid()
	{
		return $this->_is_valid;	
	}

	//SETTERS//

	public function setId($id)
	{
		if(ctype_digit($id))
		{
			$this->_id = $id;
		}
	}

	public function setEmail($email)
	{
		if (is_string($email))
		{
			$this->_$email= $email;
		}
	}

	public function setPassword($password)
	{
		if (is_string($password))
		{
			$this->_$password= $password;
		}
	}

	public function setPicture($picture)
	{
		if (is_string($picture))
		{
			$this->_$picture= $picture;
		}
	}

	public function setDescription($description)
	{
		if (is_string($description))
		{
			$this->_$description= $description;
		}
	}

	public function setInscription_date($inscription_date)
	{
		$inscription_date=strtotime(($inscription_date))
		if ($inscription_date = (int)$inscription_date)
		{
			$this->_inscription_date = $inscription_date;
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

}