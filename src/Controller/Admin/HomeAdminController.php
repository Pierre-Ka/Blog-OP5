<?php
namespace BlogApp\Controller\Admin;

use BlogApp\Faker\FakeData;

use BlogApp\Controller\AbstractController;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class HomeAdminController extends AbstractController
{
	protected PostManager $postManager;
    protected CategoryManager $categoryManager;
    protected CommentManager $commentManager;
    protected UserManager $userManager;

	public function __construct(PostManager $postManager, UserManager $userManager,CategoryManager $categoryManager, CommentManager $commentManager)
    {
		parent::__construct();
		$this->postManager = $postManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
        $this->userManager = $userManager;
		if(!$this->userManager->isAdmin())
		{
			$this->forbidden();
		}
	}

	public function adminHome()
	{
		$faker = $this->requestGet['faker'] ?? null;
		$adminPostDelete = $this->requestPost['admin_post_delete'] ?? null;

		if (isset($faker))
		{
			header('Location: ../template/admin/faker.php');
		}
		if($adminPostDelete)
	    {
	        $this->postManager->delete($adminPostDelete);
	        $this->commentManager->deletePerPost($adminPostDelete);
	    }
	    $posts = $this->postManager->getAllAdmin();

	    return $this->render('admin/home.html.twig', [
			'posts' => $posts,
			'categories_header' => $this->categoryManager->getAll()
				]);
	}
}
