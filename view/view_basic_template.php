
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title> <?= $title ?> </title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" media="screen and (min-width: 992px)" href="css/newstyle.css" />
		<script src="js/jquery.js"></script>
    	<script src="js/bootstrap.min.js"></script>
    </head>
<body>

<header class=" border container-primary">	<p>Voici le header</p>
</header>
	<div> <?= $content ?>
	</div>

<footer>	<p>Voici le footer</p>
	<br/>
	<a class="light" href="connexion.php">Connexion</a>
</footer>

</body>
</html>

