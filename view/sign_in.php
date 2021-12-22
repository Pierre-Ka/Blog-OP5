<?php

$title = 'Connexion';

ob_start(); ?>
<p> Vous n'êtes pas encore inscrit mais souhaitez néanmoins publier sur ce blog ?</p>
<a href="index.php?sign_up"> Inscrivez-vous ici </a><br/><br/><br/>
Connectez-vous à votre compte : 

<form action="index.php" method="post">

<label for="email"> Votre email : <input type="text" name="email" id="email"/></label><br/><br/>

<label for="password"> Votre mot de passe : <input type="password" name="passord" id="password"/></label><br/><br/>

<label for="cookie"> Connexion automatique : <input type="checkbox" name="cookie" id="cookie"/><br/><br/>

</form>

<?php $content=ob_get_clean(); 

require('basic_template.php');