<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Post;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class UserController extends AbstractController
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
		$idPostDelete = $_POST['id_delete'] ?? null;

	    if($idPostDelete)
	    {
	        $this->postManager->delete($idPostDelete);
	        $this->commentManager->deletePerPost($idPostDelete);
	    }
	    $connect_id = $this->userManager->getUserId();
	    $posts = $this->postManager->getWithUserId($connect_id);

		echo $this->twig->render('user/home.twig', [
			'posts' => $posts,
			'categories_header' => $this->categories_header
				]);
	}

	public function editUser()
	{
		$pictureUpdate = $_FILES['pictureUpdate'] ?? null;
        $nameUpdate = $_POST['nameUpdate'] ?? null;
        $passwordUpdate = $_POST['passwordUpdate'] ?? null;
        $passwordConfirm = $_POST['passwordConfirm'] ?? null;
        $descriptionUpdate = $_POST['descriptionUpdate'] ?? null;

	    $user = $this->userManager->getOne($this->userManager->getUserId());
	    if (isset($_FILES['pictureUpdate']) AND $_FILES['pictureUpdate']['error'] == 0)
	    {
	        if ($_FILES['pictureUpdate']['size'] <= 1000000)
	        {
	                $infosfichier = pathinfo($_FILES['pictureUpdate']['name']);
	                $extension_upload = $infosfichier['extension'];
	                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
	                if (in_array($extension_upload, $extensions_autorisees))
	                {
	                    move_uploaded_file($_FILES['pictureUpdate']['tmp_name'], '../var/media/user/USER_IMG_' . $user->getId() .'.'.$extension_upload);
	            
	                    $picture_name = 'USER_IMG_' . $user->getId() .'.'.$extension_upload ;
	                    $user->setPicture($picture_name);
	                    $this->userManager->edit($user);

	                    $picture_name = $user->resize_image('../var/media/user/'.$picture_name, 300, 300);
	                    $message = 'Votre profil a bien été modifié';
	               		header('Location:user.home');
	                }
	         }
	    }
	    if(empty($_POST))
	    {
	        echo $this->twig->render('user/edit.twig', [
				'user' => $user,
				'categories_header' => $this->categories_header
					]);
	    }
	    else
	    {
	        switch ($_POST)
	        {
	                case !empty($nameUpdate) :
	            	$user->setName(htmlspecialchars($nameUpdate));
	            	
	                case !empty($passwordUpdate) AND !empty($passwordConfirm)
	                    AND ($passwordUpdate === $passwordConfirm) : 
	                $password=htmlspecialchars($passwordConfirm);
	                $user->setPassword(sha1($password));
	                
	                case !empty($descriptionUpdate) :  
	            	$user->setDescription(htmlspecialchars($descriptionUpdate));

	        }
	        $this->userManager->edit($user);
	        $message = 'Votre profil a bien été modifié';
	        header('Location:user.home');
	    }

	}

	public function editPost()
	{
        $titleChange = $_POST['titleChange'] ?? null;
        $categoryChange = $_POST['categoryChange'] ?? null;
        $chapoChange = $_POST['chapoChange'] ?? null;
        $contentChange = $_POST['contentChange'] ?? null;

	    $post = $this->postManager->getOne($_GET['id']);
	    $comments = $this->commentManager->getNotYetValid($_GET['id']);
	    $categories = $this->categoryManager->getAll();

	    if (isset($_FILES['pictureChange']) && ($_FILES['pictureChange']['error'] == 0) && ($_FILES['pictureChange']['size'] <= 5000000)) 
	    { 
            $infosfichier = pathinfo($_FILES['pictureChange']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($extension_upload, $extensions_autorisees))
            {
                move_uploaded_file($_FILES['pictureChange']['tmp_name'], '../var/media/post/POST_IMG_' . $_GET['id'] .'.'.$extension_upload);
        
                $picture_name = 'POST_IMG_' . $_GET['id'] .'.'.$extension_upload ;
                $post->setPicture($picture_name);
                $this->postManager->edit($post);

                $message = 'L\'image a été modifié avec succès' ;
                echo $this->twig->render('user/post_edit.twig', [
                	'message' => $message,
					'post' => $post,
					'comments' => $comments,
					'categories' => $categories,
					'categories_header' => $this->categories_header
						]);
            }
	         
	    }
	    if(empty($_POST))
	    {
	        if(!empty($_GET['valid']) || !empty($_GET['delete']))
	        {
	            switch ($_GET)
	            {
	                case !empty($_GET['valid']) :
	                $this->commentManager->valid(($_GET['valid']));
	                break ;
	                case !empty($_GET['delete']) : 
	                $this->commentManager->delete(($_GET['delete']));
	                break ;
	            }
	        }
	        
	        echo $this->twig->render('user/post_edit.twig', [
				'post' => $post,
				'comments' => $comments,
				'categories' => $categories,
				'categories_header' => $this->categories_header
					]);
	        
	    }
	    else
	    {
	        switch ($_POST)
	        {
	                case !empty($titleChange) :
	            $post->setTitle(htmlspecialchars($titleChange)); 

	                case !empty($categoryChange) :
	            $post->setCategory_id($categoryChange);

	                case !empty($chapoChange) :    
	            $post->setChapo(htmlspecialchars($chapoChange)); 

	                case !empty($contentChange) :
	            $post->setContent(htmlspecialchars($contentChange));
	        }
	        $this->postManager->edit($post);
	        $message = 'Le post a été modifié avec succès' ;
                echo $this->twig->render('user/post_edit.twig', [
                	'message' => $message,
					'post' => $post,
					'comments' => $comments,
					'categories' => $categories,
					'categories_header' => $this->categories_header
						]);
	    }
	}

	public function addPost()
	{
		$title = $_POST['title'] ?? null;
	    $category = $_POST['category'] ?? null;
	    $chapo = $_POST['chapo'] ?? null;
	    $content = $_POST['content'] ?? null;
        $categories = $this->categoryManager->getAll();	

		if(!$title || !$category || !$chapo || !$content)
        {
        	echo $this->twig->render('user/post_edit.twig', [
				'categories' => $categories,
				'categories_header' => $this->categories_header
					]);
		}

		else
		{
        	$post= new Post([	// SANS HYDRATATION    // $post= new Post();
				'title'=>htmlspecialchars($title), 	   //  $post->setTitle
	            'user_id'=> $this->userManager->getUserId(),	// ect ...
	            'category_id'=>($category),
	            'chapo'=>htmlspecialchars($chapo),
	            'content'=>htmlspecialchars($content)
	               ]);

	        $this->postManager->add($post);
	        $new_id = $this->postManager->getLastInsertId();

        	if($_FILES['picture']['error'] == 0 && ($_FILES['picture']['size'] <= 5000000))
        	{
        		$infosfichier = pathinfo($_FILES['picture']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                	$picture_name = 'POST_IMG_' . $new_id .'.'.$extension_upload ;
                	$resizePath = '../var/media/post/POST_IMG_' . $new_id .'.'.$extension_upload ;
                	$widgetPath = '../var/media/post/MINI_IMG_' . $new_id .'.'.$extension_upload ;
    // J'enregistre l'image resizé uniquement
                	$picture = $post->resizeImage($_FILES['picture']['tmp_name'], $resizePath, 550, 400);

    //move_uploaded_file($_FILES['picture']['tmp_name'], $resizePath); NO NEED
    // $widget = $post->resizeImage($_FILES['picture']['tmp_name'], $widgetPath, 60, 60);		// $widgetPath NOT FIND 
    //$widget = $post->resizeImage($resizePath, $widgetPath, 60, 60);
                  // $widgetPath NOT FIND
    ////$widget = $post->resizeImage($resizePath, $resizePath, 60, 60); 
                  // Ca marche mais il m'ecrase l'image resize au profit de la miniature
					
                    $post->setPicture($picture_name);
                    $post->setId($new_id);
// Nous sommes obligé de donner un id ( avec get lastInsertId pour pouvoir editer de nouveau notre objet Post : sinon il ne sait pas lequel éditer )
                    $this->postManager->edit($post);
                    $message = ' L\'article et l\'image ont été ajouté avec succès ';
                    echo $this->twig->render('user/post_edit.twig', [
						'categories' => $categories,
						'message' => $message,
						'categories_header' => $this->categories_header
							]);
                }
                else
                {
                	$message = ' L\'article a été rajouté avec succès ';
			    	echo $this->twig->render('user/post_edit.twig', [
						'categories' => $categories,
						'message' => $message,
						'categories_header' => $this->categories_header
							]);

                }
        	}
        	else
	        {
	        	$message = ' L\'article a été rajouté avec succès';
		    	echo $this->twig->render('user/post_edit.twig', [
					'categories' => $categories,
					'message' => $message,
					'categories_header' => $this->categories_header
						]);
			
	        }
		}
	}
}


