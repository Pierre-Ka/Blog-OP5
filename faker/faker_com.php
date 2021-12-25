
<?php 

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

// FAKER_COM A ETE CONCU POUR 20 POSTS. LORS DE DAVANTAGE DE POSTS JUSTE CHANGE LE SECOND NOMBRE DE numberBetween

foreach(range(1, 100) as $id)
{
	$db->query("INSERT INTO comments (id, id_post, author, content, is_valid, create_date) VALUES('" . $id . "','{$faker->numberBetween(1, 20)}','{$faker->name()}','{$faker->sentence(15)}','1','{$faker->date()}')") ;
}
header('Location:index.php');


