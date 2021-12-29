<?php 


require_once('model/entity/Entity.php');
require_once('model/manager/Manager.php');
require_once('model/entity/Comment.php');
require_once('model/manager/CommentsManager.php');
require_once('model/entity/Post.php');
require_once('model/manager/PostsManager.php');
require_once('model/entity/User.php');
require_once('model/manager/UsersManager.php');
// AMELIORATION POSSIBLE : autoload


//Connexion
$db = new PDO('mysql:host=localhost;dbname=project5_faker;charset=utf8', 'root', 'root');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

//Instanciation de nos classes manager ?
$comment_manager= new CommentsManager($db);
$post_manager= new PostsManager($db);
$user_manager= new UsersManager($db);

