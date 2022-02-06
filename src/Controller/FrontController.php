<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\User;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class FrontController extends AbstractController
{
	public $last5Posts ; 

	public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
	{
		parent::__construct($postManager, $userManager, $categoryManager, $commentManager);
		$this->last5Posts = $this->postManager->getAll(1);
	}

	public function home()
	{
		$message = $this->requestPost['message'] ?? null;
        $messageEmail = $this->requestPost['message-email'] ?? null;

		if ($message && $messageEmail)  
		{
            $entete  = 'MIME-Version: 1.0' . "\r\n";
            $entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $entete .= 'From: webmaster@monsite.fr' . "\r\n";
            $entete .= 'Reply-to: ' . $messageEmail;

            $theMessage = '<h1>Message envoyé depuis la page Contact de monsite.fr</h1>
            <p><b>Email : </b>' . $messageEmail . '<br>
            <b>Message : </b>' . htmlspecialchars($message) . '</p>';

            $retour = mail('ikanhiu@outlook.fr', 'Envoi depuis page Contact', $theMessage, $entete);
        }

		return $this->twig->render('home/home.html.twig', [
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);				
	}

	public function list()
	{
		$page = $this->requestGet['page'] ?? null ;

		$maxPage=$this->postManager->totalPages();
		$actualPage = $page ?? 1;
        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }
		$posts=$this->postManager->getAll($actualPage);
		
		return $this->twig->render('home/list.html.twig', [
			'posts' => $posts,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);
	}	

	public function listByCategory()
	{
		$page = $this->requestGet['page'] ?? null ;
		$categoryId = $this->requestGet['id'];

		$category = $this->categoryManager->getOne($categoryId);
		$maxPage=$this->postManager->totalPagesByCategory($categoryId);
			
		$actualPage = $page ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }

		$posts=$this->postManager->getWithCategory($categoryId,$actualPage);
		
		return $this->twig->render('home/list.html.twig', [
			'posts' => $posts,
			'category' => $category,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);
	}	

	public function single()
	{
		$authorCom = $this->requestPost['author_com'] ?? null;
        $contentCom = $this->requestPost['com'] ?? null;
        $page = $this->requestGet['page'] ?? null ;
		$postId= $this->requestGet['id'];

		if ($authorCom && $contentCom)
		{
			$comment= new Comment ([
			'post_id'=> $postId,
			'author'=> htmlspecialchars($authorCom ),
			'content'=>htmlspecialchars($contentCom),
				]);
			$this->commentManager->add($comment);
		}

		$post=$this->postManager->getOne($postId);
		$authorId = $post->getUser_id();
		$author = $this->userManager->getOne($authorId);

		$maxPage=$this->commentManager->totalPages($postId);

		$actualPage = $page ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }
        
		$comments = $this->commentManager->get($postId, $actualPage);
		
		return $this->twig->render('home/single.html.twig', [
			'post' => $post,
			'author' => $author,
			'comments' => $comments,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
		]);
	}	

	public function signIn()
	{
		if (!$_POST)
		{
			return $this->twig->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoriesHeader
					]);
		}
		else
		{
			$email = $this->requestPost['email'] ?? null;
	        $password = $this->requestPost['password'] ?? null;
			$incorrect=false;

			if ($email && $password)
			{
				$logged = $this->userManager->login($email, $password);
				if(!$logged)
				{			
					$incorrect=true;
					return $this->twig->render('home/sign_in.html.twig', [
					'categories_header' => $this->categoriesHeader,
					'incorrect' => $incorrect
						]);
				}
				else
				{
					header('Location: user.home'); 
				}	
			}
		}
	}

	public function signUp()
	{
		if (!$_POST)
		{
			return $this->twig->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoriesHeader
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
					
				return $this->twig->render('home/sign_in.html.twig', [
					'message' => 'enregistrement reussi',
					'incorrect' => false,
					'categories_header' => $this->categoriesHeader
						]);
			}

			else
			{
				return $this->twig->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoriesHeader,
				'incorrect' => true
					]);
			}
		}
	}
}
