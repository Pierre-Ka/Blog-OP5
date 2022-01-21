<?php
use BlogApp\Entity\Comment;
use BlogApp\Entity\Post;
use BlogApp\Entity\User;
use BlogApp\Entity\Category;

////////// UserController

if($page==='admin.home')
{
    if(( $user_manager->logged() AND $user_manager->isAdmin() ))
    {
        if(isset($_POST['admin_post_delete']))
        {
            $post_manager->delete($_POST['admin_post_delete']);
        }
        $connect_id = $user_manager->getUserId();
        $posts = $post_manager->getAllAdmin();
        require('view/admin/home.php');
    }
    else
    {
        $incorrect=true;
        require('view/home/sign_in.php');
    }
}
if($page==='admin.manage_user')
{
	if(!empty($_GET['valid']))
	{
		$user_manager->valid(($_GET['valid']));
	}
	if(isset($_POST['admin_user_delete']))
	{
		$user_manager->delete($_POST['admin_user_delete']);
	}
	$users = $user_manager->getList();
	require('view/admin/manage_user.php');
}
if($page==='admin.manage_category')
{
	if(empty($_POST))
	{
		$categories = $category_manager->getAll();
		require('view/admin/manage_category.php');
	}
	else
	{
		switch($_POST)
		{
			case isset($_POST['categoryEdit']) : 
			$categorie = $category_manager->getOne($_GET['id']);
			$categorie->setName(htmlspecialchars($_POST['categoryEdit']));
			$category_manager->edit($categorie);
			break ;

			case isset($_POST['categoryCreate']) :
			$category = new Category([
				'name'=> htmlspecialchars($_POST['categoryCreate'])
				]);
			$category_manager->add($category);
			break ; 

			case isset($_POST['admin_category_delete']) :
			$category_manager->delete($_POST['admin_category_delete']);
			break ; 
		}
		header('Location:index.php?p=admin.home');
	}
}