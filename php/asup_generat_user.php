<?php
include_once '../config/session.php'; # Inclure le fichier de configuration de la base de données

// Connexion à la base de données
$conn = connectDB();

// Requête SQL pour insérer les utilisateurs de test
$sql = "
    INSERT INTO users (email, mdp, username, role, avatar, prenom, nom, genre, groupe_sang, date_naissance, ville, bio)
    VALUES
    ('user1@example.com', 'hashed_password_1', 'user1', 'visiteur', 'https://thispersondoesnotexist.com', 'John', 'Doe', '0', 'A+', '1990-01-01', 'Paris', 'Bio utilisateur 1'),
    ('user2@example.com', 'hashed_password_2', 'user2', 'visiteur', 'https://thispersondoesnotexist.com', 'Jane', 'Smith', '1', 'A-', '1991-02-02', 'Marseille', 'Bio utilisateur 2'),
    ('user3@example.com', 'hashed_password_3', 'user3', 'visiteur', 'https://thispersondoesnotexist.com', 'Bob', 'Johnson', '0', 'A+', '1992-03-03', 'Lyon', 'Bio utilisateur 3'),
    ('user4@example.com', 'hashed_password_4', 'user4', 'visiteur', 'https://thispersondoesnotexist.com', 'Alice', 'Williams', '1', 'A-', '1993-04-04', 'Toulouse', 'Bio utilisateur 4'),
    ('user5@example.com', 'hashed_password_5', 'user5', 'visiteur', 'https://thispersondoesnotexist.com', 'Charlie', 'Brown', '0', 'A+', '1994-05-05', 'Bordeaux', 'Bio utilisateur 5'),
    ('user6@example.com', 'hashed_password_6', 'user6', 'visiteur', 'https://thispersondoesnotexist.com', 'Eva', 'Miller', '1', 'A-', '1995-06-06', 'Nice', 'Bio utilisateur 6'),
    ('user7@example.com', 'hashed_password_7', 'user7', 'visiteur', 'https://thispersondoesnotexist.com', 'David', 'Anderson', '0', 'A+', '1996-07-07', 'Lille', 'Bio utilisateur 7'),
    ('user8@example.com', 'hashed_password_8', 'user8', 'visiteur', 'https://thispersondoesnotexist.com', 'Sophia', 'Wilson', '1', 'A-', '1997-08-08', 'Strasbourg', 'Bio utilisateur 8'),
    ('user9@example.com', 'hashed_password_9', 'user9', 'visiteur', 'https://thispersondoesnotexist.com', 'George', 'Moore', '0', 'A+', '1998-09-09', 'Nantes', 'Bio utilisateur 9'),
    ('user10@example.com', 'hashed_password_10', 'user10', 'visiteur', 'https://thispersondoesnotexist.com', 'Olivia', 'Taylor', '1', 'A-', '1999-10-10', 'Montpellier', 'Bio utilisateur 10');
";

// Exécution de la requête
$stmt = $conn->prepare($sql);
$stmt->execute();

echo "Utilisateurs de test ajoutés avec succès !";
?>