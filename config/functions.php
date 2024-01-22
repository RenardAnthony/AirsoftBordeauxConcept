<?php
include_once '../config/db.php';

function connectDB() {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        // Configurer PDO pour générer des exceptions en cas d'erreur
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données: " . $e->getMessage());
    }
}

function getLoggedInUserInfo($conn) {
    if(isset($_SESSION['id'])){
        $mon_id = $_SESSION['id'];
        $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute(array($mon_id));
        $loggedInUser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ajoute les informations supplémentaires ici
        if ($loggedInUser) {
            $loggedInUser['selfuser_pseudo'] = $loggedInUser['username'];
            $loggedInUser['selfuser_id'] = $loggedInUser['id'];
            $loggedInUser['selfuser_avatar'] = $loggedInUser['avatar'];
        }

        return $loggedInUser;
    } else {
        return null; // Retourne null si l'utilisateur n'est pas connecté
    }
}


function getSelfUserInfo() {
    $conn = connectDB();
    return getLoggedInUserInfo($conn);
}

function getInscritsPartie($eventId) {
    $conn = connectDB(); // Utilisez la fonction pour établir la connexion à la base de données

    try {
        // Récupérer la liste des joueurs inscrits à une partie spécifique
        $stmt = $conn->prepare('SELECT * FROM partie_inscriptions WHERE event_id = ?');
        $stmt->execute(array($eventId));
        $inscrits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $inscrits;
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des joueurs inscrits : " . $e->getMessage());
    }
}




function getReplicas($conn, $userId) {
    // Résuper tout les répluque de l'utilsiateur viser
    $stmt = $conn->prepare('SELECT * FROM replique WHERE proprio = ?');
    $stmt->execute(array($userId));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




function getLastPartie($conn) {
    $sql_last_partie = "SELECT * FROM agenda WHERE date > NOW() ORDER BY date ASC LIMIT 1";
    $stmt_last_partie = $conn->prepare($sql_last_partie);
    $stmt_last_partie->execute();
    return $stmt_last_partie->fetch(PDO::FETCH_ASSOC);
}


function getMembreAmount($conn) {
    $sql = "SELECT COUNT(*) AS member_count FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($result['member_count']) ? $result['member_count'] : 0;
}



?>
