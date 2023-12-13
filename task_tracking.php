<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Tareas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Seguimiento de Tareas</h2>

        <?php
        // Lógica para obtener y mostrar las tareas desde la base de datos
        $conn = new mysqli('localhost', 'ourjxora_alejandro', 'Meri0803', 'db_proyectos');
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id, nombre, descripcion, estado FROM tareas");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nombre</th>';
            echo '<th>Descripción</th>';
            echo '<th>Estado</th>';
            echo '<th>Actualizar Estado</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nombre'] . '</td>';
                echo '<td>' . $row['descripcion'] . '</td>';
                echo '<td>' . $row['estado'] . '</td>';
                echo '<td>';
                echo '<form action="update_task.php" method="post">';
                echo '<input type="hidden" name="task_id" value="' . $row['id'] . '">';
                echo '<select class="form-control" name="new_state" required>';
                echo '<option value="Pendiente">Pendiente</option>';
                echo '<option value="En progreso">En progreso</option>';
                echo '<option value="Completada">Completada</option>';
                echo '</select>';
                echo '<button type="submit" class="btn btn-primary">Actualizar</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No hay tareas para mostrar.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>

    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
