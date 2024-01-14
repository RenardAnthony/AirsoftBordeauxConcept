<?php
session_start();

// Connexion à la base de données
include '../config/db.php';
$conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

// Vérifie si l'ID de l'utilisateur est passé dans l'URL
if(isset($_GET['id'])){
    // Convertit l'ID en entier pour des raisons de sécurité
    $getid = intval($_GET['id']);

    // Prépare la requête SELECT pour récupérer les informations de l'utilisateur à partir de l'ID
    $requser = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

    // Vérifie si l'utilisateur existe dans la base de données
    if(empty($userinfo['username'])){
        // Redirige vers l'accueil si l'utilisateur n'existe pas
        header("Location: ../pages/index.php"); 
    }


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises meta pour les informations de la page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Description de la page (environ 150-160 caractères)">
    <meta name="keywords" content="mots clés, séparés par des virgules, pertinents pour la page">
    <meta name="author" content="Votre nom ou le nom de votre association">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Cache-control" content="public">
    <title>Profil | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/profil.css"/>
</head>
<body>
    <!-- Inclusion du header -->
    <header><?php include "../includes/header.php";?></header>


    <main>

        <div id="part1">
            <!-- Affiche la photo de profil de l'utilisateur -->
            <img src="../assets/images/avatars/<?=$userinfo['id']?>" alt="Photo de profil de <?=$userinfo['username']?>">


            <div id="part1-1">
                <!-- Affiche le nom, prénom, âge, ville et groupe sanguin de l'utilisateur -->
                <h1><?=$userinfo['username']?></h1>
                <?php if ($userinfo['cansee_nom']) { ?>
                    <p><?=$userinfo['nom']?></p>
                <?php } ?>
                <?php if ($userinfo['cansee_prenom']) { ?>
                    <p><?=$userinfo['prenom']?></p>
                <?php } ?>
                <!-- Trouver l'âge de l'utilisateur juste avec la date -->
                    <?php 
                        // Supposons que la date de naissance est stockée dans la colonne 'date_naissance'
                        $date_naissance = $userinfo['date_naissance'];
                        
                        // Date actuelle
                        $aujourdhui = new DateTime();

                        // Date de naissance de l'utilisateur (convertie en objet DateTime)
                        $date_naissance_obj = new DateTime($date_naissance);

                        // Calcul de la différence entre la date actuelle et la date de naissance
                        $diff = $date_naissance_obj->diff($aujourdhui);

                        // Récupération de l'âge en années
                        $age = $diff->y;
                    ?>
                <p><?php if($age <= 120){echo $age . " ans";}?></p>
                <?php if ($userinfo['cansee_localisation']) { ?>
                    <p><?=$userinfo['ville']?></p>
                <?php } ?>
                <?php if ($userinfo['cansee_sanguin']) { ?>
                    <p><?=$userinfo['groupe_sang']?></p>
                <?php } ?>
            </div>
            <div id="role">
                <!-- Affiche le badge de rang de l'utilisateur et une liste de badges supplémentaires -->
                <img id="badge" src="../assets/images/badges/t3.png" alt="" title="► 3 ans d'ancienneté !">
                <div id="liste_badge">
                    <img class="badge_petit" src="../assets/images/badges/t2.png" alt="" title="► 2eme année de services">
                    <img class="badge_petit" src="../assets/images/badges/m2.png" alt="" title="► Les phenix ca me connais !">
                    <img class="badge_petit" src="../assets/images/badges/p1.png" alt="" title="► Premier craquage de nuque">
                </div>
            </div>
        </div>
        <?php
        // Vérifie si la bio de l'utilisateur n'est pas vide
        if(!empty($userinfo['bio'])){?>

            <div id="part2">
                <!-- Affiche la bio de l'utilisateur -->
                <h2>Bio</h2>
                <p><?=$userinfo['bio']?></p>
            </div>

        <?php } ?>

        <?php 
        // Vérifie si l'armurerie de l'utilisateur n'est pas vide
        if(!empty($userinfo['armurerie'])){?>

            <div id="part3">
                <h2>Réplique(s)</h2>
                <div id="liste_replique">

                <?php
                // Récupère les ID des répliques de l'utilisateur dans un array
                $repliques = $userinfo['armurerie'];
                $replique = explode(",", $repliques);
                $replique_count = count($replique); //Combien de répliques

                // Connexion à la base de données pour récupérer les informations de chaque réplique
                $dsn = "mysql:host=localhost;dbname=airsoftbordeaux;charset=utf8";
                $db_username = "root";
                $db_password = "0000";

                try {
                    $pdo = new PDO($dsn, $db_username, $db_password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Erreur de connexion à la base de données : " . $e->getMessage());
                }

                // Boucle pour afficher chaque réplique de l'utilisateur
                foreach($replique as $replique_value){
                    
                    $stmt = $pdo->prepare("SELECT * FROM replique WHERE id = :replique_id");
                    $stmt->bindParam(':replique_id', $replique_value, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    ?>

                    <div class="replique_unique">
                        <!-- Affiche l'image, nom et caractéristiques de chaque réplique -->
                        <img src="<?=$result['img']?>" alt="<?=$result['nom']?>">
                        <h2><?=$result['nom']?></h2>
                        <p><?=$result['fps']?> fps - <?=$result['type']?></p>
                    </div>

                <?php } ?>

                </div>
                
            <?php } ?>

            </div>

        </div>

        <div id="part4">
            <table>
                <!-- Affiche le nombre de messages et le nombre de parties jouées par l'utilisateur -->
                <tr>
                    <td><p>47</p></td>
                    <td><p>21</p></td>
                </tr>
                <tr>
                    <td><h2>Nbr de messages</h2></td>
                    <td><h2>Nbr de parties jouer</h2></td>
                </tr>
            </table>
        </div>

        <?php 
        // Vérifie si l'utilisateur est connecté et que c'est son propre profil
        if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){ ?>

            <div id="part5">
                <!-- Affiche des liens pour éditer le profil et se déconnecter -->
                <a href="../pages/profil_edit.php">Edit profil</a>
                <a href="../php/traitement_deconnexion.php">Déconnexion</a>
            </div>

        <?php } ?>

    </main>

    <!-- Inclusion du footer -->
    <footer><?php include "../includes/footer.php";?></footer>
</body>
</html>

<?php
} else {
}?>