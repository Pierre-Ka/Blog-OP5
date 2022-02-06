<?php
namespace BlogApp\Controller;

use BlogApp\Entity\Comment;
use BlogApp\Entity\User;
use BlogApp\Mailer\MyMailer;

use BlogApp\Manager\CommentManager;
use BlogApp\Manager\PostManager;
use BlogApp\Manager\UserManager;
use BlogApp\Manager\CategoryManager;

class FrontController extends AbstractController
{
	protected PostManager $postManager;
    protected UserManager $userManager;
    protected CategoryManager $categoryManager;
    protected CommentManager $commentManager;

	public function __construct(PostManager $postManager, UserManager $userManager, CategoryManager $categoryManager, CommentManager $commentManager)
	{
		parent::__construct();
		$this->postManager = $postManager;
        $this->userManager = $userManager;
        $this->categoryManager = $categoryManager;
        $this->commentManager = $commentManager;
	}

	public function mail()
	{
		$message = $this->requestPost['message'] ?? null;
        $messageEmail = $this->requestPost['message-email'] ?? null;

		if ($message && $messageEmail)  
		{
            $monmail = new MyMailer();
            $MessageFormat = $monmail->formatMail($messageEmail, $message);
            $return = $monmail->SendTheMail($MessageFormat); 
            echo $return ; 
            header('Location: home');  
        }

    }
	public function home()
	{
		return $this->render('home/home.html.twig', [
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
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
		
		return $this->render('home/list.html.twig', [
			'posts' => $posts,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
				]);
	}	

	public function listByCategory()
	{
		$page = $this->requestGet['page'] ?? null ;
		$categoryId = $this->requestGet['id'];

		$allCategory = $this->categoryManager->getAll();
		$categoryIdPossible = [];
		foreach ($allCategory as $oneCategory) 
		{
			$categoryIdPossible[] = $oneCategory->getId();
		}
		if ( !in_array($categoryId, $categoryIdPossible))
		{
			header('Location:index.php?p=home');
		}

		$category = $this->categoryManager->getOne($categoryId);
		$maxPage=$this->postManager->totalPagesByCategory($categoryId);
			
		$actualPage = $page ?? 1;

        if (0 > $actualPage || $maxPage < $actualPage) 
        {
            $actualPage = 1;
        }

		$posts=$this->postManager->getWithCategory($categoryId,$actualPage);
		
		return $this->render('home/list.html.twig', [
			'posts' => $posts,
			'category' => $category,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
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
		
		return $this->render('home/single.html.twig', [
			'post' => $post,
			'author' => $author,
			'comments' => $comments,
			'max_page' => $maxPage,
			'actual_page' => $actualPage,
			'categories_header' => $this->categoryManager->getAll(),
			'last5Posts' => $this->postManager->getAll(1)
		]);
	}	

	public function signIn()
	{
		if (!$_POST)
		{
			return $this->render('home/sign_in.html.twig', [
				'categories_header' => $this->categoryManager->getAll()
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
					return $this->render('home/sign_in.html.twig', [
					'categories_header' => $this->categoryManager->getAll(),
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

	public function addUser()
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
}
