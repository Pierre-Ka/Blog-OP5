<?php

var_dump($categories);
foreach ($categories as $categorie)
{
	var_dump($categorie);
}

/*
$title = 'Ajouter un article';

ob_start(); ?>

<form method="post" enctype="multipart/form-data">

<label for="title"> Titre de l'article </label><br/>
<input type="text" name="title" id="title"/><br/><br/>
<label for="Category"> Categorie de l'article </label><br/>
<select name="categorie" id="categorie"> 
<?php foreach ($categories as $categorie): ?>

	<option value="<?php $categorie->getName()?>;"/><?php $categorie->getName()?></option>

<?php endforeach ; ?>
</select><br/><br/>

<label for="chapo"> Resumé de l'article </label><br/>
<input type="text" name="chapo" id="chapo"/><br/><br/>
<label for="content"> Contenu de l'article </label><br/>
<textarea name="content" id="content"></textarea><br/><br/>
<label> Choisissez une photo pour l'article : <br />
<input type="file" name="picture" /><br />
    </label><br/>
<input class="btn btn-primary" type="submit"/>
</form>


<br/><br/>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');
*/?>