<?php

$title = 'Liste des posts';

ob_start(); ?>
<p> la page listant l’ensemble des blog posts (du plus récent au plus ancien) ;
le titre ; la date de dernière modification ; le châpo ; et un lien vers le blog post. </p>

<?php // RECUPERATION DE LA VARIABLE $posts
// $posts est sous forme de tableau : attention on peut également les sortir sous forme d'objets il faudra adapter en consequence
// La variable envoyé contient aucune indication ou contient le type (type1, type2, type3)
// L'author se recupère par l'id_user =>name 
while ($post = $q_post->fetch())
{
	?>
	<div><h2>
	<?= $post['title']; ?> écrit le <?= $post['create_date_format']; ?> et modifié le <?= $post['last_update_format']; ?> last_update_formatpar <?= $post['author']; ?> </h2>
	<p> <?= $post['chapo']; ?> </p>
	<p> <?= $post['picture']; ?> </p> <br/>
	<a href="index.php?<?= $post['id'];?>/post/page=1/">Lien vers l'article' </a> </div> <br/> <?php
} ?>
<div>
//Ici le systeme de lien !
<?php 
	for ($i=1; $i<=$total_pages; $i++)
	{
		if($i==$actual_page)
		{
			echo ' PAGE ' .$i. '';
		}
		else
		{
		// ICI IL FAUT RECUPERER LA VRAIE ADRESSE donc il faut faire un switch (type1, type2, type3 et default : liste de tous les posts)
			echo '<a href="index.php?page=' .$i. '"> Page '.$i.'</a>';
		}
	}
?>

<?php $content=ob_get_clean(); 

require('basic_template.php');