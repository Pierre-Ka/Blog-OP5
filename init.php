<?php
use Project5\CommentsManager;
use Project5\PostsManager;
use Project5\UsersManager;

require('model/Autoloader.php');
Autoloader::register();


//Connexion
$db = new \PDO('mysql:host=localhost;dbname=project5_faker;charset=utf8', 'root', 'root');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);


//Instanciation de nos classes manager ?
$comment_manager= new CommentsManager($db);
$post_manager= new PostsManager($db);
$user_manager= new UsersManager($db);

