<?php
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

require('vendor/autoload.php');
// A CHAQUE AJOUT D'UNE NOUVELLE CLASSE/FICHIER : OUVRIR UN TERMINAL A LA RACINE DU PROJET ET TAPER LA COMMANDE composer dumpautoload ( ou composer dump-autoload) AFIN DE REFRAICHIR LA LISTE DES CLASSES AUTOLOADER !!

$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

//Instanciation de nos classes manager 
$commentManager= new CommentManager($db);
$postManager= new PostManager($db);
$userManager= new UserManager($db);
$categoryManager= new CategoryManager($db);

