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


		

			
		</div>

		<?php include("part/footer.php");?>
	</body>
</html>



