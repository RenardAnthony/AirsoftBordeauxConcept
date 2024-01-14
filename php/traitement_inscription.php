<?php
session_start();

// Connexion à la base de données
include '../config/db.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}




// Récupération des données du formulaire
$pseudo = htmlspecialchars($_POST['pseudo']);
$email = htmlspecialchars($_POST['champMail']);
$mdp = htmlspecialchars($_POST['mot_de_passe']);




// Verification et inscrciption
if (!empty($email)){// L'email n'a pas été defini
    if (!empty($pseudo)){ // Le nom d'utilisateur n'a pas été defini
        if (!empty($mdp)) {// Le mot de passe n'a pas été defini
            // Le nom d'utilisateur ou l'email existe déjà dans la base de données
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $pseudo, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $erreur = "Le nom d'utilisateur ou l'email existe déjà. Veuillez en choisir un autre.";

            } else {//Si tout les condition sont remplis alors j'effectue cette partie la.



                // Hachage du mot de passe
                $mdp_hache = password_hash($mdp, PASSWORD_BCRYPT);
                


                // Requête préparée pour insérer les données dans la base de données
                $stmt = $conn->prepare("INSERT INTO users (username, email, mdp) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $pseudo, $email, $mdp_hache);

                // Exécution de la requête préparée
                if ($stmt->execute()) {
                    echo "Inscription réussie !";
        
        
                    header("Location: ../pages/profil.php?id=".$_SESSION['id']);
                } else {
                    echo "Erreur lors de l'inscription : " . $stmt->error;
                }
            }
        } else {
            $erreur = "Vous avez pas défini de mot de passe...";
        }
    } else {
        $erreur = "Vous avez pas défini de nom d'utilisateur...";
    }
} else {
    $erreur =  "Vous avez pas défini de email...";
}






//Afficher les erreur si tout ne pas bien remplie
if(isset($erreur)){


    header("Location: ../pages/inscription.php?error=$erreur");
    echo $erreur;
}


?>