<?php
namespace BlogApp\Faker;

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();


// FAKER_POST A ETE CONCU POUR 8 USERS ET 3 CATEGORIES. LORS DE DAVANTAGE DE USERS JUSTE CHANGE LE SECOND NOMBRE DE numberBetween. LORS DE DAVANTAGE DE CATEGORIE AJOUTE CELLE-CI A randomElements array. Les posts auront id=1 jusqu'à id=100.

foreach(range(1, 100) as $id)
{
	$body= '<p>' . implode('</p><p>', $faker->paragraphs(20)) . '</p>';

	$db->query("INSERT INTO posts (id, title, user_id, category_id, chapo, content, picture, create_date) VALUES('" . $id . "','{$faker->sentence(6)}','{$faker->numberBetween(1, 8)}','{$faker->numberBetween(1, 3)}','{$faker->sentence(15)}','$body','POST_IMG_{$faker->randomDigit()}','{$faker->date()}')") ;
}

$message = '100 Faux posts crées';
header('Location:index.php?p=admin.home');


