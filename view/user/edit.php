<?php

$title = 'Editer mon profil';

ob_start(); 
?>
<div class="text-center">
	<form method="post" class="form-control">

		<label for="nameUpdate"> Changer mon nom </label><br/>
		<input type="text" name="nameUpdate" id="nameUpdate" value="<?= $user->getName(); ?>"/><br/><br/>

		<label for="passwordUpdate"> Changer mon mot de passe</label><br/>
		<input type="password" name="passwordUpdate" id="passwordUpdate"/><br/><br/>
		<label for="passwordConfirm"> Confirmer mon mot de passe</label><br/>
		<input type="password" name="passwordConfirm" id="passwordConfirm"/><br/><br/>

		<label for="descriptionUpdate"> Changer la description à votre sujet </label><br/>
		<input type="text" name="descriptionUpdate" id="descriptionUpdate" value="<?= $user->getDescription(); ?>"/><br/><br/>
		<input type="submit" value="Sauvegarder les modifications"/>
	</form>

	<p> <img src="<?= 'assets/media/photo/' . $user->getPicture() . '' ; ?>" alt="sans ext"> </p>
		
		<form method="post" action="index.php?p=user.edit&id=<?= $user->getId() ?>" class="form-control" enctype="multipart/form-data">
			<label> Changer ma photo de profil : <br />
			<input type="file" name="pictureUpdate" /><br /> </label><br/>
			<input class="btn btn-primary" type="submit"/><br/><br/>
		</form>
</div>

<br/><br/>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');



