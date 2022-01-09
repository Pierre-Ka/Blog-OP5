<?php
namespace Project5; 

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();


// FAKER_POST A ETE CONCU POUR 5 USERS ET 3 CATEGORIES. LORS DE DAVANTAGE DE USERS JUSTE CHANGE LE SECOND NOMBRE DE numberBetween. LORS DE DAVANTAGE DE CATEGORIE AJOUTE CELLE-CI A randomElements array. Les posts auront id=1 jusqu'à id=20.

foreach(range(1, 100) as $id)
{
	$body= '<p>' . implode('</p><p>', $faker->paragraphs(20)) . '</p>';

	$db->query("INSERT INTO posts (id, title, id_user, type, chapo, content, picture, create_date) VALUES('" . $id . "','{$faker->sentence(6)}','{$faker->numberBetween(1, 8)}','{$faker->randomElement($array=array('type1','type2','type3'))}','{$faker->sentence(15)}','$body','POST_IMG_{$faker->randomDigit()}','{$faker->date()}')") ;
}

header('Location:index.php');


