<?php

$title = 'Liste des posts';

ob_start(); ?>
<p> la page listant l’ensemble des blog posts (du plus récent au plus ancien) ;
le titre ; la date de dernière modification ; le châpo ; et un lien vers le blog post. </p>

<?php 

// RECUPERATION DE LA VARIABLE $posts
// $posts est sous forme de tableau : attention on peut également les sortir sous forme d'objets il faudra adapter en consequence

foreach ($posts as $post)
{
	?>
		<div>
			<?php 
				$pathPicture = 'assets/media/photo/' . $post->getPicture() . '.jpg' ;
				$id_user=$post->getId_user();
			?>

			<h2> <?= $post->getTitle(); ?> </h2> 
			écrit le <?= $post->getCreate_date(); ?> par 
			<?= $user_manager->getAuthorName($id_user) ; ?>  et modifié le <?= $post->getLast_update(); ?> 
			<p> <?= $post->getChapo(); ?> </p>
			
			<p> <img src="<?= $pathPicture; ?>" alt=""> </p> <br/>
			<a href="index.php?post=<?= $post->getId(); ?>">Lien vers l'article' </a> 
		</div> <br/><br/>
	<?php
} 

?>
	<div>

<br/><br/><br/><br/>
<?php 
	for ($i=1; $i<=$q_total; $i++)
	{
		if($i==$actual_page)
		{
			echo ' PAGE ' .$i. '';
		}
		else
		{
			if(isset($_GET['list_all']))
			{
				echo '<a href="index.php?list_all&page=' .$i. '"> Page '.$i.'</a>';
			}
			else
			{
				echo '<a href="index.php?list=' . $_GET['list'] . '&page=' .$i. '"> Page '.$i.'</a>';
			}
		
		}
	}
?>

<?php $content=ob_get_clean(); 

require('basic_template.php');