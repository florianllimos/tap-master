<?php

require_once("composants/database.php");
require_once("composants/header.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST["pseudo"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {

    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirm_password = htmlspecialchars($_POST["confirm_password"]);

    if ($password === $confirm_password) {

        $check_pseudo = "SELECT COUNT(*) AS count FROM users WHERE pseudo = :pseudo";
        $query_check = $db->prepare($check_pseudo);
        $query_check->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $query_check->execute();
        $result = $query_check->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] == 0) {

            $password_hashed = hash('sha256', $password);
            $create_account = "INSERT INTO users (pseudo, password) VALUES (:pseudo, :password)";
            $create_query = $db->prepare($create_account);
            $create_query->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
            $create_query->bindParam(":password", $password_hashed, PDO::PARAM_STR);

            if ($create_query->execute()) {
                ?>
                <h2 class="success">Compte créé !</h2>
                <?php
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                ?>
                <h2 class="error">Erreur lors de la cr�ation du compte !</h2>
                <?php
            }

        } else {
            echo "Le pseudo est déjà= utilisé.";
        }

    } else {
        echo "Les mots de passe ne correspondent pas.";
    }

}
?>

<form method="POST" class="form-account">
    <h2 class="form-title">Création</h2>
    <div class="bloc-form">
        <input type="text" name="pseudo" placeholder="Votre pseudo" required>
    </div>
    <div class="bloc-form">
        <input type="password" name="password" placeholder="Mot de passe" required>
    </div>
    <div class="bloc-form">
        <input type="password" name="confirm_password" placeholder="Confirmation du mot de passe" required>
    </div>
    <div class="bloc-form">
        <button type="submit" class="btn-create">Créer mon compte</button>
    </div>
    <div class="bloc-form">
        <button type="button" class="btn-login" onClick="window.location.href = 'index.php'">Me connecter</button>
    </div>
</form>
