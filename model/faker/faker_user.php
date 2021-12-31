<?php 
namespace Project5;

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

// FAKER_USER permet de créer 4 faux users non administrateur : 
// id=2, id=3, id=4, id=5

foreach(range(2,8) as $id)
{
	$db->query("INSERT INTO users (id,email, password, name, picture, description, inscription_date, is_valid ) VALUES('" . $id . "','{$faker->email()}','{$faker->password()}','{$faker->name()}','POST_IMG_{$faker->randomDigit()}','{$faker->sentence(15)}','{$faker->date()}','1')") ;
}

header('Location:index.php');


