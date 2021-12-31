<?php
namespace Project5;

class UsersManager extends Manager
{
	// OPERATION EN BDD : add - getOne - getAuthorName - edit - valid - delete - getList 

	// !!!!!!!!!!!  IL MANQUE UN ATTRIBUT LAST_CONNEXION A MON USER !!!!!!!!!!!!   //

	public function add(User $user)
	{ 
		// Cryptage du mot de passe ici ?
		$q = $this->_db->prepare('INSERT INTO users(email, password, name, picture, description, inscription_date) VALUES (:email, :password, :name,  :picture, :description, NOW())');
		$q->bindValue('email', $user->getEmail());
		$q->bindValue('password', $user->getPassword());
		$q->bindValue('name', $user->getName());
		$q->bindValue('picture', $user->getPicture());
		$q->bindValue('description', $user->getDescription());
		$q->execute();
	}

	public function getOne($info)
	{ 
		// Ici get s'obtient avec un $_POST email et $_POST password : a adapter !
		if (ctype_digit($info))
		{
			$q = $this->_db->query('SELECT * FROM users WHERE id=' .$info);
			$data=$q->fetch();
			return new User($data);
		}
		else
		{
			$q = $this->_db->prepare('SELECT * FROM users WHERE email=:email');
			$q->bindValue(':email', $info);
			$q->execute();
			$data = $q->fetch(\PDO::FETCH_ASSOC);
			return new User($data);
		}
	}


	public function getAuthorName(int $id_user)
	{
		$q = $this->_db->query('SELECT name FROM users WHERE id=' .$id_user);
		$data=$q->fetch(\PDO::FETCH_ASSOC);
		return $data['name'];
	}

	public function edit(User $user)
	{
		$q = $this->_db->prepare('UPDATE users SET password = :password, name = :name, picture = :picture, description = :description WHERE id = :id');
		$q->execute(array(
			'id'=>$user->getId(),
			'password'=>$user->getPassword(),
			'name' =>$user->getName(),
			'picture'=>$user->getPicture(),
			'description'=>$user->getDescription()
			));
		//Pourquoi pas bindValue ?
		/* 	$q->bindValue('id', $user->getId());
		$q->bindValue('password', $user->getPassword());
		$q->bindValue('name', $user->getName());
		$q->bindValue('picture', $user->getPicture());
		$q->bindValue('description', $user->getDescription()); 
		$q->execute();*/

	}

	public function valid($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('UPDATE users SET is_valid=1 WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function delete($info)
	{
		if (ctype_digit($info))
		{
			if ($info>1)
			{
				$q = $this->_db->prepare('DELETE FROM users WHERE id=:id');
				$q->bindValue('id', $info);
				$q->execute();
			}
		}
	} // SI L'OBJET USER A ETE CREE IL FAUT ALORS L'UNSET?

	public function getList()
	{
		$users=[];
		$q = $this->_db->query('SELECT id,email,password, name, picture, description, is_valid, DATE_FORMAT(inscription_date, \'%d/%m/%Y à %Hh%imin%ss\') AS inscription_date FROM users ORDER BY DATE_FORMAT(inscription_date, \'%Y%m%d%Hh%imin%ss\') DESC');
		
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$users[]= new User ($data) ;
		}
		return $users;
	}
}