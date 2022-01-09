<?php

$title = 'Editer mon profil';

ob_start(); ?>

<br/><br/>

<form method="post" enctype="multipart/form-data">

<label for="nameUpdate"> Changer mon nom : <input type="text" name="nameUpdate" id="nameUpdate"/></label><br/><br/>


<label for="passwordUpdate"> Changer mon mot de passe : <input type="password" name="passwordUpdate" id="passwordUpdate"/></label><br/><br/>

<label for="passwordUpdateConfirm"> Confirmer mon mot de passe : <input type="password" name="passwordUpdateConfirm" id="passwordUpdateConfirm"/></label><br/><br/>

<label for="descriptionUpdate"> Changer la descriptino à votre sujet :  <br/><br/>
<textarea name="descriptionUpdate"  id="descriptionUpdate" value="votre description ici" rows="5" cols="20"></textarea> <br/><br/>

<label> Changer votre photo de profil : <br/>
    <input type="file" name="pictureUpdate" /></label><br/> <br/>

<br/><br/>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');