<?php
use Project5\Autoloader;
use Project5\CommentManager;
use Project5\PostManager;
use Project5\UserManager;
use Project5\CategoryManager;


// chargement des classes
require('model/Autoloader.php');
Autoloader::register();

require('controller/ControllerParent.php');
require('controller/PostController.php');
require('controller/UserController.php');
require('controller/AdminController.php');

//Connexion
$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);


//Instanciation de nos classes manager 
$comment_manager= new CommentManager($db);
$post_manager= new PostManager($db);
$user_manager= new UserManager($db);
$category_manager= new CategoryManager($db);

