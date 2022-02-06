<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Post;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class BackController extends AbstractController
{
    public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
    {
        parent::__construct($postManager, $userManager, $categoryManager, $commentManager);
        if(!$this->userManager->logged())
		{
			$this->forbidden();
		}
    }

	public function userHome()
	{
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

		return $this->twig->render('user/home.twig', [
			'user' => $user,
			'posts' => $posts,
			'admin' => $admin,
			'categories_header' => $this->categoriesHeader
				]);
	}

	public function editUser()
	{
	    $user = $this->userManager->getOne($this->userManager->getUserId());
	    if (!$_POST && !$_FILES)
	    {
	        return $this->twig->render('user/edit.twig', [
				'user' => $user,
				'categories_header' => $this->categoriesHeader
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
		    return $this->twig->render('user/edit.twig', [
				'user' => $user,
				'message' => $message,
				'categories_header' => $this->categoriesHeader
					]);
	    }
	}

	public function editPost()
	{
        $postId = $this->requestGet['id'] ;
        $idPostValid = $this->requestGet['valid'] ?? null;
        $idPostDelete = $this->requestGet['delete'] ?? null;

	    $post = $this->postManager->getOne($postId);
	    $comments = $this->commentManager->getNotYetValid($postId);
	    $categories = $this->categoryManager->getAll();

	    if(!($_POST) && !($_FILES))
	    {
	        if ($idPostValid)
	        {
                $this->commentManager->valid($idPostValid);
            }
            if ($idPostDelete)
            {
	            $this->commentManager->delete($idPostDelete);
	        }
	        $comments = $this->commentManager->getNotYetValid($postId);
	        
	        return $this->twig->render('user/post_edit.twig', [
				'post' => $post,
				'comments' => $comments,
				'categories' => $categories,
				'categories_header' => $this->categoriesHeader
					]);
	        
	    }

	    else
	    {
		    if (isset($_FILES['pictureChange']) && ($_FILES['pictureChange']['error'] == 0) && ($_FILES['pictureChange']['size'] <= 5000000)) 
		    { 
	            $infosfichier = pathinfo($_FILES['pictureChange']['name']);
	            $extensionUpload = $infosfichier['extension'];
	            $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
	            if (in_array($extensionUpload, $extensionsAutorisees))
	            {
	                move_uploaded_file($_FILES['pictureChange']['tmp_name'], '../var/media/post/POST_IMG_' . $postId .'.'.$extensionUpload);
	        
	                $pictureName = 'POST_IMG_' . $postId .'.'.$extensionUpload ;
	                $post->setPicture($pictureName);
	                $this->postManager->edit($post);

	                $widgetPath = '../var/media/post/MINI_POST_IMG_' . $postId .'.'.$extensionUpload ;
	                $picturePath = '../var/media/post/POST_IMG_' . $postId .'.'.$extensionUpload ; 
	                // resizeImageWithCrop
	                $picture = $post->resizeImage($picturePath, $widgetPath, 60, 60);
	                $message = 'L\'image a été modifié avec succès' ;
	            }
		         
		    }
		    if ($_POST)
		    {
		    	$titleChange = $this->requestPost['titleChange'] ?? null;
		        $categoryChange = $this->requestPost['categoryChange'] ?? null;
		        $chapoChange = $this->requestPost['chapoChange'] ?? null;
		        $contentChange = $this->requestPost['contentChange'] ?? null;

		        $post->setTitle(htmlspecialchars($titleChange)); 
		        $post->setCategory_id($categoryChange); 
		        $post->setChapo(htmlspecialchars($chapoChange)); 
		        $post->setContent(htmlspecialchars($contentChange));

		        $this->postManager->edit($post);
		        if (isset($message))
		        {
		        	$message .= '<br/>Le post a été modifié avec succès' ;
		    	}
		    	else
		    	{
		    		$message = 'Le post a été modifié avec succès' ;
		    	}

		    }
	        return $this->twig->render('user/post_edit.twig', [
	            'message' => $message,
			 	'post' => $post,
				'comments' => $comments,
				'categories' => $categories,
				'categories_header' => $this->categoriesHeader
					]);
		    
		}
	}

	public function addPost()
	{
		//if(!$title || !$category || !$chapo || !$content)
		if(!$_POST)
        {
        	return $this->twig->render('user/post_edit.twig', [
				'categories' => $categories,
				'categories_header' => $this->categoriesHeader
					]);
		}

		else
		{
			$title = $requestPost['title'] ?? null;
		    $category = $requestPost['category'] ?? null;
		    $chapo = $requestPost['chapo'] ?? null;
		    $content = $requestPost['content'] ?? null;
	        $categories = $this->categoryManager->getAll();	

        	$post= new Post([	// SANS HYDRATATION    // $post= new Post();
				'title'=>htmlspecialchars($title), 	   //  $post->setTitle
	            'user_id'=> $this->userManager->getUserId(),	// ect ...
	            'category_id'=>($category),
	            'chapo'=>htmlspecialchars($chapo),
	            'content'=>htmlspecialchars($content)
	               ]);

	        $this->postManager->add($post);
	        $newId = $this->postManager->getLastInsertId();

	        if (isset($_FILES['picture']) && ($_FILES['picture']['error'] == 0) && ($_FILES['picture']['size'] <= 5000000)) 
		    { 
	            $infosfichier = pathinfo($_FILES['picture']['name']);
	            $extensionUpload = $infosfichier['extension'];
	            $extensionsAutorisees = array('jpg', 'jpeg', 'gif', 'png');
	            if (in_array($extensionUpload, $extensionsAutorisees))
	            {
	            	$pictureName = 'POST_IMG_' . $newId .'.'.$extensionUpload ;
	                $picturePath = '../var/media/post/' .  $pictureName;
	                move_uploaded_file($_FILES['picture']['tmp_name'], $picturePath);

	                $post->setPicture($pictureName);
	                $post->setId($newId);	// ON DOIT LUI ATTRIBUER L'ID RECUPERE
	                $this->postManager->edit($post); // GRACE A CA, ON L'ENREGISTRE

	                $widgetPath = '../var/media/post/MINI_POST_IMG_' . $newId .'.'.$extensionUpload ;

	                // resizeImageWithCrop
	                $picture = $post->resizeImage($picturePath, $widgetPath, 60, 60);

	                $message = ' L\'article et l\'image ont été ajouté avec succès ';

	                return $this->twig->render('user/post_edit.twig', [
						'categories' => $categories,
						'message' => $message,
						'categories_header' => $this->categoriesHeader
							]);
	            }
                else
                {
                	$message = ' L\'article a été rajouté avec succès ';
			    	return $this->twig->render('user/post_edit.twig', [
						'categories' => $categories,
						'message' => $message,
						'categories_header' => $this->categoriesHeader
							]);

                }
        	}
        	else
	        {
	        	$message = ' L\'article a été rajouté avec succès';
		    	return $this->twig->render('user/post_edit.twig', [
					'categories' => $categories,
					'message' => $message,
					'categories_header' => $this->categoriesHeader
						]);
			
	        }
		}
	}
}
