<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Description de la page (environ 150-160 caractères)">
    <meta name="keywords" content="mots clés, séparés par des virgules, pertinents pour la page">
    <meta name="author" content="Votre nom ou le nom de votre association">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Cache-control" content="public">
    <title>Accueil | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/index.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <main>
        <!-- Futur jeu -->
        <div id="futur_game_box">
            <div id="in_box">
                <img src="../assets/images/theme/2.jpg" alt="Photo de la partie">
                <div id="desc">
                    <h1 id="date">25 Août 2023</h1>
                    <p id="desc-desc">Nouvelle partie à Cézac PA/Pompe 16 joueurs max, rejoignez-nous !</p>
                    <a href=""><p id="btn">S'inscrire</p></a>
                </div>
            </div>
        </div>

        <!-- Présentation de l'association -->
        <div id="presentation_box">
            <div id="presentation">
                <h1>AirSoft Bordeaux Concept</h1>
                <p>
                    Airsoft Bordeaux Concept, aussi appelé "ABC", est une association d'airsoft sur la région Bordelaise. 
                    Nous existons depuis plus de 13 ans, ce qui nous a permis de tester pas mal de choses. Aujourd'hui, nous nous spécialisons 
                    dans la "simulation militaire amateur". Bonne ambiance, fair-play et entraide sont nos maîtres mots. Ici, pas de compétition 
                    ou de jugement, on est là pour jouer, pour partager.
                </p>
                <div id="chiffre_box">
                    <div>
                        <h1 class="nbr">>1200</h1>
                        <h2 class="desc">Membres</h2>
                    </div>
                    <div>
                        <h1 class="nbr">2</h1>
                        <h2 class="desc">Parties jouées depuis début 2024</h2>
                    </div>
                    <div>
                        <h1 class="nbr">33Ha</h1>
                        <h2 class="desc">De terrains cumulés</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejoindre une partie -->
        <div id="decouvert_box">
            <div class="in">
                <h1>Nous rejoindre pour une partie ?</h1>
                <h2>Bien sûr que c'est possible !</h2>
                <h1>À partir de <span style="font-size: 2em;">10€</span>* seulement !</h1>
                <p>*Fonction des options choisies. Restauration sur place ou location matériel</p>
            </div>
        </div>

        <!-- Forum -->
        <div id="forum">
            <div id="sidebyside">
                <iframe src="https://discord.com/widget?id=1169269699092160522&theme=dark"
                    width="350"
                    height="500"
                    allowtransparency="true"
                    frameborder="0"
                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts">
                </iframe>
                <div id="descs">
                    <h1>Envie de nous découvrir autrement ?</h1>
                    <br>
                    <p>Venez sur notre forum ! On parle réplique, technique d'airsoft, on prépare les prochaines parties.</p>
                </div>
            </div>
        </div>
    </main>

    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>