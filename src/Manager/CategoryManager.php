<?php
namespace BlogApp\Manager;

use BlogApp\Entity\Category ;

class CategoryManager extends Manager
{
	// OPERATION EN BDD :  add  edit   getOne  getCategoryName  getCategoryId  delete  getAll
	
	public function add(Category $category)
	{
		$q = $this->_db->prepare('INSERT INTO categories(name) VALUES(:name)');
		$q->bindValue('name', $category->getName());
		$q->execute();
	}

	public function edit(Category $category)
	{
		$q = $this->_db->prepare('UPDATE categories SET name = :name WHERE id = :id');
		$q->bindValue('id', $category->getId());
		$q->bindValue('name', $category->getName());
		$q->execute();
	}

	public function getOne(int $category_id)
	{ 
		$q = $this->_db->query('SELECT * FROM categories WHERE id=' .$category_id);
		$data=$q->fetch();
		return new Category($data);
	}

	public function getCategoryName($category_id)
	{
		$q = $this->_db->query('SELECT * FROM categories WHERE id=' .$category_id);
		$data=$q->fetch(\PDO::FETCH_ASSOC);
		$name = $data['name'];
		return $name; 
	}

	public function getCategoryId($category_name)
	{
		$q = $this->_db->query('SELECT id FROM categories WHERE name="' .$category_name. '" ');
		$data=$q->fetch(\PDO::FETCH_ASSOC);
		return $data;
	}

	public function delete($info)
	{
		if (ctype_digit($info))
		{
			$q = $this->_db->exec('DELETE FROM categories WHERE id=' .$info);
		}
	}

	public function getAll() 
	{
		$categories=[];
		$q = $this->_db->query('SELECT id, name FROM categories');
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$categories[]= new Category($data);
		}
		return $categories;
	}
}