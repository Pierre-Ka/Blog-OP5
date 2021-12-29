
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title> <?= $title ?> </title>
		<link rel="stylesheet" href="assets/css/style.css" />
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<?php	//	<link rel="stylesheet" media="screen and (min-width: 992px)" href="css/style.css" /> ?>
		<script src="assets/js/jquery.js"></script>
    	<script src="assets/js/bootstrap.min.js"></script>
    </head>
<body>

<div class="header l-10 h-500 bg-light primary">	
	<p>Voici le header</p>
</div>
	<div> <?= $content ?>
	</div>

<div class="l-100 height-100 light bg-dark">	
	<p>Voici le footer</p>
</div>

</body>
</html>

