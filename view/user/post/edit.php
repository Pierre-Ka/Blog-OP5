<?php

$title = 'Editer un article';

ob_start(); ?>
<div class="container-fluid text-center">

	<h2>Edition de l'article : <?= $post->getTitle(); ?> </h2>
	<br/><br/>

	<div>
		<form method="post"  class="form-control">

		<label for="title"> Changer le titre de l'article </label><br/>
		<input type="text" name="titleChange" id="title" value="<?= $post->getTitle(); ?>"/><br/><br/>
		<label for="Category"> Changer la categorie de l'article </label><br/>
		<select name="categorieChange" id="categorie"> 
		<?php foreach ($categories as $categorie): ?>

			<option value="<?php $categorie->getName()?>;"/><?php $categorie->getName()?></option>

		<?php endforeach ; ?>
		</select><br/><br/>

		<label for="chapo"> Changer le Resumé de l'article </label><br/>
		<input type="text" name="chapoChange" id="chapo" value="<?= $post->getChapo(); ?>"/><br/><br/>
		<label for="content"> Changer le Contenu de l'article </label><br/>
		<textarea name="contentChange" id="content" cols="100" rows="30"><?= $post->getContent(); ?></textarea><br/><br/>
		<input type="submit" value="Sauvegarder"/>
		</form>

		<p> <img src="<?= 'assets/media/photo/' . $post->getPicture() . '.jpg' ; ?>" alt=""> </p>
		<form method="post"  class="form-control" enctype="multipart/form-data">
		<label> Changer la photo de l'article : <br />
		<input type="file" name="pictureChange" /><br /> </label><br/>
		<input class="btn btn-primary" type="submit"/><br/><br/>
		</form>
	<div>

	<div>
	<h2>Validation des commentaires</h2>
	<br/><br/>
	<?php foreach ($comments as $comment) : ?>
		<div>
			<div>
				<?= $comment->getAuthor(); ?> a écrit à
				<?= $comment->getCreate_date(); ?>
			</div><br/>
			<p><?= $comment->getContent(); ?></p> <br/>
			<a href="index.php?p=user.post.edit&id=<?= $post->getId() ?>&valid=<?= $comment->getId() ?>">Valider le commentaire</a>
			<a href="index.php?p=user.post.edit&id=<?= $post->getId() ?>&delete=<?= $comment->getId() ?>">Supprimer le commentaire</a>
		</div>
	<?php endforeach; ?>
	</div>

</div>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');