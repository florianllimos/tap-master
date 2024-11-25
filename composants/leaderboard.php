<?php

require_once("database.php");

$sql = "SELECT * FROM leaderboard";
$query = $db->prepare($sql);
$query->execute();

$leaderboard = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<h3>Leaderboard</h3>
<div class="container-leaderboard">
  <?php foreach ($leaderboard as $userboard) : ?>
    <div class="card-leaderboard">
      <p><?= $userboard["player"] ?></p>
      <p><?= $userboard["score"] ?></p>
    </div>
  <?php endforeach; ?>
</div>