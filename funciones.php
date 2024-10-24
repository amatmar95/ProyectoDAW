<?php
// Establecer conexión a la base de datos
include_once 'consultas.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset ($_SESSION['tipoUsuario'])) {
	$tipoUsuario = $_SESSION['tipoUsuario'];
	$idUsuario = $_SESSION['ID_usuario'];
	// Comprobar el tipo de usuario y sus opciones
	if ($tipoUsuario == 1) {

		// Verificar si se ha recibido el ID del pedido desde borrar
		if (isset ($_POST['idPedido_borrar'])) {
			// Obtener el ID del pedido enviado desde el cliente
			$idPedido = $_POST['idPedido_borrar'];

			// Intentar eliminar el pedido
			if (borrarPedido($idPedido)) {
				// No es necesario enviar ningún mensaje si la eliminación es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		}
		// Verificar si se ha recibido el ID del pedido desde enviar
		elseif (isset ($_POST['idPedido_enviar'])) {
			$idPedido = $_POST['idPedido_enviar'];
			// Intentar cambiar el estado del pedido a enviado
			if (marcarEstadoEnviado($idPedido)) {
				// No es necesario enviar ningún mensaje si la acción es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		}
		// Verificar si se ha recibido el ID del pedido desde rechazar
		elseif (isset ($_POST['idPedido_rechazar'])) {
			$idPedido = $_POST['idPedido_rechazar'];
			// Intentar cambiar el estado del pedido a cancelado
			if (marcarEstadoCancelado($idPedido)) {
				// No es necesario enviar ningún mensaje si la acción es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		}
		// Verificar si se ha recibido el ID del usuario desde borrar
		elseif (isset ($_POST['idUsuario_borrar'])) {
			// Obtener el ID del usuario enviado desde el cliente
			$idUsuario = $_POST['idUsuario_borrar'];

			// Intentar eliminar el usuario
			if (borrarUsuario($idUsuario)) {
				// No es necesario enviar ningún mensaje si la eliminación es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		}
		// Verificar si se ha recibido el ID del producto desde borrar
		elseif (isset ($_POST['idProducto_borrar'])) {
			// Obtener el ID del producto enviado desde el cliente
			$idProducto = $_POST['idProducto_borrar'];

			// Intentar eliminar el producto
			if (borrarProducto($idProducto)) {
				// No es necesario enviar ningún mensaje si la eliminación es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		} else {
			http_response_code(400); // Establecer código de respuesta HTTP 400 (Solicitud incorrecta)
		}
	}
	// En caso de que el usuarios sea tipo 0
	elseif ($tipoUsuario == 0) {
		// Verificar si se ha recibido el ID del pedido desde cancelar
		if (isset ($_POST['idPedido_cancelar'])) {
			// Obtener el ID del pedido enviado desde el cliente
			$idPedido = $_POST['idPedido_cancelar'];

			// Intentar eliminar el pedido
			if (borrarPedido($idPedido)) {
				// No es necesario enviar ningún mensaje si la eliminación es exitosa
			} else {
				http_response_code(500); // Establecer código de respuesta HTTP 500 (Error interno del servidor)
			}
		} else {
			http_response_code(400); // Establecer código de respuesta HTTP 400 (Solicitud incorrecta)
		}
	}
}
?>