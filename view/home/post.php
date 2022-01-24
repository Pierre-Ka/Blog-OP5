<?php

$title = 'Liste des posts';

ob_start(); ?>
<h1 class="text-center container-fluid"> Tous les articles du blog </h1>

<?php 
foreach ($posts as $post)
{
	?>
		<div>
			<?php 
				$pathPicture = 'assets/media/photo/' . $post->getPicture() . '.jpg' ;
				$user_id=$post->getUser_id();

			?>

			<h2> <?= $post->getTitle(); ?> </h2> 
			<h2> <?= $post->getCategory() ?> </h2> 

			écrit le <?= $post->getCreate_date(); ?> par 
			<?= $post->getUser() ?>  et modifié le <?= $post->getLast_update(); ?> 
			<p> <?= $post->getChapo(); ?> </p>
			
			<p> <img src="<?= $pathPicture; ?>" alt=""> </p> <br/>
			<a href="index.php?p=single&id=<?= $post->getId(); ?>">Lien vers l'article' </a> 
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
			echo '<a href="index.php?p=post&page=' .$i. '"> Page '.$i.'</a>';
		}
	}
?>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');