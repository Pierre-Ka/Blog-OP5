<?php

$title = 'Menu du blog';

ob_start(); ?>

<h2>Edition d'articles </h2>
<br/><br/>

<form method="post">
	<input>
	<input>
</form>

<?php foreach $comments as $comment : ?>
	<div>
		<div>
			<?= $comment->getAuthor(); ?> a écrit à
			<?= $comment->getCreate_date(); ?>
		</div><br/>
		<p><?= $comment->getContent(); ?></p> <br/>
		<a href="index.php?p=post&id=<? $post->getId() ?>&action=valid">Valider le commentaire</a>
		<a href="index.php?p=post&id=<? $post->getId() ?>&action=delete">Supprimer le commentaire</a>
	</div>

<?php endforeach; ?>

<?php $content=ob_get_clean(); 
require('basic_template.php');