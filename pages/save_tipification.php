<?php
session_start();
require '../includes/db.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'telefonico') {
    header("Location: login.php");
    exit;
}

// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $call_id = $_POST['call_id'];
    $client_name = $_POST['client_name'];
    $line = $_POST['line'];
    $reported_problem = $_POST['reported_problem'];
    $tests = $_POST['tests'];

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO tipifications (call_id, client_name, line, reported_problem, tests) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$call_id, $client_name, $line, $reported_problem, $tests]);

    header("Location: dashboard_telefonico.php");
    exit;
}
?>
