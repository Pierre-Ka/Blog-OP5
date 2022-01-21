<?php
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

require('vendor/autoload.php');

$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

//Instanciation de nos classes manager 
$commentManager= new CommentManager($db);
$postManager= new PostManager($db);
$userManager= new UserManager($db);
$categoryManager= new CategoryManager($db);



