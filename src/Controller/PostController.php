<?php
namespace BlogApp\Controller;

use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;
/**
 * 
 */
class PostController extends AbstractController
{
	protected PostManager $postManager;
	protected CategoryManager $categoryManager;
	
	function __construct(PostManager $postManager, CategoryManager $categoryManager)
	{
		$this->postManager = $postManager;
		$this->categoryManager = $categoryManager;
	}

	public function list()
	{
		$categoriesHeader = $this->categoryManager->getAll();
		$last5Posts = $this->postManager->getAll(1);
		$page = $this->requestGet['page'] ?? null ;

		$maxPage=$this->postManager->totalPages();
		$actualPage = $page ?? 1;
        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }
		$posts=$this->postManager->getAll($actualPage);
		echo $this->twig->render('home/list.twig', [
			'posts' => $posts,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);
	}	
}