<?php
namespace Project5;

class CategoryManager extends Manager
{
	// OPERATION EN BDD :  add  edit   getOne  getCategoryName  delete  getAll
	
	public function add(Category $category)
	{
		$q = $this->_db->prepare('INSERT INTO categories(name) VALUES(:name');
		$q->bindValue('name', $post->getName());
		$q->execute();
	}

	public function edit(Category $category)
	{
		$q = $this->_db->prepare('UPDATE categories SET name = :name WHERE id = :id');
		$q->bindValue('id', $user->getId());
		$q->bindValue('name', $user->getName());
		$q->execute();
	}

	public function getOne($category)
	{ 
		if (ctype_digit($category))
		{
			$q = $this->_db->query('SELECT * FROM categories WHERE id=' .$category);
			$data=$q->fetch();
			return new Category($data);
		}
	}

	public function getCategoryName(int $category_id)
	{
		$q = $this->_db->query('SELECT * FROM categories WHERE id=' .$category_id);
		$data=$q->fetch(\PDO::FETCH_ASSOC);
		return $data['name'];
	}

	public function getCategoryId(string $category_name)
	{
		$q = $this->_db->query('SELECT * FROM categories WHERE name=' .$category_name);
		$data=$q->fetch(\PDO::FETCH_ASSOC);
		return $data['id'];
	}

	public function delete($id_category)
	{
		if (ctype_digit($id_post))
		{
			$q = $this->_db->exec('DELETE FROM categories WHERE id=' .$id_post);
		}
	}

	public function getAll() 
	{
		$categories=[];
		$q = $this->_db->query('SELECT * FROM categories');
		while($data=$q->fetch(\PDO::FETCH_ASSOC))
		{
			$categories= new Category($data);
		}
		return $categories;
	}
}