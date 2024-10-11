<?php
include 'db_connect.php';

$voiture_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM voiture WHERE id = $voiture_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode([]);
}
?>
