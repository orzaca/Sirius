<?php
include 'db.php';

// Manejar la actualización del párrafo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear un nuevo párrafo
    if (isset($_POST['new_paragraph_content']) && !empty($_POST['new_paragraph_content'])) {
        $new_content = $_POST['new_paragraph_content'];
        $sql_check = "SELECT COUNT(*) FROM paragraphs WHERE content = ''";
        $result_check = $conn->query($sql_check);
        $row_check = $result_check->fetch_array();

        // Solo insertar si no hay párrafos vacíos
        if ($row_check[0] == 0) {
            $sql = "INSERT INTO paragraphs (content) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $new_content);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Actualizar un párrafo existente
    if (isset($_POST['paragraph_id']) && isset($_POST['paragraph_content'])) {
        $id = $_POST['paragraph_id'];
        $new_content = $_POST['paragraph_content'];
        $sql = "UPDATE paragraphs SET content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_content, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Eliminar un párrafo
    if (isset($_POST['delete_paragraph_id'])) {
        $id = $_POST['delete_paragraph_id'];
        $sql = "DELETE FROM paragraphs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Obtener los párrafos desde la base de datos
$sql = "SELECT id, content FROM paragraphs ORDER BY id ASC";
$result = $conn->query($sql);
$paragraphs = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Párrafos Dinámicos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            height: 100vh;
        }

        .menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #4CAF50;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            z-index: 1000;
        }

        .menu .create-btn {
            max-width: none;
            padding: 10px;
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        .menu .create-btn:hover {
            background-color: #4CAF50;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin-top: 60px; /* Añadido margen superior para no estar detrás del menú */
        }

        .paragraph-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .paragraph {
            margin: 10px 0;
            font-size: 1.2em;
            color: #555;
            max-width: 600px;
            overflow-wrap: break-word;
        }

        .button-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Espacio entre los botones */
        }

        .button-container button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1.5em; /* Tamaño del ícono */
            transition: color 0.3s;
        }

        .edit-btn {
            color: #4CAF50;
        }

        .edit-btn:hover {
            color: #45a049;
        }

        .delete-btn {
            color: #f44336;
        }

        .delete-btn:hover {
            color: #e53935;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="menu">
        <button class="create-btn" onclick="openCreateModal()">➕ Crear Nuevo Párrafo</button>
    </div>

    <div class="container">
        <?php foreach ($paragraphs as $paragraph): ?>
            <div class="paragraph-container">
                <p class="paragraph" id="paragraph-<?php echo $paragraph['id']; ?>"><?php echo htmlspecialchars($paragraph['content']); ?></p>
                <div class="button-container">
                    <button class="edit-btn" onclick="openModal(<?php echo $paragraph['id']; ?>, '<?php echo htmlspecialchars($paragraph['content']); ?>')">
                        ✏️
                    </button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="delete_paragraph_id" value="<?php echo $paragraph['id']; ?>">
                        <button type="submit" class="delete-btn">🗑️</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal para editar el párrafo -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <form id="editForm" method="POST">
                <input type="hidden" name="paragraph_id" id="editParagraphId">
                <textarea name="paragraph_content" id="editParagraphContent" rows="4" style="width: 100%;"></textarea>
                <button type="submit" class="edit-btn">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- Modal para crear un nuevo párrafo -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('createModal')">&times;</span>
            <form id="createForm" method="POST">
                <textarea name="new_paragraph_content" id="createParagraphContent" rows="4" style="width: 100%;"></textarea>
                <button type="submit" class="create-btn">Crear Párrafo</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, content) {
            document.getElementById('editParagraphId').value = id;
            document.getElementById('editParagraphContent').value = content;
            document.getElementById('editModal').style.display = 'block';
        }

        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal') || event.target == document.getElementById('createModal')) {
                closeModal('editModal');
                closeModal('createModal');
            }
        }
    </script>

</body>
</html>
