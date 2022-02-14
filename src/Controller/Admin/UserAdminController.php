<?php
namespace BlogApp\Controller\Admin;

use BlogApp\Controller\AbstractController;
use BlogApp\Entity\User;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class UserAdminController extends AbstractController
{
	protected UserManager $userManager;
	protected CategoryManager $categoryManager;

	public function __construct(UserManager $userManager, CategoryManager $categoryManager)
    {
		parent::__construct();
		$this->userManager = $userManager;
		$this->categoryManager = $categoryManager;
		if(!$this->userManager->isAdmin())
		{
			$this->forbidden();
		}
	}


	public function manageUsers()
	{
		$adminUserDelete = $this->requestPost['admin_user_delete'] ?? null;
		$idUserValid = $this->requestGet['valid'] ?? null;

		if(!empty($idUserValid))
		{
			$this->userManager->valid($idUserValid);
		}
		if($adminUserDelete)
		{
			$this->userManager->delete($adminUserDelete);
		}
		$users = $this->userManager->getList();

		return $this->render('admin/manage_user.html.twig', [
			'users' => $users,
			'categories_header' =>  $this->categoryManager->getAll()
				]);
	}
}