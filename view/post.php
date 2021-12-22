<?php

$title = 'Post numero ';

ob_start(); ?>
<p> la page affichant un post du blog avec tous ces commentaires (du plus récent au plus ancien) ;</p>

<p>Lien de retour aux differentes listes à créer </p>

<?php 
// ICI LE $post est sorti sous forme d'objet : A ADAPTER !!!!
	$the_post = $post->fetch();

?> <div> <h3> <?= $the_post['type']; ?></h3><h2> <?= $the_post['title']; ?>
écrit par <?= $the_post['author']; ?> le <?= $the_post['create_date_format']; ?> et modifié le <?= $the_post['last_update_format']; ?> </h2> <br/>
<p> <?= $the_post['content']; ?>
	<?= $the_post['picture']; ?>
</p><br/></div>

<br/><br/>

<h2>Commentaires :</h2><br/>
<?php
// RECUPERATION DE LA VARIABLE $coms
// if IS_VALID = 1 !!!
// $coms est sous forme de tableau : attention on peut également les sortir sous forme d'objets il faudra adapter en consequence
	while ($comm = $q_comm->fetch())
{
	echo '<div>
			<div>' .$comm['author']. 'a écrit à' .$comm['create_date_format'].'
			</div><br/>
			<p>' .$comm['content'].'<br/>
			</div>';
}
//Ici le systeme de lien !
echo 'PAGE : ';
for ( $i=1; $i<=$total_pages; $i++)
{
	if($i==$actual_page)
	{
		echo ' - '.$i. '';
	}
	else
	{
		echo ' - <a href=""index.php?<?= $post['id'];?>/post/page='.$i.'">'.$i.'</a>';
	}
}
?>

<h3>Ecrire un commentaire</h3>

<?php //ADAPTER L'URL !!! ?>

<form method="post" action="index.php">

<p><label for="author_comm">Votre pseudo : </label> <input type="text" name="author_comm" id="author_comm"/></p>

<p><textarea name="comm" value="votre commentaire ici" rows="5" cols="50"></textarea></p>

<input type="submit" value="Envoyer"/>
</form>


<?php $content=ob_get_clean();

require('basic_template.php');