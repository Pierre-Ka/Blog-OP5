<?php
namespace Project5;

class UserManager extends Manager
{
	// OPERATION EN BDD : login - logged - isAdmin - getUserId - add - getOne - getAuthorName - edit - valid - delete - getList 
	
	public function login($email_submit, $password_submit)
	{
		$email_submit = htmlspecialchars($email_submit);
		$password_submit = htmlspecialchars($password_submit);

		$q = $this->_db->prepare('SELECT * FROM users WHERE email=:email AND is_valid=1');
		$q->bindValue('email', $email_submit);
		$q->execute();

		$result= $q->fetch();
		if($result)
		{
			if (($result['password'])=== sha1($password_submit))
			{
				$_SESSION['auth'] = $result['id'];
		 		return true ;
			}
		}
		return $connection = false ;
	}

	public function logged()
	{
		if($_SESSION['auth'])
		{
			return true;
		}
	}

	public function isAdmin()
	{
		if($_SESSION['auth'])
		{
			$q = $this->_db->prepare('SELECT * FROM users WHERE id =:id AND is_admin=1');
			$q->bindValue('id', $_SESSION['auth']);
			$q->execute();
			if(isset($q)) 
			{
				return true;
			}
		}
	}

	public function getUserId()
	{
		if($this->logged())
		{
			return ($_SESSION['auth']);
		}
	}

	public function add(User $user)
	{ 
		$q = $this->_db->prepare('INSERT INTO users(email, password, name, description, inscription_date) VALUES (:email, :password, :name, :description, NOW())');
		$q->bindValue('email', $user->getEmail());
		$q->bindValue('password', sha1($user->getPassword()));
		$q->bindValue('name', $user->getName());
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


	public function getAuthorName(int $user_id)
	{
		$q = $this->_db->query('SELECT * FROM users WHERE id=' .$user_id);
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
		return $q ;
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
	}


	public function getList()
	{
		$users=[];
		$q = $this->_db->query('SELECT id,email, name, picture, description, is_valid, DATE_FORMAT(inscription_date, \'%d/%m/%Y à %Hh%imin%ss\') AS inscription_date FROM users WHERE is_admin = 0 ORDER BY DATE_FORMAT(inscription_date, \'%Y%m%d%Hh%imin%ss\') DESC');
		
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$users[]= new User ($data) ;
		}
		return $users;
	}

}