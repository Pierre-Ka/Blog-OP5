<?php
namespace BlogApp\Faker;

require_once '../../vendor/autoload.php';

class FakeData
{
	private $faker ;
	private $db ;

	public function __construct()
	{
		$db = new \PDO('mysql:host=localhost;dbname=project5_blog;charset=utf8', 'root', 'root');
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
		$this->db = $db ;
		$faker = \Faker\Factory::create();
		$this->faker = $faker ;
	}

	public function fakeComment(int $startNumber, int $endNumber, int $numberOfPost = null)
	{
		foreach(range($startNumber, $endNumber) as $id)
		{
			$this->db->query("
				INSERT INTO comment 
				(id, post_id, author, content, is_valid, create_date) 
				VALUES
				(
				'" . $id . "',
				'{$this->faker->numberBetween(1, 110)}',
				'{$this->faker->name()}',
				'{$this->faker->sentence(15)}',
				'{$this->faker->numberBetween(0,1)}',
				'{$this->faker->date()}'
				)
				") ;
		}
		$number = $endNumber - $startNumber ; 
		$message = $number . ' Faux commentaires crées';
		return $message ;
	}

	public function fakeUser(int $startNumber,int  $endNumber)
	{
		foreach(range($startNumber, $endNumber) as $id)
		{
			$db->query("
				INSERT INTO user
				(id,email, password, name, picture, description, inscription_date, is_valid ) 
				VALUES
				('" . $id . "',
				'{$faker->email()}',
				'{$faker->password()}',
				'{$faker->name()}',
				'USER_IMG.jpg',
				'{$faker->sentence(15)}',
				'{$faker->date()}',
				'1')
				") ;
		}
		$number = $endNumber - $startNumber ; 
		$message = $number . 'Faux membres créés ';
		return $message ;
	}

	public function fakePost(int $startNumber,int  $endNumber, int $lastUserId = null, int $lastCategoryId = null)
	{
		foreach(range($startNumber, $endNumber) as $id)
		{
			$body= '<p>' . implode('</p><p>', $this->faker->paragraphs(20)) . '</p>';

			$this->db->query("
				INSERT INTO post 
				(id, title, user_id, category_id, chapo, content, create_date) 
				VALUES
				('" . $id . "',
				'{$this->faker->sentence(6)}',
				'{$this->faker->numberBetween(1,8)}', 
				'{$this->faker->numberBetween(1,5)}',
				'{$this->faker->sentence(15)}',
				'$body',
				'{$this->faker->date()}')
				") ;
		}
		$number = $endNumber - $startNumber ; 
		$message = $number . 'Faux posts créés ';
		return $message ;
	}
}
