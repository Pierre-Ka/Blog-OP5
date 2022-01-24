<?php

$title = $category->getName();

ob_start(); ?>
<div class="container-fluid text-center">
<h1> <?= $category->getName() ?></h1>
</div>
<?php 
foreach ($posts as $post)
{
	?>
		<div>
			<?php 
				$pathPicture = 'assets/media/photo/' . $post->getPicture() . '.jpg' ;
				$id_user=$post->getUser_id();
			?>
			<h2> <?= $post->getTitle(); ?> </h2> 
			<h2> <?= $post->getCategory(); ?> </h2>
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
			echo '<a href="index.php?p=category&id=' . $_GET['id'] . '&page=' .$i. '"> Page '.$i.'</a>';
		}
	}
?>

<?php $content=ob_get_clean(); 

require('view/template/basic_template.php');