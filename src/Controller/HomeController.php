<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\User;
/*
use BlogApp\Entity\Post;
use BlogApp\Entity\Category;
use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;
*/
class HomeController extends AbstractController
{
	public function home()
	{
		$categories_header = $this->categoryManager->getAll();
		//$post_last5=$this->postManager->getAll(1);

		if (isset($_POST['message']) AND isset($_POST['message-email']))  
		{
            $entete  = 'MIME-Version: 1.0' . "\r\n";
            $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $entete .= 'From: webmaster@monsite.fr' . "\r\n";
            $entete .= 'Reply-to: ' . $_POST['email'];

            $message = '<h1>Message envoyé depuis la page Contact de monsite.fr</h1>
            <p><b>Email : </b>' . $_POST['message-email'] . '<br>
            <b>Message : </b>' . htmlspecialchars($_POST['message']) . '</p>';

            $retour = mail('ikanhiu@outlook.fr', 'Envoi depuis page Contact', $message, $entete);
        }

		echo $this->twig->render('home/home.twig', [
			'categories_header' => $this->categoryManager->getAll()
				]);

		/*
		echo $this->twig->render('pre_content.twig', [
			'categories_header' => $this->categoryManager->getAll()
				]);*/
				
	}


	public function post()
	{
		$categories_header = $this->categoryManager->getAll();
		$max_page=$this->postManager->totalPages();

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<= $max_page)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$posts=$this->postManager->getAll($actual_page);
		
		echo $this->twig->render('home/list.twig', [
			'posts' => $posts,
			'max_page' => $max_page,
			'actual_page' => $actual_page,
			'categories_header' => $categories_header
				]);

	}	

	public function category()
	{
		$categories_header = $this->categoryManager->getAll();
		$category_id=htmlspecialchars($_GET['id']);
		$category = $this->categoryManager->getOne($category_id);
		$max_page=$this->postManager->totalPagesByCategory($category_id);
			
		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$max_page)
			{
				$actual_page =intval($_GET['page']);
			}
		else 
			{
				$actual_page = 1 ;
			}
		$posts=$this->postManager->getWithCategory($category_id,$actual_page);
		
		echo $this->twig->render('home/list.twig', [
			'posts' => $posts,
			'category' => $category,
			'max_page' => $max_page,
			'actual_page' => $actual_page,
			'categories_header' => $categories_header
				]);
	}	

	public function single()
	{
		$categories_header = $this->categoryManager->getAll();
		$post_id= $_GET['id'];
		if (isset($_POST['author_com']) AND isset($_POST['com']) AND !empty($_POST['author_com']) AND !empty($_POST['com']))
		{
			$comment= new Comment ([
			'post_id'=> $post_id,
			'author'=> htmlspecialchars($_POST['author_com']),
			'content'=>htmlspecialchars($_POST['com']),
				]);
			$this->commentManager->add($comment);
		}

		$post=$this->postManager->getOne($post_id);
		$max_page=$this->commentManager->totalPages($post_id);

		if ((isset($_GET['page'])) AND !empty($_GET['page']) AND ($_GET['page'])>0 AND ($_GET['page'])<=$max_page)
		{
			$actual_page =intval($_GET['page']);
		}
		else 
		{
			$actual_page = 1 ;
		}
		$comments = $this->commentManager->get($post_id,$actual_page);
		
		echo $this->twig->render('home/single.twig', [
			'post' => $post,
			'comments' => $comments,
			'max_page' => $max_page,
			'actual_page' => $actual_page,
			'categories_header' => $categories_header
		]);
	}	


	public function signIn()
	{
		$categories_header = $this->categoryManager->getAll();
		$incorrect=false;

		if (!empty($_POST['email']) AND !empty($_POST['password']))
		{
			$logged = $this->userManager->login($_POST['email'], $_POST['password']);
			if($logged)
			{			
				header('Location:index.php?p=user.home');
			}
			else
			{
				$incorrect=true;
				echo $this->twig->render('home/sign_in.twig', [
						'incorrect' => $incorrect,
						'categories_header' => $categories_header
							]);
			}
		}
		if ( isset($_POST['emailCreate']) AND !empty($_POST['emailCreate']) AND
			isset($_POST['nameCreate']) AND !empty($_POST['nameCreate']) AND
			isset($_POST['passwordCreate']) AND !empty($_POST['passwordCreate']) AND
			isset($_POST['passwordConfirm']) AND !empty($_POST['passwordConfirm']) AND
			isset($_POST['descriptionCreate']) AND !empty($_POST['descriptionCreate']))
		{
			if (($_POST['passwordCreate'])===($_POST['passwordConfirm']))
			{
				if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['emailCreate']))
				{
					$user = new User([
					'email'=> htmlspecialchars($_POST['emailCreate']),
					'password'=> htmlspecialchars($_POST['passwordConfirm']),
					'name'=> htmlspecialchars($_POST['nameCreate']),
					'description'=> htmlspecialchars($_POST['descriptionCreate'])
					]);
					$this->userManager->add($user);
					$message = 'enregistrement reussi';
					
					echo $this->twig->render('home/sign_in.twig', [
						'message' => $message,
						'incorrect' => $incorrect,
						'categories_header' => $categories_header
							]);
				}
				else
				{
					$incorrect=true;					
					echo $this->twig->render('home/sign_in.twig', [
						'incorrect' => $incorrect,
						'categories_header' => $categories_header
							]);
				}
			}
			else
			{
				$incorrect=true;
				echo $this->twig->render('home/sign_in.twig', [
					'incorrect' => $incorrect,
						'categories_header' => $categories_header
						]);
			}
		}
		else 
		{
			// BUG :: IL ME LE CHARGE LORSQUE LES ID SONT INCORRECT
			echo $this->twig->render('home/sign_in.twig', [
						'categories_header' => $categories_header
					]);
		}
	}
}

