<?php
use Project5\Comment;
use Project5\Post;
use Project5\User;
use Project5\Category;



if($page==='user.home')
{
    if($user_manager->logged())
    {
        if(isset($_POST['id_delete']) )
        {
            $post_manager->delete($_POST['id_delete']);
        }
        $connect_id = $user_manager->getUserId();
        $posts = $post_manager->getWithUserId($connect_id);
        require('view/user/home.php');
    }
    else
    {
        $incorrect=true;
        require('view/home/sign_in.php');
    }
}


elseif($page==='user.edit')
{
    $user = $user_manager->getOne($user_manager->getUserId());
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
                    $user_manager->edit($user);
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
        $user_manager->edit($user);
        header('Location:index.php?p=user.home');
    }

}


elseif($page==='user.post.edit')
{
    $post = $post_manager->getOne($_GET['id']);
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
                    $post_manager->edit($post);
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
                $comment_manager->valid(($_GET['valid']));
                break ;
                case !empty($_GET['delete']) : 
                $comment_manager->delete(($_GET['delete']));
                break ;
            }
        }
        $comments = $comment_manager->getNotYetValid($_GET['id']);
        $categories = $category_manager->getAll();
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
        $post_manager->edit($post);
        header('Location:index.php?p=user.home');
    }
}



elseif($page==='user.post.add')
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
                        'user_id'=> $user_manager->getUserId(),
                        'category_id'=>($_POST['category']),
                        'chapo'=>htmlspecialchars($_POST['chapo']),
                        'content'=>htmlspecialchars($_POST['content'])
                    ]); 

                    /*$post= new Post(); // Sans hydratation : 
                    $post->setTitle(htmlspecialchars($_POST['title'])); 
                    $post->setCategory_id($category_id);
                    $post->setChapo(htmlspecialchars($_POST['chapo'])); 
                    $post->setContent(htmlspecialchars($_POST['content']));*/

                    $post_manager->add($post);
                    $new_id = $post_manager->getLastInsertId();
 
                    move_uploaded_file($_FILES['picture']['tmp_name'], 'assets/media/photo/POST_IMG_' . $new_id .'.'.$extension_upload);// Oui
                    $picture_name = 'POST_IMG_' . $new_id .'.'.$extension_upload ;
                    $post->setPicture($picture_name);
                    $post->setId($new_id);
                    $post_manager->edit($post);// Non !!
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
        $categories = $category_manager->getAll();
        require('view/user/post/add.php');
    }
}
