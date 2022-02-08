Modification de CommentManager fonction get() : ancienne : 
public function get (int $post_id, int $actual_page)
	{	
		$comments=[];
		$com_per_page = 4 ;
		$start = ( $actual_page-1)*$com_per_page; 
		//$start est le depart du LIMIT, sa premiere valeur

		$q = $this->_db->query('SELECT id,post_id, author, content, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%i\') AS create_date FROM comment WHERE is_valid=1 AND post_id= ' . $post_id . ' ORDER BY DATE_FORMAT(create_date, \'%Y%m%d%Hh%i\') DESC LIMIT ' . $start . ',' . $com_per_page);

		while ($data=$q->fetch(\PDO::FETCH_ASSOC)) 
		{
			$comments[]= new Comment ($data) ; 
		}
		return $comments;
	}

Modification de PostManager fonction getOne() : ancienne : 
	public function getOne($id)
	{ 
		if (ctype_digit($id))
		{
			$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update,  
				u.name as user,
				c.name as category
			FROM post AS p
			INNER JOIN user AS u
				ON p.user_id = u.id
			INNER JOIN category AS c
				ON p.category_id = c.id
			WHERE p.id=' .$id);
			$data=$q->fetch();
			return new Post($data);
		}
	}

Modification de PostManager fonction getAll() : ancienne : 
	public function getAll($actual_page) 
	{
		$posts=[];
		$post_per_page = 5 ;
		$start = ( $actual_page-1)*$post_per_page; 
		$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update,  
				u.name as user,
				c.name as category
			FROM post AS p
			INNER JOIN user AS u
				ON p.user_id = u.id
			INNER JOIN category AS c
				ON p.category_id = c.id
			ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC 
			LIMIT ' . $start . ',' . $post_per_page
			);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))		
		{
			$posts[]= new Post ($data);
		}

		return $posts;
	}

Modification de PostManager fonction getWithCategory() : ancienne :
	public function getWithCategory ($category_id, $actual_page)
	{
		$posts=[];
		$post_per_page = 5 ;
		$start = ( $actual_page-1)*$post_per_page; 		
		$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update,  
				u.name as user,
				c.name as category
			FROM post AS p
			INNER JOIN user AS u
				ON p.user_id = u.id
			INNER JOIN category AS c
				ON p.category_id = c.id
			WHERE category_id= "' .$category_id. '" 
			ORDER BY DATE_FORMAT(create_date, \'%Y%m%d\') DESC 
			LIMIT ' . $start . ',' . $post_per_page);
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}

Modification de PostManager fonction getWithUserId() : ancienne :
public function getWithUserId ($connect_id)
	{
		$posts=[];		
		$q = $this->_db->query('
			SELECT p.id, p.title, p.user_id, p.category_id, p.chapo, p.content, p.picture, 
				DATE_FORMAT(p.create_date, \'%d/%m/%Y\') AS create_date,  
				DATE_FORMAT(p.last_update, \'%d/%m/%Y\') AS last_update,
				c.name as category
			FROM post AS p
			INNER JOIN category AS c
				ON p.category_id = c.id 

			WHERE p.user_id= "' .$connect_id. '" 
			ORDER BY DATE_FORMAT(p.create_date, \'%Y%m%d\') DESC');
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$posts[]= new Post ($data) ;
		}
		return $posts;
	}





Mailer = comment le personnaliser ?
En + = correction de la fonction GetValidComment qui est très moche

Important : Vous vous assurerez qu’il n’y a pas de failles de sécurité (XSS, CSRF, SQL Injection, session hijacking, upload possible de script PHP…).

OPTION = aléatoirement le chargement d'image nouvellement ajoutée se s'éffectue pas à cause de la mise en cache de l'image ( need to force refresh )
OPTION = aléatoirement le telechargement d'image via resizeimage n'a pas le rendu escompté
OPTION = reecriture des classes controller de manière plus coherente ( postcontroller, categorycontroller, usercontroller, commentcontroller) 
OPTION : supprimer automatiquement les photos des posts/categories deleted

