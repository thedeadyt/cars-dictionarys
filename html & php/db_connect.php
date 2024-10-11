<?php
// db_connect.php

// Connexion à la base de données
$servername = "mysql-cardictionary.alwaysdata.net";
$username = "378300_admin";
$password = "cardirectoryadmin";
$dbname = "cardictionary_cardictionary";

try {
    // Création de la connexion à la base de données
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Définir le mode d'erreur PDO en mode Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion
    echo "Erreur de connexion : " . $e->getMessage();
    die();
}
?>
