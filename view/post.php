<?php

$title = 'Post numero' . $_GET['post'] ;

ob_start(); ?>
<p> la page affichant un post du blog avec tous ces commentaires (du plus récent au plus ancien) ;</p>

<div> 
	<h3> <?= $post->getType(); ?></h3><h2> <?= $post->getTitle(); ?></h2>  <h4>
     écrit par <?= $user_manager->getAuthorName($post->getId_user()); ?> le <?= $post->getCreate_date(); ?> et modifié le <?= $post->getLast_update(); ?> </h4>><br/>

	  <p> 
		<?php 
		$pathPicture = 'assets/media/photo/' . $post->getPicture() . '.jpg' ;
		var_dump($post->getPicture())
		?>

		<p> <img src="<?= $pathPicture; ?>" alt=""> </p> <br/>
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
		echo ' - <a href="index.php?post=' .$post->getId(). '&page=' .$i. '">'.$i.'</a>';
	}
}
?>

<h3>Ecrire un commentaire</h3>


<form method="post" action="index.php?post=<?= htmlspecialchars($_GET['post']);?>">

<p><label for="author_com">Votre pseudo : </label> <input type="text" name="author_com" id="author_com"/></p>

<p><textarea name="com" value="votre commentaire ici" rows="5" cols="50"></textarea></p>

<input type="submit" value="Envoyer"/>
</form>

<?php $content=ob_get_clean();

require('basic_template.php');