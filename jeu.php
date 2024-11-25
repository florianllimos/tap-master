<?php
require_once("composants/database.php");
require_once("composants/header.php");
session_start();

if (isset($_POST["hidden"])) {
    $score = $_POST["hidden"];
    $id = $_SESSION["id"];
    $player = $_SESSION["pseudo"];

    $sql = "SELECT score FROM leaderboard WHERE player = :player";
    $query = $db->prepare($sql);
    $query->bindParam(":player", $player, PDO::PARAM_STR);
    $query->execute();
    
    $existingScore = $query->fetchColumn();

    if ($existingScore === false) {
        if ($score != 0) {
            $sql = "INSERT INTO leaderboard (`player`, `score`) VALUES (:player, :score)";
            $query = $db->prepare($sql);
            $query->bindParam(":player", $player, PDO::PARAM_STR);
            $query->bindParam(":score", $score, PDO::PARAM_INT);
            $query->execute();
        }
    } else {
        if ($score > $existingScore) {
            $sql = "UPDATE leaderboard SET score = :score WHERE player = :player";
            $query = $db->prepare($sql);
            $query->bindParam(":player", $player, PDO::PARAM_STR);
            $query->bindParam(":score", $score, PDO::PARAM_INT);
            $query->execute();
        }
    }

    header("Location: jeu.php");
    exit();
}
?>

<div class="container-game">
    <p id="valeur">0</p>
    <button class="click" type="button">Click me !</button>
</div>

<form id="myForm" method="POST">
    <input type="hidden" name="hidden" value="0">
    <button type="submit" class="btn-login">Envoyer mon score</button>
    <p id="share-button" onclick="copyURL()">Partagez le site</p>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var bouton = document.querySelector(".click");
        var valeurParagraphe = document.getElementById("valeur");
        var compteur = 0;

        bouton.onclick = function() {
            compteur++;
            valeurParagraphe.textContent = compteur;
            document.querySelector("input[name='hidden']").value = compteur;
        };
    });
</script>

<?php
require_once("composants/leaderboard.php");
?>
<script>
function copyURL() {
  const siteURL = window.location.href;
  
  navigator.clipboard.writeText(siteURL).then(() => {
    const button = document.getElementById('share-button');
    button.textContent = "Copi� !";
    
    setTimeout(() => {
      button.textContent = "Partagez le site";
    }, 3000);
  }).catch((error) => {
    console.error('Erreur lors de la copie:', error);
  });
}
</script>
