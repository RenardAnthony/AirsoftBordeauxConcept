<?php
require_once 'booter.php';

$auth = App::getAuth();
$db = App::getDatabase();
$auth->connectFromCookie($db);
$session = Session::getInstance();

?>

<!DOCTYPE html>
<html>
<head>
		<base href="/"/>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="css/general.css"/>
		<link rel="stylesheet" href="css/accueil.css"/>

		<link rel="shortcut icon" type="image/png" href="img/theme/favicon.png"/>
		<title>Airsoft Bordeaux Concept</title>
		<meta name="description" content="l'association Airsoft Bordeaux Concept (ABC). Ici on simule la guerre, toujours dans la bonne ambience."/>
		<meta name="author" content="Anthony Rodrigues"/>
		<meta property="og:title" content="Airsoft Bordeaux Concept"/>
		<meta property="og:type" content="website"/>
		<meta property="og:image" content="img/theme/favicon.png"/>
		<meta property="og:description" content="l'association Airsoft Bordeaux Concept (ABC). Ici on simule la guerre, toujours dans la bonne ambience."/>
		<meta property="og:url" content="http://www.abconcept=.fr"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<script src="https://kit.fontawesome.com/d5d0318cf5.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php include("part/header.php");?>

<div id="body-content">

	<div class="spacer-1"></div>

		<div id="window-principal">
			<div class="text-onimg">
				<p>Nouvelle partie à Reignac !</p>
				<button>S'inscrire</button>
			</div>
		</div>

	<div class="spacer-1"></div>

			<div class="long-card">
				<a href="">
					<p class="date">13 Avr. 2023</p>
					<img src="../img/theme/baniere.png" alt="">
					<div class="txt-part">
						<p class="titre">Un petit nouveau dans le staff !</p>
						<p class="author">par <em>Mr.Foxit</em></p>
					</div>
				</a>
			</div>

	<div class="spacer-1"></div>

			<div class="tripe-contenaire">
				<div class="long-card short">
					<a href="">
						<img src="https://www.ops-store.fr/guides/airsoft/images/airsoft038.jpg" alt="">
						<div class="txt-part">
							<p class="titre">Devenir membre</p>
						</div>
					</a>
				</div>
				<div class="long-card short">
					<a href="">
						<img style="background-color: white;" src="../img/theme/2.jpg" alt="">
						<div class="txt-part">
							<p class="titre">Partenaires</p>
						</div>
					</a>
				</div>
				<div class="long-card short">
					<a href="">
						<img style="background-color: white;" src="https://survivalhero.de/wp-content/uploads/2016/10/cqb.png" alt="">
						<div class="txt-part">
							<p class="titre">Les Techniques en Airsoft</p>
						</div>
					</a>
				</div>
			</div>

	<div class="spacer-1"></div>	

</div>

		<?php include("part/footer.php");?>
	</body>
</html>