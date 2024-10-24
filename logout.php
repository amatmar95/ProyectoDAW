<?php
include "conexion.php"; // Incluir el archivo de conexión si es necesario
session_start(); // Iniciar la sesión

// Limpiar y destruir la sesión
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header('Location: login.php');
?>