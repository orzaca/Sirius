<?php
require '../includes/db.php'; // Asegúrate de que la ruta es correcta

if (isset($_POST['guardar'])) {
    $id_llamada = $_POST['id_llamada'];
    $nombre_quien_llama = $_POST['nombre_quien_llama'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $numero_linea = $_POST['numero_linea'];
    $numero_factura = $_POST['numero_factura'];
    $problema_reportado = $_POST['problema_reportado'];
    $pruebas = $_POST['pruebas'];
    $observaciones = $_POST['observaciones'];

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("INSERT INTO tipificaciones (id_llamada, nombre_quien_llama, nombre_cliente, numero_linea, numero_factura, problema_reportado, pruebas, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_llamada, $nombre_quien_llama, $nombre_cliente, $numero_linea, $numero_factura, $problema_reportado, $pruebas, $observaciones]);

    echo "Datos guardados correctamente.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Tipificación</title>
    <link rel="stylesheet" href="/assets/css/tipificacion.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Formulario de Tipificación</h1>
        </header>
        
        <main>
            <form action="tipificacion.php" method="POST">
                <div class="form-group">
                    <label for="id_llamada">ID Llamada:</label>
                    <input type="text" id="id_llamada" name="id_llamada" required>
                </div>
                <div class="form-group">
                    <label for="nombre_quien_llama">Nombre de quien llama:</label>
                    <input type="text" id="nombre_quien_llama" name="nombre_quien_llama" required>
                </div>
                <div class="form-group">
                    <label for="nombre_cliente">Nombre del cliente:</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" required>
                </div>
                <div class="form-group">
                    <label for="numero_linea">Número de Línea:</label>
                    <input type="text" id="numero_linea" name="numero_linea" required>
                </div>
                <div class="form-group">
                    <label for="numero_factura">Número de Factura:</label>
                    <input type="text" id="numero_factura" name="numero_factura" required>
                </div>
                <div class="form-group">
                    <label for="problema_reportado">Problema Reportado:</label>
                    <textarea id="problema_reportado" name="problema_reportado" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="pruebas">Pruebas:</label>
                    <textarea id="pruebas" name="pruebas" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="observaciones">Observaciones:</label>
                    <textarea id="observaciones" name="observaciones" rows="4" required></textarea>
                </div>
                <div class="form-buttons">
                    <button type="button" onclick="copyFormData()">Copiar</button>
                    <button type="submit" name="guardar">Guardar</button>
                </div>
            </form>
        </main>

        <script>
            function copyFormData() {
                // Implement the copy functionality here
                alert("Función de copiar no implementada.");
            }
        </script>
    </div>
</body>
</html>
