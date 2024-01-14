<?php
include_once '../config/session.php'; #Recuperer les information de mon utilisateur connecter


if (isset($_SESSION['id'])) {
    // Je vérifie si mon utilisateur est bien connecté
    $requser = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
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
    <title>Nom de la page | Airsoft Bordeaux Concept</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/theme/favicon.png"/>
    
    <!-- Feuilles de style CSS et autres liens vers des ressources (si nécessaire) -->
    <link rel="stylesheet" href="../css/ABC_design.css"/>
    <link rel="stylesheet" href="../css/profil_edit.css"/>
</head>
<body>
    <header><?php include "../includes/header.php";?></header>

    <main>
        <div id="global_edition_box">
            <form method="POST" action="../php/traitement_edition.php" id="edit_form">
                <div class="side_by_side">
                    <div class="partess">
                        <h2>- Identifiant -</h2>
                        <table>
                            <tr>
                                <td class="label">Email :</td>
                                <td><input type="text" class="input-text-base" name="email" placeholder="Email" value="<?=$user['email']?>" required></td>
                            </tr>
                            <tr>
                                <td>Nom d'utilisateur :</td>
                                <td><input type="text" class="input-text-base" name="username" placeholder="Pseudo" value="<?=$user['username']?>" required></td>
                            </tr>
                            <tr>
                                <td class="label">Mot de passe :</td>
                                <td><a class="btn_mdp_new" href="../php/profil_edit_mdp.php">Modifier</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="partess">
                        <h2>- Information personnelle -</h2>
                        <table>
                            <tr>
                                <td class="label">Genre :</td>
                                <td>
                                    <select class="input-text-base" name="genre" id="">
                                        <option value="0"></option>
                                        <option value="1" <?php if($user['genre'] == 1) echo "selected"; ?>>Homme</option>
                                        <option value="2" <?php if($user['genre'] == 2) echo "selected"; ?>>Femme</option>
                                        <option value="3" <?php if($user['genre'] == 3) echo "selected"; ?>>Autre</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Date de naissance :</td>
                                <td><input type="date" class="input-text-base" name="date_naissance" value="<?=$user['date_naissance']?>" required></td>
                            </tr>
                            <tr>
                                <td class="label">Localisation :</td>
                                <td><input type="text" class="input-text-base" name="ville" placeholder="Ville" value="<?=$user['ville']?>" required></td>
                            </tr>
                            <tr>
                                <td class="label">Nom :</td>
                                <td><input type="text" class="input-text-base" name="nom" placeholder="Nom" value="<?=$user['nom']?>" required></td>
                            </tr>
                            <tr>
                                <td class="label">Prenom :</td>
                                <td><input type="text" class="input-text-base" name="prenom" placeholder="Prenom" value="<?=$user['prenom']?>" required></td>
                            </tr>
                            <tr>
                                <td class="label">Groupe sanguin :</td>
                                <td>
                                    <select class="input-text-base" name="groupe_sang" id="">
                                        <option value="none">Inconnu</option>
                                        <option value="AB+" <?php if($user['groupe_sang'] == "AB+") echo "selected"; ?>>AB+</option>
                                        <option value="AB-" <?php if($user['groupe_sang'] == "AB-") echo "selected"; ?>>AB-</option>
                                        <option value="A+" <?php if($user['groupe_sang'] == "A+") echo "selected"; ?>>A+</option>
                                        <option value="A-" <?php if($user['groupe_sang'] == "A-") echo "selected"; ?>>A-</option>
                                        <option value="B+" <?php if($user['groupe_sang'] == "B+") echo "selected"; ?>>B+</option>
                                        <option value="B-" <?php if($user['groupe_sang'] == "B-") echo "selected"; ?>>B-</option>
                                        <option value="O+" <?php if($user['groupe_sang'] == "O+") echo "selected"; ?>>O+</option>
                                        <option value="O-" <?php if($user['groupe_sang'] == "O-") echo "selected"; ?>>O-</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="side_by_side">
                    <div class="partess">
                        <h2>- Profil -</h2>
                        <a href="../php/imageUploader.php"><img id="pdp_live" src="../assets/images/avatars/<?=$user['avatar']?>" alt="Photo de profil de <?=$user['username']?>"></a>
                        <textarea name="bio" id="" cols="75" rows="4" placeholder="Bio" maxlength="1000"><?=$user['bio']?></textarea>
                    </div>
                    <div class="partess spacing">
                        <h2>- Préférences -</h2>
                        <table>
                            <tr>
                                <td><input type="checkbox" name="cansee_nom" <?php if($user['cansee_nom']==1) echo "checked"; ?>></td>
                                <td>Afficher mon Nom</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cansee_prenom" <?php if($user['cansee_prenom']==1) echo "checked"; ?>></td>
                                <td>Afficher mon Prénom</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cansee_sanguin" <?php if($user['cansee_sanguin']==1) echo "checked"; ?>></td>
                                <td>Afficher mon groupe sanguin</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="cansee_localisation" <?php if($user['cansee_localisation']==1) echo "checked"; ?>></td>
                                <td>Afficher ma localisation</td>
                            </tr>
                        </table>
                        <div id="bottom_edit_part">
                            <p class="gray-text">*Les administrateurs et modérateurs peuvent quand-même voir vos informations</p>
                            <a href="../php/traitement_suppression.php" class="red-text">Supprimer mon compte et toutes mes informations personnelles</a>
                        </div>
                    </div>
                </div>
                <div id="submit">
                    <input type="submit" value="Valider">
                </div>
            </form>
        </div>
    </main>
    <?php
    } else {
        header("Location: ../pages/index.php");
    }
    ?>
    <footer>
        <?php include "../includes/footer.php";?>
    </footer>
</body>
</html>