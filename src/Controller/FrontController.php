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
		$message = $_POST['message'] ?? null;
        $messageEmail = $_POST['message-email'] ?? null;

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

		echo $this->twig->render('home/home.twig', [
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);				
	}

	public function post()
	{
		$maxPage=$this->postManager->totalPages();
		$actualPage = $_GET['page'] ?? 1;
        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }
		$posts=$this->postManager->getAll($actualPage);
		
		echo $this->twig->render('home/list.twig', [
			'posts' => $posts,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoriesHeader,
			'last5Posts' => $this->last5Posts
				]);
	}	

	public function category()
	{
		$categoryId=htmlspecialchars($_GET['id']);
		$category = $this->categoryManager->getOne($categoryId);
		$maxPage=$this->postManager->totalPagesByCategory($categoryId);
			
		$actualPage = $_GET['page'] ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }

		$posts=$this->postManager->getWithCategory($categoryId,$actualPage);
		
		echo $this->twig->render('home/list.twig', [
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
		$authorCom = $_POST['author_com'] ?? null;
        $contentCom = $_POST['com'] ?? null;

		$postId= $_GET['id'];
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

		$actualPage = $_GET['page'] ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }
        
		$comments = $this->commentManager->get($postId,$actualPage);
		
		echo $this->twig->render('home/single.twig', [
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
			echo $this->twig->render('home/sign_in.twig', [
				'categories_header' => $this->categoriesHeader
					]);
		}
		else
		{
			$email = $_POST['email'] ?? null;
	        $password = $_POST['password'] ?? null;
	        $emailCreate = $_POST['emailCreate'] ?? null;
	        $nameCreate = $_POST['nameCreate'] ?? null;
	        $passwordCreate = $_POST['passwordCreate'] ?? null;
	        $passwordConfirm = $_POST['passwordConfirm'] ?? null;
	        $descriptionCreate = $_POST['descriptionCreate'] ?? null;

			$incorrect=false;

			switch ($_POST)
			{
				case $email && $password : 
				$logged = $this->userManager->login($email, $password);
				if(!$logged)
				{			
					$incorrect=true;
					echo $this->twig->render('home/sign_in.twig', [
					'categories_header' => $this->categoriesHeader,
					'incorrect' => $incorrect
						]);
				}
				else
				{
					header('Location: user.home'); 
				}
				break ;

				case $emailCreate && $nameCreate && $passwordCreate && $passwordConfirm && $descriptionCreate && ($passwordCreate === $passwordConfirm) && (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $emailCreate)) : 

				$user = new User([
				'email'=> htmlspecialchars($emailCreate),
				'password'=> htmlspecialchars($passwordConfirm),
				'name'=> htmlspecialchars($nameCreate),
				'description'=> htmlspecialchars($descriptionCreate)
				]);
				$this->userManager->add($user);
				$message = 'enregistrement reussi';
					
				echo $this->twig->render('home/sign_in.twig', [
					'message' => $message,
					'incorrect' => $incorrect,
					'categories_header' => $this->categoriesHeader
						]);
				break ;

				default :
				$incorrect=true;
				echo $this->twig->render('home/sign_in.twig', [
				'categories_header' => $this->categoriesHeader,
				'incorrect' => $incorrect
					]);
				break ;
			}
		}
	}
}
