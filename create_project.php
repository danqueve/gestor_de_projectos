<?php
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigir a login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'ourjxora_alejandro', 'Meri0803', 'db_proyectos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Seguridad: Prevenir inyección SQL
    $stmt = $conn->prepare("INSERT INTO proyectos (nombre, descripcion, fecha_creacion) VALUES (?, ?, CURDATE())");
    $stmt->bind_param("ss", $nombre, $descripcion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Proyecto creado con éxito.'); window.location.href='dashboard.php';</script>";
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
    <title>Crear Nuevo Proyecto</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Crear Nuevo Proyecto</h2>
        <form action="create_project.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Proyecto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción del Proyecto:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear Proyecto</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
