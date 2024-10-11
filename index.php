<?php
// Connexion à la base de données
$servername = "mysql-cardictionary.alwaysdata.net";
$username = "378300_admin";
$password = "cardirectoryadmin";
$dbname = "cardictionary_cardictionary";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sélectionner 3 marques aléatoires
$sql = "SELECT id, nom, logo FROM marque ORDER BY RAND() LIMIT 3";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cars Dictionary</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/main.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/fonts.css'>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 200vh;
            font-family: Arial, sans-serif;
        }

        header {
            height: 60px;
            position: fixed;
            width: 100%;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding-left: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main {
            padding-top: 70px;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .card {
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card:hover {
            background-color: #f0f0f0;
            transform: scale(1.1); /* Agrandir la carte à 110% de sa taille initiale */
            box-shadow: 0px 6px 12px rgba(0, 128, 255, 0.7); /* Ombre plus prononcée au survol */
            color: #0080ff;
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .car {
            height: 100vh;
            position: relative;
        }
        @media (max-width: 480px) {
            header h1 {
                font-size: 18px;
            }

            .card {
                width: 120px;
                padding: 15px;
            }

            .card img {
                width: 80px;
                height: 80px;
            }

            .car {
                height: 40vh;
            }
        }

    </style>
</head>
<body>
    <header>
        <h1><a href="./index.php">Cars Dictionary</a></h1>
        <div class="menu">
            <ul>
                <li><a href="./html & php/allmarque.php">Marque</a></li>
                <li><a href="./html & php/qui sommes-nous.html">Qui sommes-nous ?</a></li>
            </ul>
        </div>
    </header>

    <!-- Modèle 3D -->
    <div class="car">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    </div>

    <!-- Cartes de marques -->
    <div class="main">
        <div class="card-container" id="card-container">
            <?php
            if ($result->num_rows > 0) {
                // Afficher les marques
                while($row = $result->fetch_assoc()) {
                    echo "<a href='./html & php/marque.php?id=" . $row["id"] . "' class='card'>";
                    echo "<img class='card-img' src='" . $row["logo"] . "' alt='" . $row["nom"] . "'>";
                    echo "<p>" . $row["nom"] . "</p>";
                    echo "</a>";
                }
            } else {
                echo "Aucune marque disponible.";
            }
            ?>
        </div>
    </div>

    <script>
        // Initialisation de la scène, de la caméra et du rendu
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    
        var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0);
        document.querySelector('.car').appendChild(renderer.domElement);
    
        var light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(5, 10, 7.5);
        scene.add(light);
    
        var ambientLight = new THREE.AmbientLight(0x404040, 2);
        scene.add(ambientLight);
    
        var loader = new THREE.GLTFLoader();
        var model;
    
        loader.load('./voiture.glb', function (gltf) {
            model = gltf.scene;
            model.scale.set(0.6, 0.6, 0.6);
            model.position.set(0, 0.6, 1);
            model.rotation.x = THREE.Math.degToRad(25);
            scene.add(model);
        }, undefined, function (error) {
            console.error(error);
        });
    
        camera.position.z = 5;
    
        var animate = function () {
            requestAnimationFrame(animate);
            if (model) {
                model.rotation.y += 0.0009;
            }
            camera.position.y = window.scrollY * 0.01;
            renderer.render(scene, camera);
        };
        animate();
    
        window.addEventListener('resize', function () {
            var width = window.innerWidth;
            var height = window.innerHeight;
            renderer.setSize(width, height);
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
