<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter
if(!isset($_SESSION['id'])){ // Vérifier si l'utilisateur est connecté
    header("Location: login.php");
    exit();
}
if($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur'){
    header("Location: index.php");
    exit();
}

// Requête SQL pour récupérer les informations de tous les utilisateurs
$query = "SELECT * FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des compteurs
$countVisiteurs = 0;
$countMembres = 0;
$countTotal = 0;
// Initialisation des compteurs de genre
$countHommes = 0;
$countFemmes = 0;
$countAutresGenres = 0;

// Requête SQL pour obtenir le nombre de visiteurs
$queryVisiteurs = "SELECT COUNT(*) as countVisiteurs FROM users WHERE role = 'visiteur'";
$stmtVisiteurs = $conn->prepare($queryVisiteurs);
$stmtVisiteurs->execute();
$countVisiteurs = $stmtVisiteurs->fetch(PDO::FETCH_ASSOC)['countVisiteurs'];

// Requête SQL pour obtenir le nombre de membres
$queryMembres = "SELECT COUNT(*) as countMembres FROM users WHERE role != 'visiteur'";
$stmtMembres = $conn->prepare($queryMembres);
$stmtMembres->execute();
$countMembres = $stmtMembres->fetch(PDO::FETCH_ASSOC)['countMembres'];

// Calcul du total
$countTotal = $countVisiteurs + $countMembres;

// Compter le nombre d'hommes, de femmes et d'autres genres
foreach ($users as $user) {
    switch ($user['genre']) {
        case 'homme':
            $countHommes++;
            break;
        case 'femme':
            $countFemmes++;
            break;
        default:
            $countAutresGenres++;
            break;
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-control" content="public">
    <title>Admin Zone</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/faviconadmin.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/staff.css"/>
</head>
<body>
    <header><?php include "../includes/header_staff.php";?></header>



    <main>
        <div class="count_pannel">
            <div class="element">
                <h1><?=$countVisiteurs?></h1>
                <p>Freelances</p>
            </div>
            <div class="element">
                <h1><?=$countMembres?></h1>
                <p>Membres</p>
            </div>
            <div class="element">
                <h1><?=$countTotal?></h1>
                <p>Total</p>
            </div>
        </div>

        <div class="spacer_1"></div>

        <div class="cadre_securite">
            <h2>Stats :</h2>
            <ul>
                <li>Hommes : <?=$countHommes?></li>
                <li>Femmes : <?=$countFemmes?></li>
                <li>Autres genres ou non defini: <?=$countAutresGenres?></li>
            </ul>
        </div>

        <div class="spacer_2"></div>
        
        <div class="table_style_1">
            <table>
                <thead>
                    <tr>
                        <th colspan="11"><p>Utilisateurs</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="colone_name">
                        <td><p>ID</p></td>
                        <td><p>Nom d'utilisateur</p></td>
                        <td><p>Nom</p></td>
                        <td><p>Prénom</p></td>
                        <td><p>Genre</p></td>
                        <td><p>Groupe Sangin</p></td>
                        <td><p>Email</p></td>
                        <td><p>Ville</p></td>
                        <td><p>Date naissance</p></td>
                        <td><p>Role</p></td>
                        <td></td>
                    </tr>

                    <?php foreach ($users as $user):
                    ?>
                        <tr>
                            <td><p><?=$user['id']?></p></td>
                            <td><p><?=$user['username']?></p></td>
                            <td><p><?=$user['nom']?></p></td>
                            <td><p><?=$user['prenom']?></p></td>
                            <td><p><?=$user['genre']?></p></td>
                            <td><p><?=$user['groupe_sang']?></p></td>
                            <td><p><?=$user['email']?></p></td>
                            <td><p><?=$user['ville']?></p></td>
                            <td><p><?=$user['date_naissance']?></p></td>
                            <td><p><?=$user['role']?></p></td>
                            <td class="settings"><a href="">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    </main>



    <footer></footer>
</body>
</html>