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


function getProchainesParties($conn) {
    $stmt_agenda = $conn->prepare("SELECT * FROM agenda WHERE date > NOW() ORDER BY date ASC LIMIT 5");
    $stmt_agenda->execute();
    $prochainesParties = $stmt_agenda->fetchAll(PDO::FETCH_ASSOC);

    return $prochainesParties;
}

// Fonction pour obtenir le nombre total de participants
function getTotalParticipants($conn, $eventId) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM partie_inscriptions WHERE event_id = ?");
    $stmt->execute([$eventId]);
    return $stmt->fetchColumn();
}

// Fonction pour obtenir 4 photos de profil au hasard
function getRandomAvatars($conn, $eventId, $limit) {
    $stmt = $conn->prepare("SELECT DISTINCT u.avatar 
                           FROM partie_inscriptions pi
                           JOIN users u ON pi.user_id = u.id
                           WHERE pi.event_id = :eventId
                           ORDER BY RAND()
                           LIMIT :limit");

    $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

//Verifier si le joueur connecter est inscrit a la partie en quesiton
function isUserRegistered($conn, $userId, $eventId) {
    $sql = "SELECT COUNT(*) FROM partie_inscriptions WHERE user_id = :user_id AND event_id = :event_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return ($count > 0);
}

//Je me suprime de la partie ou je suis inscrit
function removeInscription($conn, $userId, $eventId) {
    $sql = "DELETE FROM partie_inscriptions WHERE user_id = :user_id AND event_id = :event_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
}

function deletePartieInscriptions($conn, $partie_id) {
    // Supprimer les inscriptions à l'événement en fonction de l'ID de la partie
    $sql = "DELETE FROM partie_inscriptions WHERE event_id = :event_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':event_id', $partie_id, PDO::PARAM_INT);
    return $stmt->execute();
}




?>
