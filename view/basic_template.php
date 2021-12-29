
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


<header>

<div class="container-fluid bg-dark" id="headertop">
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-expand-lg ">

				<div class="col-6 navbar-brand" id="logo">
					<img src="logo.jpg" class="w-75"alt="logo"/>
				</div>

				<button class=" navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#menu">
					<span class="navbar-toggler-icon">
						<img src="icons/grid-3x3-gap-fill.svg" alt="" width="32" height="32"/>
					</span>
				</button>

				<div id="menu" class="collapse navbar-collapse" >
					<ul id="menuborder" class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="index.php">Accueil</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link" href="index.php?list_all">Articles</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link" href="index.php?list=type1">Type1 ( ex: Astronomie</a>
						</li>
						<li class="nav-item" id="nav-item4">
							<a class="nav-link" href="index.php?list=type2">Type2 ( ex: Jardinage</a>
						</li>
						<li class="nav-item" id="nav-item4">
							<a class="nav-link" href="index.php?list=type3">Type3 ( ex: Cuisine</a>
						</li>
					</ul>
				</div>


			 </nav>
		</div>
	</div> <!-- FERMETURE DU CONTAINER NAV !-->
</div>
</header>


<div> 
	<?= $content ?>
</div>


<footer class="footer bg-dark">
	<div class="container">
		<div class="row blocfooter">

			<div class="col-12 col-sm-6 col-lg-4 col-xl-2" id="apropos">
				<h6 class="h6"> A PROPOS </h6>
				<ul>
					<li><a href="">Mentions Légales</a>
					</li>
					<li><a href="">Cookies</a>
					</li>
					<li><a href="">Reglementation RGPD</a>
					</li>
				</ul>
			</div>

			<div class="col-12 col-sm-6 col-lg-4 col-xl-2" id="administration">
				<h6 class="h6"> Espace administration </h6>
				<ul>
					<li><a href="">Connexion</a>
					</li>
					<li><a href="">Creer un compte</a>
					</li>
					<li><a href="">Liens externes</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

</body>
</html>

