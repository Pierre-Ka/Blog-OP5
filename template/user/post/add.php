<?php

$title = 'Ajouter un article';

ob_start(); 
?>
<div class="container-fluid text-center">

	<h2>Creer un nouvel article</h2>
	<br/><br/>

	<div>
		<form method="post"  class="form-control" enctype="multipart/form-data">

		<label for="title"> Titre de l'article </label><br/>
		<input type="text" name="title" id="title"/><br/><br/>
		<label for="category"> Choisissez la categorie de l'article </label><br/>
		
		<select name="category" id="categorie"> 
		<?php foreach ($categories as $categorie): ?>

			<option value="<?= $categorie->getId()?>;"/><?= $categorie->getName()?></option>

		<?php endforeach ; ?>
		</select><br/><br/>

		<label for="chapo"> Resumé de l'article </label><br/>
		<input type="text" name="chapo" id="chapo"/><br/><br/>
		<label for="content"> Contenu de l'article </label><br/>
		<textarea name="content" id="content" cols="100" rows="30"></textarea><br/><br/>
				
			<label> Choisir la photo de l'article : <br />
			<input type="file" name="picture" /><br /> </label><br/>
		<input class="btn btn-primary" type="submit"/><br/><br/>
	</form>
<div>
<?php $content=ob_get_clean(); 
require('../template/basic/basic_template.php');
