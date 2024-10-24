<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css">
	<title>Formulario de usuarios</title>
</head>

<body>

	<?php
	include "funciones.php";

	// Verificar si el usuario ha iniciado sesión
	if (isset ($_SESSION['tipoUsuario'])) {
		$tipoUsuario = $_SESSION['tipoUsuario'];
		// Configurar el menú según el tipo de usuario
		if ($tipoUsuario == 1) {
			// Usuario administrador
			$menu = "<div class='header'>
        <img src='logo.png' alt='Logo corporativo'>
                <div class='menu'>
                        <a href=''>Inicio</a>
                        <a href='catalogo.php'>Catálogo</a>
                        <a href='catalogoExclusivo.php'>Catálogo exclusivo</a>
                        <a href='usuarios.php'>Usuarios</a>
                        <a href='logout.php'>Cerrar sesión</a>
                </div>
				</div>";

			// Creamos una condición que comprueba si se ha recibido una solicitud de "editar" por GET, y si es así, ejecuta el siguiente código
			if (isset ($_GET["Editar"])) {
				// Obtenemos el id del producto a editar
				$id = $_GET["Editar"];
				// Llamamos a la función obtenerUsuario() con ese id
				$usuario = obtenerUsuario($id);
				// Creamos una variable y recorremos el resultado obtenido de llamar a la función
				$fila = mysqli_fetch_assoc($usuario);
				// Creamos las variables y les damos los valores recibidos del usuario que hemos solicitado
				$nombre = $fila['nombre'];
				$apellidos = $fila['apellidos'];
				$email = $fila['email'];
				$contraseña = $fila['contraseña'];
				$fechaNacimiento = $fila['fechaNacimiento'];
				$tipoUsuario = $fila['tipoUsuario'];


				/* Mostramos el formulario de edición del usuario y damos a cada input el valor de las variables anteriores, para que se
																muestren en los campos los valores del usuario a editar. Damos al input ID el atributo readonly para que no se pueda editar */
				echo '<div class="contenedorFormulario">
		<h1>Editar usuario</h1>
		<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioUsuario">
        <div class="input_container">    
				ID: <input type="text" name="ID" value=' . $id . ' readonly><br><br>
                Nombre: <input type="text" name="nombre" value="' . $nombre . '"><br><br>
				Apellidos: <input type="text" name="apellidos" value="' . $apellidos . '"><br><br>
                Email: <input type="email" name="email" value=' . $email . '><br><br>
                Contraseña: <input type="password" name="contraseña" value=' . $contraseña . '><br><br>
                Fecha Nacimiento: <input type="date" name="fechaNacimiento" value="' . $fechaNacimiento . '"><br><br>
                Tipo Usuario: <input type="text" name="tipoUsuario" value=' . $tipoUsuario . '><br><br>
				</div>';

				// Creamos el input de tipo submit para enviar los datos cuando hayamos editado, y un enlace para volver a usuarios.php
				echo '<div class="button_container">
				<input type="submit" name="Editar" value="Editar" class="botones_formulario">
				<a href="usuarios.php" class="botones_formulario">Volver</a>
				</div>        
				</form>
				</div>';

				//Creamos la condición para comprobar si se ha recibido una solicitud de "añadir" por GET, y si es así, ejecuta el siguiente código
			} elseif (isset ($_GET["Anadir"])) {
				/* Mostramos el formulario para añadir un nuevo usuario. Damos al input ID el atributo disabled para que esté
																	deshabilitado y no se puedan añadir datos en ese campo */
				echo '<div class="contenedorFormulario">
				<h1>Añadir usuario</h1>
				<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioUsuario">
                <div class="input_container">
				ID: <input type="text" name="ID" disabled><br><br>
                Nombre: <input type="text" name="nombre" required><br><br>
				Apellidos: <input type="text" name="apellidos" required><br><br>
                Email: <input type="email" name="email" required><br><br>
                Contraseña: <input type="password" name="contraseña" required><br><br>
                Fecha Nacimiento: <input type="date" name="fechaNacimiento"><br><br>
                Tipo Usuario: <input type="text" name="tipoUsuario" required><br><br>
				</div>';

				// Creamos el input de tipo submit para enviar los datos cuando hayamos añadido el usuario, y un enlace para volver a usuarios.php
				echo '<div class="button_container">
				<input type="submit" name="Anadir" value="Añadir" class="botones_formulario"> <a href="usuarios.php" class="botones_formulario">Volver</a>
                </div>
				</form>
				</div>';
			}
		}
		// Opciones para el usuario tipo 0, que no tiene permisos para estar en esta página
		elseif ($tipoUsuario == 0) {
			echo '<h1>No tiene permisos para estar aqui</h1>
			<a href="index.php">Ir al inicio</a>';
		}


		// Procesamos los métodos post
	
		// Creamos la condición para comprobar si se han enviado los datos de "añadir" por POST, y si es así, ejecuta el siguiente código
	
		if (isset ($_POST["Anadir"])) {
			// Obtenemos los datos del formulario y los guardamos en variables
			$nombre = $_POST["nombre"];
			$apellidos = $_POST["apellidos"];
			$email = $_POST["email"];
			$contraseña = $_POST["contraseña"];
			//$fechaNacimiento = $_POST["fechaNacimiento"];
			$fechaNacimiento = !empty ($_POST["fechaNacimiento"]) ? $_POST["fechaNacimiento"] : null;
			$tipoUsuario = $_POST["tipoUsuario"];

			// Llamamos a la función añadirUsuario() pasándole como parámetros los valores recibidos del formulario
			$resultado = anadirUsuario($nombre, $apellidos, $email, $contraseña, $fechaNacimiento, $tipoUsuario);
			// Establecemos condición if que comprueba si se ha obtenido resultado de la función, y si es así, ejecuta el siguiente código
			if ($resultado) {
				// Mostramos el formulario de éxito y un mensaje de que se ha añadido el usuario
				echo '<div class="contenedorFormulario">
				<h1>Añadir usuario</h1>
				<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioUsuario">
                <div class="input_container">
				ID: <input type="text" name="ID" disabled><br><br>
                Nombre: <input type="text" name="nombre" value="' . $nombre . '" required><br><br>                
				Apellidos: <input type="text" name="apellidos" value="' . $apellidos . '" required><br><br>
                Email: <input type="email" name="email" value=' . $email . ' required><br><br>
                Contraseña: <input type="password" name="contraseña" value=' . $contraseña . ' required><br><br>
                Fecha Nacimiento: <input type="date" name="fechaNacimiento" value="' . ($fechaNacimiento ? $fechaNacimiento : null) . '"><br><br>
                Tipo Usuario: <input type="text" name="tipoUsuario" value=' . $tipoUsuario . ' required><br><br>
				</div>';


				// Cerramos el formulario de usuario añadido
				echo '<div class="button_container">
				<a href="usuarios.php" class="botones_formulario">Volver</a>
                <p class="mensajeExito">¡Usuario añadido!</p>
				</div>  
				</form>
				</div>';

				// En caso de que no se cumpla la condición anterior, mostramos un mensaje de error de que no se ha podido añadir el usuario
			} else {
				echo "<p>¡No se ha podido añadir el usuario!</p>";
			}

			// Creamos la condición para comprobar si se han enviado los datos de "editar" por POST, y si es así, ejecuta el siguiente código
		} elseif (isset ($_POST["Editar"])) {
			// Obtenemos los datos del formulario y los guardamos en variables
			$id = $_POST["ID"];
			$nombre = $_POST["nombre"];
			$apellidos = $_POST["apellidos"];
			$email = $_POST["email"];
			$contraseña = $_POST["contraseña"];
			$fechaNacimiento = $_POST["fechaNacimiento"];
			if (empty ($fechaNacimiento)) {
				$fechaNacimiento = null;
			}
			$tipoUsuario = $_POST["tipoUsuario"];

			// Llamamos a la función editarUsuario() pasándole como parámetros los valores recibidos del formulario
			$resultado = editarUsuario($id, $nombre, $apellidos, $email, $contraseña, $fechaNacimiento, $tipoUsuario);
			//Establecemos condición if que comprueba si se ha obtenido resultado de la función, y si es así, ejecuta el siguiente código
			if ($resultado) {
				// Mostramos el formulario de éxito y un mensaje de que se ha editado el usuario
				echo '<div class="contenedorFormulario">
				<h1>Editar usuario</h1>
				<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioUsuario">
				<div class="input_container">
                ID: <input type="text" name="ID" value=' . $id . ' readonly><br><br>
                Nombre: <input type="text" name="nombre" value="' . $nombre . '"><br><br>
				Apellidos: <input type="text" name="apellidos" value="' . $apellidos . '"><br><br>
                Email: <input type="email" name="email" value=' . $email . '><br><br>
                Contraseña: <input type="password" name="contraseña" value=' . $contraseña . '><br><br>
                Fecha Nacimiento: <input type="date" name="fechaNacimiento" value="' . $fechaNacimiento . '"><br><br>
                Tipo Usuario: <input type="text" name="tipoUsuario" value=' . $tipoUsuario . '><br><br>
				</div>';
				// Cerramos el formulario de usuario editado
				echo '<div class="button_container">
				<a href="usuarios.php" class="botones_formulario">Volver</a>
				<p class="mensajeExito">¡Usuario editado!</p>
				</div>
                </form>
				</div>';
				// En caso de que no se cumpla la condición anterior, mostramos un mensaje de error de que no se ha podido editar el usuario
			} else {
				echo "<p>¡No se ha podido editar el usuario!</p>";
			}
		}
	}
	// Opciones si no existe sesión iniciada y no se tienen permisos para estar en esta página
	else {
		echo '<h1>No tiene permisos para estar aquí</h1>
		<a href="index.php">Ir al inicio</a>';
	}
	?>

</body>

</html>