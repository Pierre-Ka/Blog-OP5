<?php
namespace Project5;

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
		spl_autoload_register(array( __CLASS__ , 'autoload'));
	}

/* Lors de l'appel dynamique des classes, ce n'est plus CommentManager qui est appelée mais Project5\CommentManager */

	static function autoload($class_name_with_namespace)
	{
		if ( strpos($class_name_with_namespace, __NAMESPACE__ . '\\') === 0) 
		{
			$class_name=str_replace('Project5\\', '', $class_name_with_namespace);
			if (substr($class_name, -7) === 'Manager')
			{
				require_once('manager/'.$class_name. '.php');
			}
			else 
			{
				require_once('entity/'.$class_name. '.php');
			}
		}
	}
}