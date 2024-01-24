<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

$get_eventId = htmlspecialchars($_GET['id']);

$requser = $conn->prepare('SELECT * FROM agenda WHERE id = ?');
$requser->execute(array($get_eventId));
$evenent = $requser->fetch();

// Vérifie si la partie existe dans la base de données et si un ID est entrer
if(empty($evenent['id']) || empty($get_eventId)){
    header("Location: ../pages/index.php"); 
}

// Recuperer les joueur inscrit pour cette partie
$inscrits = getInscritsPartie($get_eventId);

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
    <title>Partie | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/partie.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <main>
        <div id="full-size-image">
            <h1><?=$evenent['titre']?></h1>
        </div>
        <div id="DateHeureLieu">
            <h1><?= date('d F Y', strtotime($evenent['date'])) ?></h1>
            <h2><?php echo date('H', strtotime($evenent['date'])) . "h" . date('i', strtotime($evenent['date'])) ?></h2>
            <h3><?=$evenent['terrain']?></h3>
        </div>

        <div class="separateur_1"></div>

        <div id="triple_carde">
            <?php  if($evenent['freelance'] == 1){ ?>
                <div class="card">
                    <h1>Freelance</h1>
                    <p>
                        Vous n'est pas <a href="#">membre de l'association</a> ? <br>
                        pas de problème, vous pouvez nous rejoindre sur cette partie !
                    </p>
                    <h2><?=$evenent['prix_paf']?>€</h2>
                </div>
            <?php } else { ?>
                <div class="card-off">
                    <h1>Freelance</h1>
                    <p>
                        Cette partie est reserver aux membres uniquement. <br><br>
                    </p>
                    <h2>-</h2>
                </div>
            <?php } ?>


            <?php  if($evenent['location'] == 1){ ?>
                <div class="card">
                    <h1>Location</h1>
                    <p>
                        Tu n'a pas t'on propre équipement ? <br>
                        pas de souci on peut t'équiper sur place avec notre <a href="#">pack de location</a>.
                    </p>
                    <h2><?=$evenent['prix_location']?>€</h2>
                </div>
                <?php } else { ?>
                    <div class="card-off">
                    <h1>Location</h1>
                    <p>
                        Malheuresement sur cette partie les pack <br>
                        de location ne sont pas disponible.<br>
                        Une prochaine fois peut-etre.
                    </p>
                    <h2>-</h2>
                </div>
                <?php } ?>


            <?php  if($evenent['bbq'] == 1){ ?>
                <div class="card">
                    <h1>Repas</h1>
                    <p>Prolonge ce moment avec nous ! <br> En fin de partie on organise  un barbecue, vien avec nous !</p>
                    <h2><?=$evenent['prix_bbq']?>€</h2>
                </div>
            <?php } else { ?>
                <div class="card-off">
                    <h1>Repas</h1>
                    <p>
                        Pas de repas pris en charge <br>
                        sur cette partie. <br>
                        Prevoyer le votre.
                    </p>
                    <h2>-</h2>
                </div>
            <?php } ?>
        </div>

        <div class="separateur_2"></div>

        <div id="map_terrain">
            <?php if($evenent['terrain'] == "Cézac"){ ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1778.912123924828!2d-0.46879715461419047!3d45.0874859935889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDXCsDA1JzE1LjAiTiAwwrAyOCcwMy4zIlc!5e1!3m2!1sfr!2sfr!4v1705770659617!5m2!1sfr!2sfr"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            <?php }
            if($evenent['terrain'] == "Reignac"){ ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d4219.995528104777!2d-0.562363637686661!3d45.23572616593423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDXCsDE0JzA1LjYiTiAwwrAzMyczMC45Ilc!5e1!3m2!1sfr!2sfr!4v1705770758188!5m2!1sfr!2sfr"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            <?php } ?>
        </div>
        <div id="info_adresse">
            <img src="../assets/images/theme/terre.png"/>
            <div>
                <h1><?=$evenent['terrain']?></h1>
                <h2><?=$evenent['adresse']?></h2>
                <?php if($evenent['terrain'] == "Cézac"){ ?>
                    <p> 45.087777, -0.467756 </p>
                <?php } if($evenent['terrain'] == "Reignac"){ ?>
                    <p>45.234896, -0.558670</p>
                <?php } ?>
            </div>
        </div>

        <div class="separateur_1"></div>

        <h1 class="titre_section">Rappel des régles</h1>
        <div id="votre_equipement">
            <div class="card hover_vert">
                <h1>Obligation</h1>
                <img src="../assets/images/theme/partie_obligation.png" alt="">
                <ul>
                    <li>Stalker</li>
                    <li>Lunette de protection homologuer</li>
                    <li>Billes BIO</li>
                    <li>Chaussures random/militaire</li>
                </ul>
            </div>
            <div class="card hover_rouge">
                <h1>Interdiction</h1>
                <img src="../assets/images/theme/partie_interdiction.png" alt="">
                <ul>
                    <li>HPA</li>
                    <li>Grnade/Fumigène</li>
                    <li>Pétards</li>
                </ul>
            </div>
        </div>
        <?php  if($evenent['location'] == 1){ ?>
        <p class="description_regles">
            *Les <a href="#">pack de location</a> vous garentise la bonne conformiter de ces régles. <br>
            Cependant les chaussur ne vous sont pas fournis. Pensser à vous équipé.
        </p>
        <?php } ?>

        <div class="separateur_2"></div>

        <h1 class="titre_sous_section">Rappel des régles</h1>
        <div class="limite_puissance">
            <img src="../assets/images/theme/partie_limite_puissance.png" alt="">
            <p>
                Chez ABC la priorité c’est la sécurité. <br>
                Tout réplique sont tester a la bille de <em>6mm, 0.20g hopup zero</em>.<br>
                Personne n’évite le control <em>même si vous jouer en 0.28g</em>.<br>
                <br>
                <em>La puissance maximal a ne pas dépasser est fixer à 350fps</em><br>
                <br>
                Par sécurité nous avons mise en place un systeme de frezz.<br>
                Quand votre cible est à <em>moins de 5m ne tiré pas</em>.<br>
                Viser le est crier simplement “FREEZ !” pour éviter de le blaisser<br>
                inutilement.<br>
                <br>
                Le non respect de l’une de ces deux règles entrainera votre ajournement.<br>
            </p>
        </div>

        <?php  if($evenent['location'] == 1){ ?>

            <h1 class="titre_sous_section">Pack de location</h1>

            <div class="location_pack">
                <div>
                    <p>Votre pack de location comprend :</p>

                    <br>

                    <ul>
                        <li>Combinaison militaire</li>
                        <li>Gilet tactique</li>
                        <li>Paire de lunette et stolker</li>
                        <li>Paire de gants</li>
                        <li>Réplique Colt M4 Special Force CQB</li>
                        <li>700 billes</li>
                    </ul>

                    <br>

                    <p>
                        <em>Les chaussures sont OBLIGATOIRE et personnel. <br>
                        Nous ne les fournison pas.</em>
                    </p>
                </div>
                <img src="../assets/images/theme/location.jpg" alt="">
            </div>
        <?php } ?>

        <div class="separateur_1"></div>

        <div class="player_liste">
            <h1>Liste des joueurs</h1>
            <h2><?= count($inscrits) ?>/<?= $evenent['joueur_max'] ?></h2>

            <div class="box">
                <?php foreach ($inscrits as $inscrit) {
                    
                    $requser = $conn->prepare('SELECT * FROM users WHERE id = ?');
                    $requser->execute(array($inscrit['user_id']));
                    $userinfo = $requser->fetch();

                    if($userinfo['username'] == $inscrit['pseudo']){
                        $isMyInscription = true;
                    } else {
                        $isMyInscription = false;
                    }
                     
                    ?>
                    
                    <a href="profil.php?id=<?=$userinfo['id']?>" <?php if($userinfo['role'] != "visiteur" && $isMyInscription == true){?> class="membre" <?php } ?>>
                        <?php
                        if($isMyInscription == true){?>
                            <img src="../assets/images/avatars/<?=$userinfo['avatar']?>" alt="">
                        <?php } else { ?>
                            <img src="../assets/images/theme/profil_default.png" alt="">
                        <?php } ?>

                        <p><?= $inscrit['pseudo'] ?></p>
                    </a>
                <?php } ?>
            </div>
        </div>

        <div class="separateur_1"></div>

        <div class="button_inscription">
            <a href="inscription_partie.php?id=<?=$evenent['id']?>" class="inscription">S'inscrire</a>
            <a href="inscription_partie.php?id=<?=$evenent['id']?>&friend=true" class="friend_inscription">Inscrire un ami</a>
            <a href="deinscription_partie.php?id=<?=$evenent['id']?>" class="petitinscriptiuon">Je me désinscris</a>
        </div>

    </main>


    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>