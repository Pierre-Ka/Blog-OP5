<?php 


require_once('class/Comments.php');
require_once('class/CommentsManager.php');
require_once('class/Posts.php');
require_once('class/PostsManager.php');
require_once('class/Users.php');
require_once('class/UsersManager.php');
// AMELIORATION POSSIBLE : autoload


//Connexion
$db = new PDO('mysql:host=localhost;dbname=project5_blog_php;charset=utf8', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

//Instanciation de nos classes manager ?
$comment_manager= new CommentsManager($db);
$post_manager= new PostsManager($db);
$user_manager= new UsersManager($db);

