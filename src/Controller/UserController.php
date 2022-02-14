<?php
namespace BlogApp\Controller;

use BlogApp\Entity\User;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\CategoryManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CommentManager;

// CREATION DU CRUD : create read update delete
class UserController extends AbstractController
{
	protected PostManager $postManager;
    protected UserManager $userManager;
    protected CategoryManager $categoryManager;
    protected CommentManager $commentManager;
	
	function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
	{
		parent::__construct();
		$this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
	}

	public function create()
	{
		if (!$_POST)
		{
			return $this->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoryManager->getAll()
					]);
		}
		else
		{
	        $emailCreate = $this->requestPost['emailCreate'] ?? null;
	        $nameCreate = $this->requestPost['nameCreate'] ?? null;
	        $passwordCreate = $this->requestPost['passwordCreate'] ?? null;
	        $passwordConfirm = $this->requestPost['passwordConfirm'] ?? null;
	        $descriptionCreate = $this->requestPost['descriptionCreate'] ?? null;

			if ( $emailCreate && $nameCreate && $passwordCreate && $passwordConfirm && $descriptionCreate && ($passwordCreate === $passwordConfirm) && (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $emailCreate)) )
			{ 
				$user = new User([
				'email'=> htmlspecialchars($emailCreate),
				'password'=> htmlspecialchars($passwordConfirm),
				'name'=> htmlspecialchars($nameCreate),
				'description'=> htmlspecialchars($descriptionCreate)
				]);
				$this->userManager->add($user);
					
				return $this->render('home/sign_in.html.twig', [
					'message' => 'enregistrement reussi',
					'incorrect' => false,
					'categories_header' => $this->categoryManager->getAll()
						]);
			}

			else
			{
				return $this->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoryManager->getAll(),
				'incorrect' => true
					]);
			}
		}
	}
    // CREATION DE LA FONCTION delete ET REPOSITIONNEMENT DANS LE POSTCONTROLLER
   /* public function delete(){

        if(!$this->userManager->logged())
        {
            $this->forbidden();
        }
        $idPostDelete = $this->requestPost['id_delete'] ?? null;

        if($idPostDelete)
        {
            $this->postManager->delete($idPostDelete);
            $this->commentManager->deletePerPost($idPostDelete);
        }
    }*/
	public function home()
	{
		if(!$this->userManager->logged())
		{
			$this->forbidden();
		}
		$idPostDelete = $this->requestPost['id_delete'] ?? null;

	    if($idPostDelete)
	    {
	        $this->postManager->delete($idPostDelete);
	        $this->commentManager->deletePerPost($idPostDelete);
	    }
	    $connectId = $this->userManager->getUserId();
	    $posts = $this->postManager->getWithUserId($connectId);
	    $user = $this->userManager->getOne($connectId);
	    $admin = $this->userManager->isAdmin($connectId);

		return $this->render('user/home.html.twig', [
			'user' => $user,
			'posts' => $posts,
			'admin' => $admin,
			'categories_header' => $this->categoryManager->getAll()
				]);
	}

	public function edit()
	{
		if(!$this->userManager->logged())
		{
			$this->forbidden();
		}

	    $user = $this->userManager->getOne($this->userManager->getUserId());

	    if (!$_POST && !$_FILES)
	    {
	        return $this->render('user/edit.html.twig', [
				'user' => $user,
				'categories_header' => $this->categoryManager->getAll()
					]);
	    }

	    else
	    {
		    if ($_FILES)
		    {
				if (isset($_FILES['pictureUpdate']) && ($_FILES['pictureUpdate']['error'] == 0) && ($_FILES['pictureUpdate']['size'] <= 5000000)) 
				{
		            $infosfichier = pathinfo($_FILES['pictureUpdate']['name']);
		            $extensionUpload = $infosfichier['extension'];
		            $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
		            if (in_array($extensionUpload, $extensionsAutorisees))
		            {
		            	$pictureName = 'USER_IMG_' . $user->getId() .'.'.$extensionUpload ;
		            	$pathPicture = '../var/media/user/'. $pictureName ;
		            	// resizeImageWithCrop ou resizeImage ??
		            	$picture = $user->resizeImageWithCrop($_FILES['pictureUpdate']['tmp_name'], $pathPicture, 100, 100);
		   				//move_uploaded_file($_FILES['pictureUpdate']['tmp_name'], $pathPicture);	                
		    			$user->setPicture($pictureName);
		                $this->userManager->edit($user);
		                $message = 'Votre image de profil a bien été modifié';
		            }   
			    }
			}
			if ($_POST) 
			{
				$nameUpdate = $this->requestPost['nameUpdate'] ?? null;
		        $passwordUpdate = $this->requestPost['passwordUpdate'] ?? null;
		        $passwordConfirm = $this->requestPost['passwordConfirm'] ?? null;
		        $descriptionUpdate = $this->requestPost['descriptionUpdate'] ?? null;

				if ($nameUpdate)
				{
					$user->setName(htmlspecialchars($nameUpdate));
				}
				if ($passwordUpdate && $passwordConfirm) 
				{
					if ($passwordUpdate !== $passwordConfirm) 
	                {
						$message = 'Les mots de passe ne correspondent pas';
	                }
	                else
	                {
	                	$user->setPassword(sha1(htmlspecialchars($passwordConfirm)));
	                }
				}
		        if($descriptionUpdate)
				{  
		            $user->setDescription(htmlspecialchars($descriptionUpdate));
		        }
		        $this->userManager->edit($user);
		        if(!isset($message))
		        {
		        	$message = 'Votre profil a bien été modifié';
		        }
		    }
		    return $this->render('user/edit.html.twig', [
				'user' => $user,
				'message' => $message,
				'categories_header' => $this->categoryManager->getAll()
					]);
	    }
	}

}