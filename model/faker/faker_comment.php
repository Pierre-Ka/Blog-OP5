<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

// FAKER_COM A ETE CONCU POUR 100 POSTS. LORS DE DAVANTAGE DE POSTS JUSTE CHANGE LE SECOND NOMBRE DE numberBetween
foreach(range(1010, 2000) as $id)
{
	$db->query("
		INSERT INTO comments 
		(id, post_id, author, content, is_valid, create_date) 
		VALUES
		('" . $id . "',
		'{$faker->numberBetween(1, 100)}',
		'{$faker->name()}',
		'{$faker->sentence(15)}',
		'0',
		'{$faker->date()}')
		") ;
}




