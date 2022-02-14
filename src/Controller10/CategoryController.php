<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Category;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;


class CategoryController extends AbstractController
{
	protected PostManager $postManager;
	protected CategoryManager $categoryManager;
	
	function __construct(PostManager $postManager, CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->postManager = $postManager;
		$this->categoryManager = $categoryManager;
	}

	public function listByCategory()
	{
		$page = $this->requestGet['page'] ?? null ;
		$categoryId = $this->requestGet['id'];

		$allCategory = $this->categoryManager->getAll();
		$categoryIdPossible = [];
		foreach ($allCategory as $oneCategory) 
		{
			$categoryIdPossible[] = $oneCategory->getId();
		}
		if ( !in_array($categoryId, $categoryIdPossible))
		{
			header('Location:index.php?p=home');
		}

		$category = $this->categoryManager->getOne($categoryId);
		$maxPage=$this->postManager->totalPagesByCategory($categoryId);
			
		$actualPage = $page ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }

		$posts=$this->postManager->getWithCategory($categoryId,$actualPage);
		
		return $this->render('home/list.html.twig', [
			'posts' => $posts,
			'category' => $category,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
				]);

	}

}