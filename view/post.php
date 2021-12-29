<?php

$title = 'Post numero' . $_GET['post'] ;

ob_start(); ?>
<p> la page affichant un post du blog avec tous ces commentaires (du plus récent au plus ancien) ;</p>

<a href='index.php?list_all'>Liste des posts</a><br/>
<?php //REQUETE PUIS BOUCLE ?? ?>
<a href='index.php?list=type1'>Liste des posts du type1</a><br/>
<a href='index.php?list=type2'>Liste des posts du type2</a><br/>
<a href='index.php?list=type3'>Liste des posts du type3</a><br/>

<?php 
// ICI LE $post est sorti sous forme d'objet : A ADAPTER !!!!
/*$the_post = $post->fetch();

?> <div> <h3> <?= $the_post['type']; ?></h3><h2> <?= $the_post['title']; ?>
écrit par <?= $the_post['author']; ?> le <?= $the_post['create_date_format']; ?> et modifié le <?= $the_post['last_update_format']; ?> </h2> <br/>
<p> <?= $the_post['content']; ?>
	<?= $the_post['picture']; ?>
</p><br/></div>

*/

?> <div> <h3> <?= $post->getType(); ?></h3><h2> <?= $post->getTitle(); ?>
écrit par <?= $user_manager->getAuthorName($post->getId()); ?> le <?= $post->getCreate_date(); ?> et modifié le <?= $post->getLast_update(); ?> </h2> <br/>
<p> <?= $post->getContent(); ?>
	<?= $post->getPicture(); ?>
</p><br/></div>

<br/><br/>

<h2>Commentaires :</h2><br/>
<?php
// RECUPERATION DE LA VARIABLE $coms
// if IS_VALID = 1 !!!
// $coms est sous forme de tableau : attention on peut également les sortir sous forme d'objets il faudra adapter en consequence
	while ($com = $q_comment->fetch())
{
	?>
	<div><div>
		<?= $com['author'] ?> a écrit à
		<?= $com['create_date_format'] ?>
			</div><br/>
			<p><?= $com['content'] ?></p>
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