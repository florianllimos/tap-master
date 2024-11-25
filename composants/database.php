<?php

  $userdb = "unknown";
  $passworddb = "unknown";

  try {

    $db = new PDO('mysql:host=mysql-unknown;dbname=unknown', $userdb, $passworddb);

  } catch (PDOException $e) {

    print "Erreur :" . $e->getMessage() . "<br/>";
    die;
  
  }