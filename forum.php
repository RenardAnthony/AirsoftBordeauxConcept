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
		<link rel="stylesheet" href="css/forum.css"/>
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

			<div id="part-1">
				<article>
					<table>
						<thead>
							<tr>
								<td></td>
								<td></td>
								<td class="cadre-center"><p>Sujets</p></td>
								<td class="cadre-center"><p>Messages</p></td>
								<td class="cadre-center"><p>Dernier messages</p></td>
							</tr>
						</thead>
						<tbody>
							<tr class="categorie">
								<td colspan="5"><p>Categorie</p></td>
							</tr>
							<tr class="canclick">
								<td class="cadre-img"><img src="../img/theme/profil_default.png" alt=""></td>
								<td>
									<div class="titre-desc">
										<p class="titre">Information</p>
										<p class="desc">Hop, les news informations pour les joueurs c'est ici ;)</p>
									</div>
								</td>
								<td class="cadre-center"><p>8</p></td>
								<td class="cadre-center"><p>256</p></td>
								<td><div class="titre-desc no-marg date-autor"><p>13 fev 2023 - 23:13</p><p style="color: aquamarine;">MrFoxit</p></div></td>
							</tr>
							<tr class="canclick">
								<td class="cadre-img"><img src="../img/theme/profil_default.png" alt=""></td>
								<td>
									<div class="titre-desc">
										<p class="titre">Le bon coin</p>
										<p class="desc">Vien vendre t'on ancine matos !</p>
									</div>
								</td>
								<td class="cadre-center"><p>2</p></td>
								<td class="cadre-center"><p>9</p></td>
								<td><div class="titre-desc no-marg date-autor"><p>10 fev 2023 - 16:48</p><p style="color: aquamarine;">Walilou</p></div></td>
							</tr>
							<tr class="canclick">
								<td class="cadre-img"><img src="../img/theme/profil_default.png" alt=""></td>
								<td>
									<div class="titre-desc">
										<p class="titre">Inscription ABC</p>
										<p class="desc">C'est ici pour vneir s'inscrire au partie ABC.</p>
									</div>
								</td>
								<td class="cadre-center"><p>21</p></td>
								<td class="cadre-center"><p>2318</p></td>
								<td><div class="titre-desc no-marg date-autor"><p>23 jan 2023 - 9:31</p><p style="color: yellow;">LeFifou</p></div></td>
							</tr>
							<tr class="categorie">
								<td colspan="5"><p>Categorie</p></td>
							</tr>
							<tr class="canclick">
								<td class="cadre-img"><img src="../img/theme/profil_default.png" alt=""></td>
								<td>
									<div class="titre-desc">
										<p class="titre">Voici le forum</p>
										<p class="desc">Vien dire ce que tu en pense !</p>
									</div>
								</td>
								<td class="cadre-center"><p>1</p></td>
								<td class="cadre-center"><p>184</p></td>
								<td><div class="titre-desc no-marg date-autor"><p>24 dec 2024 - 23:57</p><p style="color: burlywood;">Alainhog-bar</p></div></td>
							</tr>
						</tbody>
					</table>
				</article>
			</div>
		

			
		</div>

		<?php include("part/footer.php");?>
	</body>
</html>



