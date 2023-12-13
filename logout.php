<?php
session_start();

// Cerrar la sesión
session_destroy();

// Redirigir a la página de inicio
header('Location: index.php');
exit();
?>
