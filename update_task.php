<?php
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigir a login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $new_state = $_POST['new_state'];

    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'ourjxora_alejandro', 'Meri0803', 'db_proyectos');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Seguridad: Prevenir inyección SQL
    $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $new_state, $task_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Estado de la tarea actualizado con éxito.'); window.location.href='task_tracking.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
