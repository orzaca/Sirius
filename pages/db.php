<?php
$host = 'localhost';
$db = 'ziriuson_zirius';
$user = 'ziriuson_orzaca';  
$pass = 'Orzaca2024*';     // Ajusta según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
