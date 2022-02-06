<?php
namespace BlogApp\Controller;

use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;


class CategoryController extends AbstractController
{
	protected PostManager $postManager;
	protected CategoryManager $categoryManager;
	
	function __construct(PostManager $postManager, CategoryManager $categoryManager)
	{
		$this->postManager = $postManager;
		$this->categoryManager = $categoryManager;
	}

	public function listByCategory()
	{
		$page = $this->requestGet['page'] ?? null ;
		$categoryId = $this->requestGet['id'];

		$category = $this->categoryManager->getOne($categoryId);
		$maxPage=$this->postManager->totalPagesByCategory($categoryId);
			
		$actualPage = $page ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }

		$posts=$this->postManager->getWithCategory($categoryId,$actualPage);
		
		echo $this->twig->render('home/list.twig', [
			'posts' => $posts,
			'category' => $category,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);

	}

}