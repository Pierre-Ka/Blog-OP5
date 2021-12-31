<?php
//VOICI LES REQUIRES :
//require_once('entity/Entity.php');
//require_once('manager/Manager.php');
//require_once('entity/Comment.php');
//require_once('manager/CommentsManager.php');
//require_once('entity/Post.php');
//require_once('manager/PostsManager.php');
//require_once('entity/User.php');
//require_once('manager/UsersManager.php');

class Autoloader
{

	static function register()
	{
		// Il s'agit ici du code pour déclencher notre autoloader
		spl_autoload_register(array( __CLASS__ , 'autoload'));
	}

/* 
	ICI un probleme se pose, lors de l'appel dynamique des classes, ce n'est plus CommentManager qui est appelée mais Project5\CommentManager
*/

	static function autoload($class_name_with_namespace)
	{
		// On déduit alors Project5\ du nom de la classe : 
		$class_name=str_replace('Project5\\', '', $class_name_with_namespace);

		/*
		Maintenant en fonction de la qualité de classe, manager ou entity, le chemin est différent. On va donc créer une condition. 
		On aurait egalement pu nommer les classes entity par le namespace Project5\Entity et les classes manager par le namespace Project5\Manager cependant on va choisir ici de vérifier si le nom de la classe finie par 'r'. 

		A partir de PHP8 on utilise la fonction str_ends_with(): 

		if (str_ends_with($class_name,'r'))

		*/

		if (substr($class_name, -1) === 'r')
		{
			require_once('manager/'.$class_name. '.php');
		}
		else 
		{
			require_once('entity/'.$class_name. '.php');
		}

	
	}

}