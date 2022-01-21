<?php

$title = 'Post numero' . $_GET['id'] ;

ob_start(); ?>
<h1> <?= $post->getTitle(); ?></h1> 

<div> 

	 <h4>
     écrit par <?= $userManager->getAuthorName($post->getUser_id()); ?> le <?= $post->getCreate_date(); ?>  

     	<?php 
		if (($post->getLast_update())===null)
		{
			echo 'et crée le ' .$post->getCreate_date();
		}
		else 
		{
			echo 'et modifié le ' .$post->getLast_update();
		}
		?> 
 	</h4><br/><br/><br/>

	  <p> 
		<?php 
		$pathPicture = 'assets/media/photo/' . $post->getPicture() . '.jpg' ;
		?>
		<p> <img src="<?= $pathPicture; ?>" alt=""> </p> <br/>
		<p> <img src="<?= 'assets/media/photo/' . $post->getPicture(); ?>" alt=""> </p> <br/>
		<?= $post->getContent(); ?>
	  </p> <br/>
</div>

<br/><br/>

<h2>Commentaires :</h2><br/>

<?php
// Commentaire en POO
	foreach ($comments as $comment) 
	{
		?>
			<div><div>
				<?= $comment->getAuthor(); ?> a écrit à
				<?= $comment->getCreate_date(); ?>
					</div><br/>
					<p><?= $comment->getContent(); ?></p>
					<br/>
			</div>
		<?php ;
	}

//Ici le systeme de lien !
echo 'PAGE : ';
for ( $i=1; $i<=$q_total; $i++)
{
	if($i==$actual_page)
	{
		echo ' - '.$i. '';
	}
	else
	{
		echo ' - <a href="index.php?p=single&amp;id=' .$post->getId(). '&amp;page=' .$i. '">'.$i.'</a>';
	}
}
?>

<h3>Ecrire un commentaire</h3>


<form method="post" action="index.php?p=single&id=<?= htmlspecialchars($_GET['id']);?>">

<p><label for="author_com">Votre pseudo : </label> <input type="text" name="author_com" id="author_com"/></p>

<p><textarea name="com" value="votre commentaire ici" rows="5" cols="50"></textarea></p>

<input type="submit" value="Envoyer"/>
</form>

<?php $content=ob_get_clean();

require('view/template/basic_template.php');