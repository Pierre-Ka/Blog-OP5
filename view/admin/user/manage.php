<?php

$title = 'Menu du blog';

ob_start(); ?>


<?php $content=ob_get_clean(); 
require('basic_template.php');