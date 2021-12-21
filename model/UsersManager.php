<?php
class UsersManager
{
	private $_db; // Instance de PDO

	public function __construct($db)
	{
		$this->setDb($db);
	}
// NO GETTER, ONLY SETTER
	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
// OPERATION EN BDD
	// ajouter un user
	// get lors de la connexion à stocker dans session
	// modifier un user
	// valider un user
	// supprimer un user
	// getList all trier par plus recent

	public function add_user(Users $user)
	{ // Cryptage du mot de passe ici ?
		$q = $this->_db->prepare('INSERT INTO users(email, password, picture, description, inscription_date) VALUES (:email, :password, :picture, :description, CURDATE())');
		$q->bindValue('email', $user->getEmail());
		$q->bindValue('password', $user->getPassword());
		$q->bindValue('picture', $user->getPicture());
		$q->bindValue('description', $user->getDescription());
		$q->execute();
		// ici : Hydratation ou pas ?
	}

	public function get_user($info)
	{ // Ici get s'obtient avec un $_POST email et $_POST password : a adapter !
		if (ctype_digit($info))
		{
			$q = $this->_db->query('SELECT * FROM users WHERE id=' .$info);
			$data=$q->fetch();
			return new Users($data);
		}
		else
		{
			$q = $this->_db->prepare('SELECT * FROM users WHERE email=:email');
			$q->bindValue(':email', $info);
			$q->execute();
			$data = $q->fetch(PDO::FETCH_ASSOC);
			return new Users($data);
		}
	}

	public function edit_user(Users $user)
	{
		$q = $this->_db->prepare('UPDATE users SET password = :password, picture = :picture, description = :description WHERE id = :id');
		$q->execute(array(
			'id'=>$user->getId(),
			'password'=>$user->getPassword(),
			'picture'=>$user->getPicture(),
			'description'=>$user->getDescription()
			));
		//Pourquoi pas bindValue ?
		/* 	$q->bindValue('id', $user->getId());
		$q->bindValue('password', $user->getPassword());
		$q->bindValue('picture', $user->getPicture());
		$q->bindValue('description', $user->getDescription()); 
		$q->execute();*/

		// ici : REhydratation
	}

	public function valid_user($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('UPDATE users SET is_valid=1 WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	}

	public function delete_user($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->prepare('DELETE FROM users WHERE id=:id');
			$q->bindValue('id', $info);
			$q->execute();
		}
	} // SI L'OBJET USER A ETE CREE IL FAUT ALORS L'UNSET?

	public function get_users_list()
	{
		$q = $this->_db->query('SELECT id,email,password, picture, description, is_valid, DATE_FORMAT(inscription_date, \'%d/%m/%y à %Hh%imin%ss\') AS inscription_date_format FROM users ORDER BY inscription_date DESC');
		return $q;
		// AMELIORATION : sortir les users comme des objets
		// avec une boucle while ($user = new User)

		/*
		exemple : le nouveau getlist
			public function getList($nom)
		{
			$persos=[]; 
			$q = $this->_db->prepare('SELECT * FROM ameliorationperso WHERE name <> :name ORDER BY name');
			$q->bindValue(':name', $nom);
			$q->execute(); // $q->execute(['name'=>$nom];)
			while($data=$q->fetch(PDO::FETCH_ASSOC))
			{
				$persos[]= new Perso ($data) ;
			}
			return $persos ;
		}
		*/

	}
// Absence de balise PHP de fermeture
/* FONCTIONS NON UTILISER

	public function exists($info)

	public function get($info)

*/
}