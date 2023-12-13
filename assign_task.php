<?php
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigir a login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proyecto = $_POST['proyecto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $usuario_responsable = isset($_POST['usuario_responsable']) ? $_POST['usuario_responsable'] : null;

    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'ourjxora_alejandro', 'Meri0803', 'db_proyectos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Seguridad: Prevenir inyección SQL
    $stmt = $conn->prepare("INSERT INTO tareas (proyecto_id, nombre, descripcion, estado, usuario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $proyecto, $nombre, $descripcion, $estado, $usuario_responsable);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Tarea asignada con éxito.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Nueva Tarea</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Asignar Nueva Tarea</h2>
        <form action="assign_task.php" method="post">
            <div class="form-group">
                <label for="proyecto">Seleccionar Proyecto:</label>
                <!-- Aquí puedes cargar dinámicamente los proyectos desde la base de datos -->
                <select class="form-control" id="proyecto" name="proyecto" required>
                    <option value="" disabled selected>Seleccione un proyecto</option>
                    <!-- Ejemplo de opciones estáticas -->
                    <option value="1">Proyecto 1</option>
                    <option value="2">Proyecto 2</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre de la Tarea:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción de la Tarea:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="estado">Estado de la Tarea:</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En progreso">En progreso</option>
                    <option value="Completada">Completada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="usuario_responsable">Usuario Responsable:</label>
                <!-- Aquí puedes cargar dinámicamente los usuarios desde la base de datos -->
                <select class="form-control" id="usuario_responsable" name="usuario_responsable">
                    <option value="" disabled selected>Seleccione un usuario</option>
                    <!-- Ejemplo de opciones estáticas -->
                    <option value="1">Usuario 1</option>
                    <option value="2">Usuario 2</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Asignar Tarea</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
