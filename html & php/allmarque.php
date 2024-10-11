<?php
// Connexion à la base de données
$servername = "mysql-cardictionary.alwaysdata.net";
$username = "378300_admin";
$password = "cardirectoryadmin";
$dbname = "cardictionary_cardictionary";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupérer toutes les marques avec leur ID
$sql = "SELECT id, nom, logo FROM marque";
$result = $conn->query($sql);

$marque = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marque[] = $row; // Ajouter chaque marque à un tableau
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cars Dictionary - Marques</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./../css/main.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='./../css/fonts.css'>
    <style>
        /* Style pour la carte */
        .card {
            margin-left: 2%;
            box-shadow: 0px 4px 8px rgba(0, 128, 255, 0.5);
            text-decoration: none;
            color: black;
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Ajout de la transition pour un effet fluide */
            width: 200px; /* Limite la largeur de la carte pour uniformiser la taille */
            padding: 15px; /* Ajout de padding pour plus d'espacement interne */
        }

        /* Effet au survol de la carte */
        .card:hover {
            transform: scale(1.1); /* Agrandir la carte à 110% de sa taille initiale */
            box-shadow: 0px 6px 12px rgba(0, 128, 255, 0.7); /* Ombre plus prononcée au survol */
            color: #0080ff;
        }

        /* Conteneur principal des cartes */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        /* Image de la carte */
        .card-img {
            max-width: 100%;
            height: 100px; /* Limite la hauteur de l'image à 100px */
            object-fit: contain; /* Conserve le ratio d'aspect de l'image */
            margin-bottom: 10px; /* Espacement entre l'image et le texte */
        }

        /* Nom de la marque */
        .brand-name {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.1em;
        }

        .main {
            padding-top: 70px;
            z-index: 0; /* Place les cartes en dessous du modèle 3D */
            padding-top: 0; /* Pour éviter que les cartes ne se chevauchent avec le modèle 3D */
        }

                /* Media queries pour rendre la page responsive */
                @media (max-width: 1024px) {
            .card {
                width: 180px; /* Réduction de la taille des cartes */
            }

            .card-container {
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .card {
                width: 150px;
            }

            .brand-name {
                font-size: 1em;
            }

            .card-container {
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 120px;
            }

            .card-img {
                height: 80px;
            }

            .brand-name {
                font-size: 0.9em;
            }

            /* Disposer les cartes en une seule colonne */
            .card-container {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><a href="../index.php">cars-dictionary</a></h1>
        <div class="menu">
            <ul>
            <li><a href="./allmarque.php">Marque</a></li>
            <li><a href="./qui sommes-nous.html">Qui sommes-nous ?</a></li>
            </ul>
        </div>
    </header>

    <!-- Conteneur principal pour les cartes de marques -->
    <div class="main">
        <h2>Liste des marques</h2>
        <div class="card-container">
            <?php foreach ($marque as $marque) : ?>
                <a href="./marque.php?id=<?= $marque['id'] ?>" class="card">
                    <img class="card-img" src="<?= $marque['logo'] ?>" alt="<?= $marque['nom'] ?>">
                    <p class="brand-name"><?= htmlspecialchars($marque['nom']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
