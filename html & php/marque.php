<?php
// Connexion à la base de données
$servername = "mysql-cardictionary.alwaysdata.net";
$username = "378300_admin";
$password = "cardirectoryadmin";
$dbname = "cardictionary_cardictionary";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit();
}

if (isset($_GET['id'])) {
    $brand_id = (int)$_GET['id'];

    // Fetch brand details
    $stmt = $pdo->prepare("SELECT nom, createur, annee_creation, histoire, logo FROM marque WHERE id = ?");
    $stmt->execute([$brand_id]);

    $brand = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($brand) {
        $brand_name = htmlspecialchars($brand['nom']);
        $creator = htmlspecialchars($brand['createur']);
        $creation_date = htmlspecialchars($brand['annee_creation']);
        $history = htmlspecialchars($brand['histoire']);
        $logo_url = htmlspecialchars($brand['logo']);
    } else {
        $brand_name = 'Marque inconnue';
        $creator = '';
        $creation_date = '';
        $history = '';
        $logo_url = '';
    }

    // Fetch cars associated with the brand
    $stmt_cars = $pdo->prepare("SELECT nom, prix, vitesse_0_100, vitesse_max, image_url FROM voiture WHERE marque_id = ?");
    $stmt_cars->execute([$brand_id]);

    $cars = $stmt_cars->fetchAll(PDO::FETCH_ASSOC);

} else {
    $brand_name = 'Aucune marque sélectionnée';
    $creator = '';
    $creation_date = '';
    $history = '';
    $logo_url = '';
    $cars = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel='stylesheet' type='text/css' media='screen' href='../css/main.css'>
<link rel='stylesheet' type='text/css' media='screen' href='../css/fonts.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $brand_name; ?> - Détails</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            color: #333;
        }

        .brand-info {
            text-align: center;
            margin-top: 1200px;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 128, 255, 0.5); /* Ombre en bleu (#0080ff) */
        }

        img {
            max-width: 200px;
            height: auto;
            margin: 20px 0;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #fff;
            display: flex;
            align-items: center;
            padding-left: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #007BFF;
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
            width: 100%;
            max-width: 1200px;
        }

        .car-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 128, 255, 0.5); /* Ombre en bleu (#0080ff) */
            padding: 15px;
            text-align: center;
        }

        .car-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .car-card h3 {
            font-size: 1.5em;
            color: #333;
        }

        .car-card p {
            font-size: 1em;
            color: #666;
        }
                /* Media queries for responsiveness */
                @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .brand-info {
                max-width: 90%;
                margin-top: 80px;
            }

            .car-card h3 {
                font-size: 1.2em;
            }

            .car-card p {
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            header {
                padding-left: 10px;
                height: 50px;
            }

            h2 {
                font-size: 1.8em;
            }

            .brand-info {
                padding: 15px;
            }

            .car-grid {
                grid-template-columns: 1fr;
            }

            .car-card {
                padding: 10px;
            }

            .car-card h3 {
                font-size: 1.1em;
            }

            .car-card p {
                font-size: 0.8em;
            }

            img {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
<header>
        <h1><a href="../index.php">Cars Dictionary</a></h1>
        <div class="menu">
            <ul>
            <li><a href="./allmarque.php">Marque</a></li>
            <li><a href="./qui sommes-nous.html">Qui sommes-nous ?</a></li>
            </ul>
        </div>
    </header>

    <main class="brand-info">
        <?php if ($logo_url): ?>
            <img src="<?php echo $logo_url; ?>" alt="<?php echo $brand_name; ?> Logo">
        <?php endif; ?>
        <h2><?php echo $brand_name; ?></h2>
        <p><strong>Créateur:</strong> <?php echo $creator; ?></p>
        <p><strong>Date de création:</strong> <?php echo $creation_date; ?></p>
        <p><strong>Histoire:</strong> <?php echo nl2br($history); ?></p>
    </main>

    <section class="car-grid">
        <?php if ($cars): ?>
            <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="<?php echo htmlspecialchars($car['nom']); ?>">
                    <h3><?php echo htmlspecialchars($car['nom']); ?></h3>
                    <p><strong>Prix:</strong> <?php echo number_format($car['prix'], 2); ?> €</p>
                    <p><strong>0-100 km/h:</strong> <?php echo $car['vitesse_0_100']; ?> sec</p>
                    <p><strong>Vitesse max:</strong> <?php echo $car['vitesse_max']; ?> km/h</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune voiture disponible pour cette marque.</p>
        <?php endif; ?>
    </section>
</body>
</html>
