<?php
// Inclure la connexion à la base de données
include 'db_connect.php';

try {
    // Requête SQL pour sélectionner 3 marques aléatoirement
    $stmt = $pdo->query('SELECT nom, logo FROM marque ORDER BY RAND() LIMIT 3');
    
    // Récupérer les résultats sous forme de tableau associatif
    $marques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données sous forme de JSON pour utilisation côté client
    echo json_encode($marques);
} catch (PDOException $e) {
    // En cas d'erreur dans la requête SQL
    echo "Erreur lors de la récupération des marques : " . $e->getMessage();
}
?>
