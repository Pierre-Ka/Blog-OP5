<?php

$title = 'Blog particulier';

ob_start(); ?>
<p> la page affichant un blog post ;
						le titre ; le chapô ; le contenu ; l’auteur ; la date de dernière mise à jour ; le formulaire permettant d’ajouter un commentaire (soumis pour validation) ; les listes des commentaires validés et publiés.</p>
<?php $content=ob_get_clean(); 
require('view_basic_template.php');