<?php
// update_names.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el JSON recibido
    $newNames = json_decode(file_get_contents('php://input'), true);

    // Aquí debes incluir la conexión a la base de datos
    $servername = "localhost"; // Cambia esto según tu configuración
    $username = "username"; // Tu usuario de base de datos
    $password = "password"; // Tu contraseña de base de datos
    $dbname = "dbname"; // Nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar los nombres de las pestañas
    foreach ($newNames as $id => $name) {
        $sql = "UPDATE tabs SET name='" . $conn->real_escape_string($name) . "' WHERE id=" . intval($id);
        if (!$conn->query($sql)) {
            echo "Error actualizando el nombre: " . $conn->error;
        }
    }

    echo "Nombres actualizados correctamente.";

    // Cerrar conexión
    $conn->close();
}
?>
