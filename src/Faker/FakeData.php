<?php
namespace BlogApp\Faker;

require_once 'vendor/autoload.php';

class FakeData
{
	private $faker ;

	public function __construct()
	{
		$faker = Faker\Factory::create();
		$this->faker = $faker ;
	}

	public function fakeCategory()
	{
		foreach(range(1, 3) as $id)
		{
			$db->query("INSERT INTO categories (id, name) VALUES('" . $id . "','{$faker->sentence(6)}'") ;
		}
		$message = '3 fausses categories crées';
		return $message ;
	}

	public function fakeComment()
	{
		foreach(range(0, 1000) as $id)
		{
			$db->query("
				INSERT INTO comments 
				(id, post_id, author, content, is_valid, create_date) 
				VALUES
				('" . $id . "',
				'{$faker->numberBetween(1, 100)}',
				'{$faker->name()}',
				'{$faker->sentence(15)}',
				'1',
				'{$faker->date()}')
				") ;
		}
		$message = '1000 Faux commentaires crées';
		return $message ;
	}

	public function fakeUser()
	{
		foreach(range(2,8) as $id)
		{
			$db->query("INSERT INTO users (id,email, password, name, picture, description, inscription_date, is_valid ) VALUES('" . $id . "','{$faker->email()}','{$faker->password()}','{$faker->name()}','POST_IMG_{$faker->randomDigit()}','{$faker->sentence(15)}','{$faker->date()}','0')") ;
		}
		$message = '7 Faux membres (id 2 à 8 ) créés ';
		return $message ;
	}

	public function fakePost()
	{
		foreach(range(1, 100) as $id)
		{
			$body= '<p>' . implode('</p><p>', $faker->paragraphs(20)) . '</p>';

			$db->query("INSERT INTO posts (id, title, user_id, category_id, chapo, content, picture, create_date) VALUES('" . $id . "','{$faker->sentence(6)}','{$faker->numberBetween(1, 8)}','{$faker->numberBetween(1, 3)}','{$faker->sentence(15)}','$body','POST_IMG_{$faker->randomDigit()}','{$faker->date()}')") ;
		}
		$message = '100 Faux posts crées';
		return $message ;
	}
}



