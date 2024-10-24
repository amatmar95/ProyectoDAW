<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css">
	<title>Formulario de productos</title>
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
                        <a href='catalogo.php'>Catálogo exclusivo</a>
						<a href='pedidos.php'>Pedidos</a>
                        <a href='usuarios.php'>Usuarios</a>
                        <a href='logout.php'>Cerrar sesión</a>
                </div>
				</div>";

			// Creamos una condición que comprueba si se ha recibido una solicitud de "editar" por GET, y si es así, ejecuta el siguiente código
			if (isset ($_GET["Editar"])) {
				// Obtenemos el id del producto a editar
				$id = $_GET["Editar"];
				// Llamamos a la función obtenerProducto($id) con ese id
				$producto = obtenerProducto($id);
				// Creamos una variable y recorremos el resultado obtenido de llamar a la función
				$fila = mysqli_fetch_assoc($producto);
				// Creamos las variables y les damos los valores recibidos del producto que hemos solicitado
				$nombre = $fila['nombre'];
				$descripcion = $fila['descripcion'];
				$coste = $fila['coste'];
				$precio = $fila['precio'];
				$exclusivo = $fila['exclusivo'];

				/* Mostramos el formulario de edición del producto y damos a cada input el valor de las variables anteriores, para que se
																			muestren en los campos los valores del producto a editar. Damos al input ID el atributo readonly para que no se pueda editar */
				echo '<div class="contenedorFormulario">
		<h1>Editar producto</h1>
		<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioProducto">
        <div class="input_container">  
		ID: <input type="text" name="ID" value=' . $id . ' readonly><br><br>
                Nombre: <input type="text" name="nombre" value=' . $nombre . '><br><br>
				Descripción: <input type="text" name="descripcion" value=' . $descripcion . '><br><br>
                Coste: <input type="text" name="coste" value=' . $coste . '><br><br>
                Precio: <input type="text" name="precio" value=' . $precio . '><br><br>
				Exclusivo: <input type="text" name="exclusivo" value=' . $exclusivo . '><br><br>
				</div>';

				// Creamos el input de tipo submit para enviar los datos cuando hayamos editado, y un enlace para volver a catalogo.php
				echo '<div class="button_container">
		<input type="submit" name="Editar" value="Editar" class="botones_formulario">
		<a href="catalogo.php" class="botones_formulario">Volver</a>
		</div>
        </form>
		</div>';

				//Creamos la condición para comprobar si se ha recibido una solicitud de "añadir" por GET, y si es así, ejecuta el siguiente código
			} elseif (isset ($_GET["Anadir"])) {
				/* Mostramos el formulario para añadir un nuevo producto. Damos al input ID el atributo disabled para que esté
																				deshabilitado y no se puedan añadir datos en ese campo. Damos a los inputs Coste y Precio valor 0 de inicio */
				echo '<div class="contenedorFormulario">
		<h1>Añadir producto</h1>
		<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioProducto">
        <div class="input_container">  
		ID: <input type="text" name="ID" disabled><br><br>
                Nombre: <input type="text" name="nombre" required><br><br>
				Descripcion: <input type="text" name="descripcion" required><br><br>
                Coste: <input type="text" name="coste" value="0" required><br><br>
                Precio: <input type="text" name="precio" value="0" required><br><br>
				Exclusivo: <input type="text" name="exclusivo" required><br><br>
				</div>';

				// Creamos el input de tipo submit para enviar los datos cuando hayamos añadido el producto, y un enlace para volver a catalogo.php
				echo '<div class="button_container">
		<input type="submit" name="Anadir" value="Añadir" class="botones_formulario">
		<a href="catalogo.php" class="botones_formulario">Volver</a>
		</div>
        </form>
		</div>';
			}

		}
		// Opción si el usuario es tipo 0 y no tiene permisos aquí
		elseif ($tipoUsuario == 0) {
			echo '<h1>No tiene permisos para estar aqui</h1>
	<a href="index.php">Ir al inicio</a>';
		}


		// Procesamos los métodos post
	
		// Creamos la condición para comprobar si se han enviado los datos de "añadir" por POST, y si es así, ejecuta el siguiente código
	
		if (isset ($_POST["Anadir"])) {
			// Obtenemos los datos del formulario y los guardamos en variables
			$nombre = $_POST["nombre"];
			$descripcion = $_POST["descripcion"];
			$coste = $_POST["coste"];
			$precio = $_POST["precio"];
			$exclusivo = $_POST["exclusivo"];

			// Llamamos a la función añadirProducto() pasándole como parámetros los valores recibidos del formulario
			$resultado = anadirProducto($nombre, $descripcion, $coste, $precio, $exclusivo);
			// Establecemos condición if que comprueba si se ha obtenido resultado de la función, y si es así, ejecuta el siguiente código
			if ($resultado) {
				// Mostramos el formulario de éxito y un mensaje de que se ha añadido el producto
				echo '<div class="contenedorFormulario">
		<h1>Añadir producto</h1>
		<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioProducto">
        <div class="input_container">  
		ID: <input type="text" name="ID" disabled><br><br>
                Nombre: <input type="text" name="nombre" value=' . $nombre . ' required><br><br>
				Descripcion: <input type="text" name="descripcion" value=' . $descripcion . ' required><br><br>
                Coste: <input type="text" name="coste" value=' . $coste . ' required><br><br>
                Precio: <input type="text" name="precio" value=' . $precio . ' required><br><br>
				Exclusivo: <input type="text" name="exclusivo" value=' . $exclusivo . ' required><br><br>
				</div>';

				// Cerramos el formulario de producto añadido
				echo '<div class="button_container">
		<a href="catalogo.php" class="botones_formulario">Volver</a>
		<p class="mensajeExito">¡Producto añadido!</p>
		</div>  
        </form>
		</div>';

				// En caso de que no se cumpla la condición anterior, mostramos un mensaje de error de que no se ha podido añadir el producto
			} else {
				echo "<p>¡No se ha podido añadir el producto!</p>";
			}

			// Creamos la condición para comprobar si se han enviado los datos de "editar" por POST, y si es así, ejecuta el siguiente código
		} elseif (isset ($_POST["Editar"])) {
			// Obtenemos los datos del formulario y los guardamos en variables
			$id = $_POST["ID"];
			$nombre = $_POST["nombre"];
			$descripcion = $_POST["descripcion"];
			$coste = $_POST["coste"];
			$precio = $_POST["precio"];
			$exclusivo = $_POST["exclusivo"];

			// Llamamos a la función editarProducto() pasándole como parámetros los valores recibidos del formulario
			$resultado = editarProducto($id, $nombre, $descripcion, $coste, $precio, $exclusivo);
			//Establecemos condición if que comprueba si se ha obtenido resultado de la función, y si es así, ejecuta el siguiente código
			if ($resultado) {
				// Mostramos el formulario de éxito y un mensaje de que se ha editado el producto
				echo '<div class="contenedorFormulario">
		<h1>Editar producto</h1>
		<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" class="formularioProducto">
        <div class="input_container">        
		ID: <input type="text" name="ID" value=' . $id . ' readonly><br><br>
                Nombre: <input type="text" name="nombre" value=' . $nombre . '><br><br>
				Descripcion: <input type="text" name="descripcion" value=' . $descripcion . '><br><br>
                Coste: <input type="text" name="coste" value=' . $coste . '><br><br>
				Precio: <input type="text" name="precio" value=' . $precio . '><br><br>
				Exclusivo: <input type="text" name="exclusivo" value=' . $exclusivo . '><br><br>
				</div>';
				// Cerramos el formulario de producto editado
				echo '<div class="button_container">
		<a href="catalogo.php" class="botones_formulario">Volver</a>
		<p class="mensajeExito">¡Producto editado!</p>
		</div>  
        </form>
		</div>';
				// En caso de que no se cumpla la condición anterior, mostramos un mensaje de error de que no se ha podido editar el producto
			} else {
				echo "<p>¡No se ha podido editar el producto!</p>";
			}
		}
	}
	// Opciones en caso de que no haya sesión iniciada y no tenga permisos para estar aquí 
	else {
		echo '<h1>No tiene permisos para estar aqui</h1>
	<a href="index.php">Ir al inicio</a>';
	}
	?>

</body>

</html>