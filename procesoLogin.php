<?php
require_once "consultas.php";
require_once "conexion.php";

// Iniciar la sesión
session_start();

// Verificar si se ha enviado el formulario por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Verificar las credenciales del usuario
    $usuario = tipoUsuario($email, $contraseña);

    if ($usuario !== false) {
        // Si las credenciales son válidas, configurar variables de sesión
        $_SESSION['tipoUsuario'] = $usuario['tipoUsuario'];
        $_SESSION['ID_usuario'] = $usuario['ID_usuario'];
        // Redirigir al usuario al index
        header('Location: index.php');
        exit();
    } else {
        // Si las credenciales son inválidas, configurar el mensaje de error
        $_SESSION['error_login'] = 'Correo electrónico o contraseña incorrectos';
        // Redirigir al usuario al login
        header('Location: login.php');
        exit();
    }
}
?>