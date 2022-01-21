<?php
namespace BlogApp\Faker;

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();


// FAKER_Categorie A ETE CONCU POUR crée 3 categories

foreach(range(1, 3) as $id)
{

	$db->query("INSERT INTO categories (id, name) VALUES('" . $id . "','{$faker->sentence(6)}'") ;
}

$message = '3 fausses categories crées';
header('Location:index.php?p=admin.home');


