<?php

$title = 'Menu du blog';

ob_start(); ?>

<br/><br/>
<p> votre nom et votre prénom ; une photo et/ou un logo ;
un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
nom/prénom, e-mail de contact, message, un lien vers votre CV au format PDF ;
et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).</p>

<br/><br/>

<p> GENERATE FAKE DATA IS A ADMIN PRIVILEGE </p>
<p> FIRST delete all the data exept the admin entry ( users table ) then click only one time on each link to generate fake data </p><br/>
<a href='index.php?faker_user'>Generate fake users</a>
<a href='index.php?faker_post'>Generate fake posts</a>
<a href='index.php?faker_com'>Generate fake coms</a>

<br/><br/>

<?php $content=ob_get_clean(); 
require('view/template/basic_template.php');