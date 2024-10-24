<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css">
	<title>Formulario de pedidos</title>
</head>

<body>

	<?php
	include "funciones.php";

	// Verificar si el usuario ha iniciado sesión
	if (isset ($_SESSION['tipoUsuario'])) {
		$tipoUsuario = $_SESSION['tipoUsuario'];
		$idUsuarioPedido = $_SESSION['ID_usuario'];
		// Creamos condición para comprobar el tipo de usuario
		// En caso de que sea tipoUsuario 0
		if ($tipoUsuario == 0) {

			//Creamos la condición para comprobar si se ha recibido una solicitud de "solicitar" por GET, y si es así, ejecuta el siguiente código
			if (isset ($_GET["Solicitar"])) {
				$idProducto = $_GET['ID_producto'];
				$nombre = $_GET['nombre'];
				$descripcion = $_GET['descripcion'];
				$coste = $_GET['coste'];
				$precio = $_GET['precio'];

				/* Mostramos el formulario para solicitar un nuevo producto. Damos al input ID el atributo disabled para que esté
											   deshabilitado y no se puedan añadir datos en ese campo. Damos a los inputs Coste y Precio valor 0 de inicio */
				echo '<div class="contenedorFormulario">
			<h1>Solicitar producto</h1>
			<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" id="formularioPedido">
			<div class="input_container">  
				ID producto: <input type="text" name="ID_producto" value="' . $idProducto . '" readonly><br><br>
						Nombre: <input type="text" name="nombre" value="' . $nombre . '" readonly><br><br>
						Descripcion: <input type="text" name="descripcion" value="' . $descripcion . '" readonly><br><br>
						Coste: <input type="text" name="coste" value="' . $coste . '" readonly><br><br>
						Precio: <input type="text" name="precio" value="' . $precio . '" readonly><br><br>
						Cantidad: <input type="text" name="cantidad" value="1" required><br><br>
						</div>';

				// Creamos el input de tipo submit para enviar los datos cuando hayamos solicitado el producto, y un enlace para volver a catalogo.php
				echo '<div class="button_container">
			<input type="submit" name="Solicitar" value="Solicitar" class="botones_formulario"> <a href="catalogo.php" class="botones_formulario">Volver</a>
			</div>
			</form>
			</div>';
			}
		}
		//En caso de que sea tipoUsuario 1 
		elseif ($tipoUsuario == 1) {
			echo '<h1>Para ver los pedidos vaya al apartado Pedidos</h1>
		<a href="pedidos.php">Ir a pedidos</a>';
		}
		// Procesamos los métodos post
	
		// Creamos la condición para comprobar si se han enviado los datos de "solicitar" por POST, y si es así, ejecuta el siguiente código
	
		if (isset ($_POST["Solicitar"])) {
			// Obtenemos los datos del formulario y los guardamos en variables
			$idUsuarioPedido = $_SESSION['ID_usuario'];
			$idProducto = $_POST["ID_producto"];
			$nombre = $_POST["nombre"];
			$descripcion = $_POST["descripcion"];
			$coste = $_POST["coste"];
			$precio = $_POST["precio"];
			$cantidad = $_POST["cantidad"];

			// Llamamos a la función añadirPedido() pasándole como parámetros los valores recibidos del formulario
			$resultado = anadirPedido($idUsuarioPedido, $idProducto, $nombre, $descripcion, $cantidad);
			// Establecemos condición if que comprueba si se ha obtenido resultado de la función, y si es así, ejecuta el siguiente código
			if ($resultado) {
				// Mostramos el formulario de éxito y un mensaje de que se ha solicitado el producto
				echo '<div class="contenedorFormulario">
			<h1>Solicitar producto</h1>
			<form action="' . $_SERVER["PHP_SELF"] . '" method="POST" id="formularioPedido">
			<div class="input_container">    
				ID producto: <input type="text" name="ID_producto" value=' . $idProducto . ' disabled><br><br>
						Nombre: <input type="text" name="nombre" value=' . $nombre . ' readonly><br><br>
						Descripcion: <input type="text" name="descripcion" value=' . $descripcion . ' readonly><br><br>
						Coste: <input type="text" name="coste" value=' . $coste . ' readonly><br><br>
						Precio: <input type="text" name="precio" value=' . $precio . ' readonly><br><br>
						Cantidad: <input type="text" name="cantidad" value=' . $cantidad . ' readonly><br><br>
						</div>';


				// Cerramos el formulario de producto solicitado
				echo '<div class="button_container">
			<a href="catalogo.php" class="botones_formulario">Volver</a>
			<p class="mensajeExito">¡Producto solicitado!</p>
			</div>  
			</form>
			</div>';


				// En caso de que no se cumpla la condición anterior, mostramos un mensaje de error de que no se ha podido añadir el producto
			} else {
				echo "<p>¡No se ha podido solicitar el producto!</p>";
			}

			// Creamos la condición para comprobar si se han enviado los datos de "editar" por POST, y si es así, ejecuta el siguiente código
		}
	} else {
		echo '<h1>No tiene permisos para estar aqui</h1>
	<a href="index.php">Ir al inicio</a>';
	}
	?>
</body>

</html>