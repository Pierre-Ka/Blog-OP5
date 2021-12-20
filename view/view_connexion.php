<?php

$title = 'Menu du blog';

ob_start(); ?>
<p> votre nom et votre prénom ; une photo et/ou un logo ;
            			un menu permettant de naviguer parmi l’ensemble des pages de votre site web ;
						un formulaire de contact (à la soumission de ce formulaire, un e-mail avec toutes ces informations vous sera envoyé) avec les champs suivants :
						nom/prénom, e-mail de contact, message, un lien vers votre CV au format PDF ;
						et l’ensemble des liens vers les réseaux sociaux où l’on peut vous suivre (GitHub, LinkedIn, Twitter…).</p>
<?php $content=ob_get_clean(); 
require('view_basic_template.php');