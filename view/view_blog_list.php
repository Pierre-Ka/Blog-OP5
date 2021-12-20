<?php

$title = 'Liste des blogs';

ob_start(); ?>
<p> la page listant l’ensemble des blog posts (du plus récent au plus ancien) ;
						le titre ; la date de dernière modification ; le châpo ; et un lien vers le blog post. </p>
<?php $content=ob_get_clean(); 
require('view_basic_template.php');