<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Iniciar sesión</title>
	<link rel="stylesheet" href="estilos.css">
</head>

<body>

	<?php
	// Verificar si el usuario ha iniciado sesión
	if (isset ($_SESSION['tipoUsuario'])) {
		// Guardar en variables los datos de la sesión
		$tipoUsuario = $_SESSION['tipoUsuario'];
		$nombreUsuario = $_SESSION['nombre'];
		// Configurar el menú según el tipo de usuario
		if ($tipoUsuario == 1) {
			// Usuario administrador
			$menu = "<div class='header'>
								<img src='logo.png' alt='Logo corporativo' id='logo'>
								<div class='menu'>
									<a href='index.php'>Inicio</a>
									<a href='catalogo.php'>Catálogo exclusivo</a>
									<a href='usuarios.php'>Usuarios</a>
									<a href='logout.php'>Cerrar sesión</a>
								</div>
							</div>";
		} elseif ($tipoUsuario == 0) {
			// Usuario registrado
			$menu = "<div class='header'>
								<img src='logo.png' alt='Logo corporativo' id='logo'>
								<div class='menu'>
									<a href='index.php'>Inicio</a>
									<a href='catalogo.php'>Catálogo exclusivo</a>
									<a href='formularioPedidos.php'>Pedidos</a>
									<a href='logout.php'>Cerrar sesión</a>
								</div>
							</div>";
		}
	} else {
		// Si no hay sesión iniciada, mostrar el menú de invitado
		$menu = "<div class='header'>
                			<img src='logo.png' alt='Logo corporativo' id='logo'>
							<div class='menu'>
								<a href='index.php'>Inicio</a>
								<a href='catalogo.php'>Catálogo</a>
								<a href='login.php'>Iniciar sesión</a>           
							</div>
						</div>";
	}
	?>

	<!-- Imprimimos el menú correspondiente -->
	<?php echo $menu; ?>

	<!-- Creamos el div para el titulo y el formulario -->
	<div id="formularioLogin">
		<h1>Iniciar sesión</h1>
		<!-- Creamos el formulario de inicio de sesión -->

		<!-- Establecemos action="procesoLogin.php" para enviarlo al archivo que procesa los datos y las sesiones y un método post para el envío -->
		<form action="procesoLogin.php" method="post" class=formulario>
			<!-- Creamos un div contenedor para los inputs -->
			<div class="input_container">
				<!-- Creamos el input para introducir el email -->
				<label for="email">Email:</label>
				<br>
				<input type="email" name="email" id="email" placeholder="Email:">

				<br>
				<br>
				<!-- Creamos el input para introducir la contraseña -->
				<label for="contraseña">Contraseña:</label>
				<br>
				<input type="password" name="contraseña" id="contraseña" placeholder="Contraseña:">
			</div>
			<br>

			<!-- Creamos eun div contenedor para los botones -->
			<div class="button_container">
				<!-- Creamos el input tipo submit para hacer el envío, y un a con estilo de botón para ir al formulario de registro -->
				<input type="submit" value="Iniciar sesión" name="iniciarSesion" class="botones_formulario" />
				<a href="registro.php?Registrar" value="Registrarse" class="botones_formulario"
					id="boton_registrarse">Registrarse </a>
			</div>

		</form>

	</div>

	<?php
	// Comprobamos si hay un mensaje de error en la sesión y lo mostramos
	session_start();
	if (isset ($_SESSION['error_login'])) {
		echo "<p id='mensajeError'>{$_SESSION['error_login']}</p>";
		unset($_SESSION['error_login']); // Limpiar el mensaje de error después de mostrarlo
	}
	?>
</body>

</html>