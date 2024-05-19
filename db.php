<?php
$servername = "localhost";
$username = "root";
$password ="root";
$database ="wow";

$conn = new mysqli($servername, $username, $password, $database);
// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>