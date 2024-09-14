<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];

    // Actualizar el párrafo en la base de datos
    $sql = "UPDATE paragraphs SET content = '$content' WHERE id = 1";

    if ($conn->query($sql) === TRUE) {
        echo "Párrafo actualizado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();

    // Redireccionar de vuelta a la página principal
    header("Location: index.php");
    exit();
}
?>
