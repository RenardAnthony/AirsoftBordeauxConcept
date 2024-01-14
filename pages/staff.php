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

include_once '../config/db.php'; # Inclure le fichier de configuration de la base de données
// Connexion à la base de données
$conn = connectDB();

// Requête SQL pour récupérer les informations de tous les utilisateurs
$query = "SELECT * FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <header>
        <h3>STAFF</h3>
        <nav>
            <a href="#"><p>Membres</p></a>
            <a href="#"><p>Répliques</p></a>
            <a href="#"><p>Parties</p></a>
            <a href="#"><p>Comptabilité</p></a>
        </nav>
    </header>



    <main>
        
        <div class="cadre_securite">
            <h2>Page Admin</h2>
            <p>Cette page contien des information confidentiel, Assurez-vous de ne pas montrer cette page à n'import qui.</p>
        </div>

        <div class="spacer_1"></div>

        <div class="tableau">
            <table>
                <thead>
                    <tr>
                        <th colspan="11"><p>Utilisateurs</p></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="titre">
                        <td><p>ID</p></td>
                        <td><p>Nom d'utilisateur</p></td>
                        <td><p>Nom</p></td>
                        <td><p>Prenom</p></td>
                        <td><p>Genre</p></td>
                        <td><p>Groupe Sangin</p></td>
                        <td><p>Email</p></td>
                        <td><p>Ville</p></td>
                        <td><p>Date naissance</p></td>
                        <td><p>Role</p></td>
                        <td><a href="#"><img src="" alt=""></a></td>
                    </tr>

                    <?php foreach ($users as $user):
                        
                        if ($user['genre'] == 1) {
                            $user['genre'] = "Homme";
                        } elseif ($user['genre'] == 2){
                            $user['genre'] = "Femme";
                        } else {
                            $user['genre'] = "Autre";
                        }
                        
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
                            <td class="settings"><a href=""><img src="../assets/images/theme/gear.svg" alt=""></a></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <div class="spacer_1"></div>

        


    </main>



    <footer></footer>
</body>
</html>