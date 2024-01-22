<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter

if(!isset($_SESSION['id'])){ // Vérifier si l'utilisateur est connecté
    header("Location: login.php");
    exit();
}

if($selfuser_role !== 'administrateur' && $selfuser_role !== 'moderateur' && $selfuser_role !== 'comptable' && $selfuser_role !== 'organisateur'){
    header("Location: index.php");
    exit();
}

// Requête SQL pour récupérer les informations de tous les utilisateurs
$query = "SELECT * FROM users ORDER BY date_inscription DESC LIMIT 8";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les agenda
$query = "SELECT * FROM agenda WHERE date > NOW() ORDER BY date ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$agendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les répliques
$query = "SELECT * FROM replique ORDER BY date_ajout DESC LIMIT 8";
$stmt = $conn->prepare($query);
$stmt->execute();
$repliques = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        <div class="cadre_securite">
            <h2>Page Admin</h2>
            <p>Cette page contien des information confidentiel, Assurez-vous de ne pas montrer cette page à n'import qui.</p>
        </div>

        <div class="spacer_1"></div>

        <div class="table_style_1">
            <table>
                <thead>
                    <tr>
                        <th colspan="11"><img src="../assets/images/theme/membre.png" alt="Logo membre"><p>Utilisateurs</p></th>
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
            <div class="double_button">
                <a class="button_table_2" href="staff_userlist.php">En voir plus</a>
            </div>
        </div>


        <div class="spacer_1"></div>

        <div class="table_style_1">
            <table>
                <thead>
                    <tr>
                        <th colspan="8"><img src="../assets/images/theme/agenda.png" alt="Logo agenda"><p>Parties d'airsoft</p></th>
                    </tr>
                </thead>
                <tr class="colone_name">
                    <td><p>Titre</p></td>
                    <td><p>Description</p></td>
                    <td><p>Date</p></td>
                    <td><p>Joueur mix</p></td>
                    <td><p>Joueur max</p></td>
                    <td><p>Addresse</p></td>
                    <td></td>
                </tr>
                
                <?php foreach($agendas as $agenda): ?>
                    <tr>
                        <td><p><?=$agenda['titre']?></p></td>
                        <td><p><?=$agenda['description']?></p></td>
                        <td><p><?=$agenda['date']?></p></td>
                        <td><p><?=$agenda['joueur_min']?></p></td>
                        <td><p><?=$agenda['joueur_max']?></p></td>
                        <td><p><?=$agenda['terrain']?></p></td>
                        <td class="settings"><a href="staff_creation_partie?id=<?=$agenda['id']?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
                
            </table>
            <div class="double_button">
                <a class="button_table" href="staff_supp_partie.php">Supprimer</a>
                <a class="button_table" href="staff_creation_partie.php">Ajouter</a>
            </div>
        </div>

        <div class="spacer_1"></div>

    <div class="table_style_1">
        <table>
            <thead>
                <tr>
                    <th colspan="8"><img src="../assets/images/theme/replique.png" alt="Logo répliques"><p>Répliques</p></th>
                </tr>
            </thead>
            <tr class="colone_name">
                <td><p>ID</p></td>
                <td><p>Propriétaire</p></td>
                <td><p>Nom</p></td>
                <td><p>Puissance</p></td>
                <td><p>Type</p></td>
                <td><p>Marque</p></td>
                <td></td>
            </tr>
            <?php foreach($repliques as $replique):
                
                //ICI J'aimerai Afficher le pseudo du joueur qui a l'id correspondant à "proprio"
                $queryUser = "SELECT username FROM users WHERE id = :proprio_id";
                $stmtUser = $conn->prepare($queryUser);
                $stmtUser->bindParam(':proprio_id', $replique["proprio"]);
                $stmtUser->execute();
                $userName22 = $stmtUser->fetch(PDO::FETCH_ASSOC);

                // Vérifier si l'utilisateur est défini, sinon utiliser "unknown"
                $userName22 = isset($userName22['username']) ? $userName22['username'] : '-';
                            
                ?>
                <tr>
                    <td><p><?=$replique["id"]?></p></td>
                    <td><p><a href="profil.php?id=<?=$replique["proprio"]?>"><?=$userName22?></a></p></td>
                    <td><p><?=$replique["nom"]?></p></td>
                    <td><p><?=$replique["fps"]?> fps</p></td>
                    <td><p><?=$replique["type"]?></p></td>
                    <td><p><?=$replique["marque"]?></p></td>
                    <td class="settings"><a href="<?=$replique['id']?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="double_button">
            <a class="button_table_2" href="staff_repliquelist.php">Afficher plus</a>
        </div>
    </div>

    </main>



    <footer></footer>
</body>
</html>