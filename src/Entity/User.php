<?php
namespace BlogApp\Entity;

class User extends Entity
{

	// !!!!!!!!!!!  IL MANQUE UN ATTRIBUT LAST_CONNEXION A MON USER !!!!!!!!!!!!   //
	private $id,
			$email,
			$password,
			$name,
			$picture,
			$description,
			$inscription_date,
			$is_valid;

/* AMELIORATION future: TYPEHINT

	private int $id;
	private string $email;
	private string $name;
	private string $picture;
	private string $description;
	private datetime $inscriptionDate;
	private bool isValid ;

*/
		//GETTERS//

	public function getId()
	{
		return $this->id;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getPicture()
	{
		return $this->picture;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getInscription_date()
	{
		return $this->inscription_date;
	}
	public function getIs_valid()
	{
		return $this->is_valid;	
	}

	//SETTERS//

	public function setId($id)
	{
		if(ctype_digit($id))
		{
			$this->id = $id;
		}
	}

	public function setEmail($email)
	{
		if (is_string($email))
		{
			$this->email= $email;
		}
	}

	public function setPassword($password)
	{
		if (is_string($password))
		{
			$this->password= $password;
		}
	}

	public function setName($name)
	{
		if (is_string($name))
		{
			$this->name= $name;
		}
	}

	public function setPicture($picture)
	{
		if (is_string($picture))
		{
			$this->picture= $picture;
		}
	}

	public function setDescription($description)
	{
		if (is_string($description))
		{
			$this->description= $description;
		}
	}

	public function setInscription_date($inscription_date)
	{
		$inscription_date=strtotime(($inscription_date));
		if ($inscription_date = (int)$inscription_date)
		{
			$this->inscription_date = $inscription_date;
		}
	}

	public function setIs_valid($is_valid)
	{
		$is_valid= (int) $is_valid;
		if ($is_valid>=0 AND $is_valid<2)
		{
			$this->is_valid = $is_valid;
		}
	}

}