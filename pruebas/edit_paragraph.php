<?php
include 'db.php';

// Obtener el párrafo actual
$sql = "SELECT content FROM paragraphs WHERE id = 1";
$result = $conn->query($sql);
$paragraph = ($result->num_rows > 0) ? $result->fetch_assoc()['content'] : "";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Párrafo</title>
</head>
<body>

    <h1>Editar el Párrafo</h1>
    <form method="POST" action="save_paragraph.php">
        <textarea name="content" rows="5" cols="50"><?php echo $paragraph; ?></textarea>
        <br><br>
        <button type="submit">Guardar Cambios</button>
    </form>

</body>
</html>

<?php $conn->close(); ?>
