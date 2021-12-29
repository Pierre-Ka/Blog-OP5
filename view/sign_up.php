<?php

$title = 'Creation de compte';

ob_start(); ?>

<p> Creer un compte pour pouvoir publier des articles sur ce blog </p>
<p> Une fois votre compte crée, vous devez attendre un message de confirmation de la part de l'administrateur du groupe avant de pouvoir publier sur ce blog </p>

<form action="index.php" method="post" enctype="multipart/form-data">

<label for="nameCreate"> Votre nom et prenom : <input type="text" name="nameCreate" id="nameCreate"/></label><br/><br/>

<label for="emailCreate"> Votre email : <input type="text" name="emailCreate" id="emailCreate"/></label><br/><br/>

<label for="passwordCreate"> Votre mot de passe : <input type="password" name="passwordCreate" id="passwordCreate"/></label><br/><br/>

<label for="passwordCreateConfirm"> Confirmer votre mot de passe : <input type="password" name="passwordCreateConfirm" id="passwordCreateConfirm"/></label><br/><br/>

<label for="descriptionCreate"> Ecrivez quelques lignes à votre sujet :  <br/><br/>
<textarea name="descriptionCreate"  id="descriptionCreate" value="votre description ici" rows="5" cols="20"></textarea> <br/><br/>

<label> Choisissez une photo de profil : <br/>
    <input type="file" name="pictureCreate" /></label><br/> <br/>

<label for="cookie"> Je choisit la connexion automatique : <input type="checkbox" name="cookie" id="cookie"/><br/><br/>

<input type="submit" value="Creer mon compte" /><br/><br/>
</form>

<?php $content=ob_get_clean(); 

require('basic_template.php');

