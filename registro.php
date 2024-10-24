<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Registro</title>
</head>

<body>
    <?php
    include "consultas.php";

    // Creamos un menú genérico para usuarios invitados
    $menu = "<div class='header'>
            <img src='logo.png' alt='Logo corporativo'>
            <div class='menu'>
                <a href='index.php'>Inicio</a>
                <a href='catalogo.php'>Catálogo</a>
                <a href='login.php'>Iniciar sesión</a>           
                </div>
            </div>";

    // Procesamos métodos GET. Comprobamos si hemos recibido mensaje "Registrar" por GET. Si es así, ejecutamos el siguiente código
    if (isset ($_GET["Registrar"])) {
        // Mostramos el formulario para registrarse como nuevo usuario
        echo '<div class="contenedorFormulario">
            <h1>Registro</h1>
            <form action="' . $_SERVER["PHP_SELF"] . '" method="POST" id="formularioRegistro">
            <div class="input_container">
            Nombre: <input type="text" name="nombre" required><br><br>
            Apellidos: <input type="text" name="apellidos" required><br><br>
            Email: <input type="email" name="email" required><br><br>
            Contraseña: <input type="password" name="contraseña" required><br><br>
            Fecha Nacimiento: <input type="date" name="fechaNacimiento"><br><br>
            </div>';

        // Creamos el input de tipo submit para enviar los datos cuando hayamos completado los datos
        echo '<div class="button_container">
            <input type="submit" name="RegistrarUsuario" value="Registrar" class="botones_formulario"/>
            <a href="login.php" class="botones_formulario">Volver</a>
            </div>
            </form>
            </div>';
    }

    /* Procesamos método POST. Comprobamos si se ha recibido mensaje "RegistrarUsuario" por POST y,
    si es así, ejecutamos el siguiente código */
    if (isset ($_POST["RegistrarUsuario"])) {
        // Obtenemos los datos del formulario y los guardamos en variables
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];
        $fechaNacimiento = $_POST["fechaNacimiento"];

        // Llamamos a la función registrarUsuario() pasándole como parámetros los valores recibidos del formulario
        $resultado = registrarUsuario($nombre, $apellidos, $email, $contraseña, $fechaNacimiento);

        // Verificamos si se ha registrado correctamente el usuario y mostramos de nuevo el formulario con los datos introducidos
        if ($resultado) {
            echo '<div class="contenedorFormulario">
            <h1>Registro</h1>
            <form action="' . $_SERVER["PHP_SELF"] . '" method="POST" id="formularioRegistro">
            <div class="input_container">    
            Nombre: <input type="text" name="nombre" value="' . $nombre . '" required><br><br>                
				Apellidos: <input type="text" name="apellidos" value="' . $apellidos . '" required><br><br>
                Email: <input type="email" name="email" value="' . $email . '" required><br><br>
                Contraseña: <input type="password" name="contraseña" value="' . $contraseña . '" required><br><br>
                Fecha Nacimiento: <input type="date" name="fechaNacimiento" value="' . $fechaNacimiento . '"><br><br>
                </div>';
            echo '<div class="button_container">
            <a href="login.php" class="botones_formulario">Iniciar sesión</a>
            <p class="mensajeExito">¡Se ha registrado correctamente!</p>
            </div>  
            </form>              
            </div>';
        } else {
            // Mostramos un mensaje de error si no se pudo registrar el usuario
            echo "<p>¡No se ha podido registrar!</p>";
        }
    }
    ?>
</body>

</html>