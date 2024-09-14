<?php
include 'db.php';

// Manejar la actualización del párrafo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['paragraph_id'])) {
        // Actualizar el párrafo existente
        $id = $_POST['paragraph_id'];
        $new_content = $_POST['paragraph_content'];
        $sql = "UPDATE paragraphs SET content = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_content, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['new_paragraph_content'])) {
        // Crear un nuevo párrafo
        $new_content = $_POST['new_paragraph_content'];
        $sql = "INSERT INTO paragraphs (content) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $new_content);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_paragraph_id'])) {
        // Eliminar un párrafo
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
            padding: 10px 20px;
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
            margin-right: 20px;
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

        .edit-btn, .delete-btn {
            max-width: 30%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
            margin: 5px;
            display: inline-flex;
            align-items: center;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #e53935;
            transform: scale(1.05);
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
        <button class="create-btn" onclick="openCreateModal()">Crear Nuevo Párrafo</button>
    </div>

    <div class="container">
        <?php foreach ($paragraphs as $paragraph): ?>
            <div class="paragraph-container">
                <p class="paragraph" id="paragraph-<?php echo $paragraph['id']; ?>"><?php echo htmlspecialchars($paragraph['content']); ?></p>
                <button class="edit-btn" onclick="openModal(<?php echo $paragraph['id']; ?>, '<?php echo htmlspecialchars($paragraph['content']); ?>')">
                    ✏️ Modificar
                </button>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="delete_paragraph_id" value="<?php echo $paragraph['id']; ?>">
                    <button type="submit" class="delete-btn">🗑️ Eliminar</button>
                </form>
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
