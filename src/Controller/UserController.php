<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\Post;
use BlogApp\Entity\User;
use BlogApp\Entity\Category;

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
	    if($this->userManager->logged())
	    {
	        if(isset($_POST['id_delete']) )
	        {
	            $this->postManager->delete($_POST['id_delete']);
	            $this->commentManager->deletePerPost($_POST['id_delete']);
	        }
	        $connect_id = $this->userManager->getUserId();
	        $posts = $this->postManager->getWithUserId($connect_id);
	        require('view/user/home.php');
	    }
	    else
	    {
	        $incorrect=true;
	        require('view/home/sign_in.php');
	    }
	}

	public function editUser()
	{
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
	                    move_uploaded_file($_FILES['pictureUpdate']['tmp_name'], 'assets/media/photo/USER_IMG_' . $user->getId() .'.'.$extension_upload);
	            
	                    $picture_name = 'USER_IMG_' . $user->getId() .'.'.$extension_upload ;
	                    $user->setPicture($picture_name);
	                    $this->userManager->edit($user);

	                    $picture_name = $user->resize_image('assets/media/photo/'.$picture_name, 300, 300);
	                }
	                header('Location:index.php?p=user.home');
	         }
	    }
	    if(empty($_POST))
	    {
	        require('view/user/edit.php');
	    }
	    else
	    {
	        switch ($_POST)
	        {
	                case !empty($_POST['nameUpdate']) :
	            $user->setName(htmlspecialchars($_POST['nameUpdate'])); 

	                case !empty($_POST['passwordUpdate']) AND !empty($_POST['passwordConfirm']) :
	                    if (($_POST['passwordUpdate'])=== ($_POST['passwordConfirm']) )
	                        {
	                            $password=htmlspecialchars($_POST['passwordConfirm']);
	                            $user->setPassword(sha1($password));
	                        }
	                case !empty($_POST['descriptionUpdate']) :  
	            $user->setDescription(htmlspecialchars($_POST['descriptionUpdate'])); 
	        }
	        $this->userManager->edit($user);
	        header('Location:index.php?p=user.home');
	    }

	}

		public function editPost()
	{
	    $post = $this->postManager->getOne($_GET['id']);
	    if (isset($_FILES['pictureChange']) AND $_FILES['pictureChange']['error'] == 0)
	    {
	        if ($_FILES['pictureChange']['size'] <= 1000000)
	        {
	                $infosfichier = pathinfo($_FILES['pictureChange']['name']);
	                $extension_upload = $infosfichier['extension'];
	                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
	                if (in_array($extension_upload, $extensions_autorisees))
	                {
	                    move_uploaded_file($_FILES['pictureChange']['tmp_name'], 'assets/media/photo/POST_IMG_' . $_GET['id'] .'.'.$extension_upload);
	            
	                    $picture_name = 'POST_IMG_' . $_GET['id'] .'.'.$extension_upload ;
	                    $post->setPicture($picture_name);
	                    $this->postManager->edit($post);

	                    $picture_name = $post->resize_image('assets/media/photo/'.$picture_name, 500, 500);
	                }
	                header('Location:index.php?p=user.home');
	         }
	    }
	    if(empty($_POST))
	    {
	        if(!empty($_GET['valid']) OR !empty($_GET['delete']))
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
	        $comments = $this->commentManager->getNotYetValid($_GET['id']);
	        $categories = $this->categoryManager->getAll();
	        require('view/user/post/edit.php');
	        
	    }
	    else
	    {
	        switch ($_POST)
	        {
	                case !empty($_POST['titleChange']) :
	            $post->setTitle(htmlspecialchars($_POST['titleChange'])); 

	                case !empty($_POST['categoryChange']) :
	            $post->setCategory_id($_POST['categoryChange']);

	                case !empty($_POST['chapoChange']) :    
	            $post->setChapo(htmlspecialchars($_POST['chapoChange'])); 

	                case !empty($_POST['contentChange']) :
	            $post->setContent(htmlspecialchars($_POST['contentChange']));
	        }
	        $this->postManager->edit($post);
	        header('Location:index.php?p=user.home');
	    }
	}

	public function addPost()
	{
	    if(!empty($_POST))
	    {
	        if(!empty($_POST['title']) AND !empty($_POST['category']) AND !empty($_POST['chapo']) AND !empty($_POST['content'])) 
	        {
	            if (isset($_FILES['picture']) AND $_FILES['picture']['error'] == 0 AND ($_FILES['picture']['size'] <= 1000000))
	            {
	                $infosfichier = pathinfo($_FILES['picture']['name']);
	                $extension_upload = $infosfichier['extension'];
	                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
	                if (in_array($extension_upload, $extensions_autorisees))
	                {
	                   
	                    $post= new Post([

	                        'title'=>htmlspecialchars($_POST['title']),
	                        'user_id'=> $this->userManager->getUserId(),
	                        'category_id'=>($_POST['category']),
	                        'chapo'=>htmlspecialchars($_POST['chapo']),
	                        'content'=>htmlspecialchars($_POST['content'])
	                    ]); 

	                    /*$post= new Post(); // Sans hydratation : 
	                    $post->setTitle(htmlspecialchars($_POST['title'])); 
	                    $post->setCategory_id($category_id);
	                    $post->setChapo(htmlspecialchars($_POST['chapo'])); 
	                    $post->setContent(htmlspecialchars($_POST['content']));*/

	                    $this->postManager->add($post);
	                    $new_id = $this->postManager->getLastInsertId();
	 
	                    move_uploaded_file($_FILES['picture']['tmp_name'], 'assets/media/photo/POST_IMG_' . $new_id .'.'.$extension_upload);// Oui
	                    $picture_name = 'POST_IMG_' . $new_id .'.'.$extension_upload ;
	                    $post->setPicture($picture_name);

	                    // $postManager->edit($post); ne marchait pas car nous n'avions pas setter l'id du post nouvellement crée. On corrige alors cela ( source David )
	                    $post->setId($new_id);

	                    // Maintenant ça marche
	                    $this->postManager->edit($post);

	                    $picture_name = $post->resize_image('assets/media/photo/'.$picture_name, 500, 500);
	                    header('Location:index.php?p=user.home');
	                    
	                }
	            }
	        }
	        else
	        {
	            echo 'veuillez remplir tous les champs';
	        }
	    }
	    else
	    {
	        $categories = $this->categoryManager->getAll();
	        require('view/user/post/add.php');
	    }
	}
}

