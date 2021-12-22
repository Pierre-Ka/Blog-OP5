
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title> <?= $title ?> </title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
<?php	//	<link rel="stylesheet" media="screen and (min-width: 992px)" href="css/style.css" /> ?>
		<script src="js/jquery.js"></script>
    	<script src="js/bootstrap.min.js"></script>
    </head>
<body>

<div class="l-100 h-50 light bg-dark">	
	<p>Voici le header</p>
</div>
	<div> <?= $content ?>
	</div>

<div class="l-100 h-50 light bg-dark">	
	<p>Voici le footer</p>
</div>

</body>
</html>

