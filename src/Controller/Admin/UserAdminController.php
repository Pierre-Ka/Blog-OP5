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

    public function valid()
    {
        $idUserValid = $this->requestGet['id'] ?? null;
		if(!empty($idUserValid))
		{
			$this->userManager->valid($idUserValid);
		}
		$users = $this->userManager->getList();
		return $this->render('admin/manage_user.html.twig', [
			'users' => $users,
			'categories_header' =>  $this->categoryManager->getAll()
				]);
	}

    public function delete()
    {
        $adminUserDelete = $this->requestPost['admin_user_delete'] ?? null;
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

	public function list()
	{
		$users = $this->userManager->getList();
		return $this->render('admin/manage_user.html.twig', [
			'users' => $users,
			'categories_header' =>  $this->categoryManager->getAll()
				]);
	}
}