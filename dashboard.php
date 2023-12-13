<?php
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigir a login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Aquí puedes incluir la lógica para obtener los proyectos y tareas del usuario desde la base de datos
// Por ejemplo, hacer una consulta a la base de datos para obtener los proyectos y tareas

// Conectar a la base de datos
$conn = new mysqli('localhost', 'ourjxora_alejandro', 'Meri0803', 'db_proyectos');
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener proyectos
$proyectos = [];
$stmt = $conn->prepare("SELECT id, nombre, descripcion FROM proyectos");
// $stmt->bind_param("i", $_SESSION['user_id']); // Si los proyectos están relacionados con el usuario
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $proyectos[] = $row;
}
$stmt->close();

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Panel de Control del Usuario</h2>
        <p>Bienvenido, <?php echo $_SESSION['user_name']; ?>!</p>
        <a href="create_project.php" class="btn btn-primary">Crear Nuevo Proyecto</a>
        <a href="assign_task.php" class="btn btn-secondary">Asignar Tarea</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>


        <h3>Tus Proyectos</h3>
        <ul>
            <?php foreach ($proyectos as $proyecto): ?>
                <li><?php echo $proyecto['nombre']; ?> - <?php echo $proyecto['descripcion']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
