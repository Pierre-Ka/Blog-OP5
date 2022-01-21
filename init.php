<?php
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

require('vendor/autoload.php');

$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

//Instanciation de nos classes manager 
$comment_manager= new CommentManager($db);
$post_manager= new PostManager($db);
$user_manager= new UserManager($db);
$category_manager= new CategoryManager($db);



