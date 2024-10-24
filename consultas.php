<?php

// Incluimos el archivo de conexión a la base de datos para poder hacer referencias desde este
include "conexion.php";

// Creamos la función que nos va a devolver el tipo de usuario pasándole el email y contraseña del mismo
function tipoUsuario($email, $contraseña)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();

	/* Creamos variable con la consulta donde solicitamos todos los campos de la tabla usuarios
	   del usuario que tenga como email y contraseña las variables pasadas como parámetros */
	$sql = "SELECT * FROM usuarios WHERE email = '$email' and contraseña = '$contraseña' ";

	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
	   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);

	// Establecemos la condición de que si tenemos más de 0 filas, es decir, tenemos datos, ejecute el código
	if (mysqli_num_rows($result) > 0) {
		// Obtener la fila de datos del usuario
		$comprobarUsuario = mysqli_fetch_assoc($result);
		// Devolver toda la fila de datos del usuario
		return $comprobarUsuario;
	} else {
		// Si no hay ningún usuario con esas credenciales, devolver false
		return false;
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener la lista de usuarios
function obtenerListaUsuarios()
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	// Creamos variable con la consulta donde solicitamos todas las columnas de la tabla usuarios
	$sql = "SELECT * FROM usuarios";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
		   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		// En caso contrario, mostramos un mensaje de que no hay nada en la lista de usuarios
	} else {
		echo "No hay nada en la lista de usuarios.";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener todos los datos de un producto por su ID
function obtenerProducto($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos todas las columnas de la tabla productos donde el ID_producto
		  sea igual al id que le hemos pasado como parámetro */
	$sql = "SELECT * FROM productos WHERE ID_producto = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no existe ningún producto con ese ID
	} else {
		echo "No hay ningún producto con ese ID";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener la lista de productos ordenados por el criterio que le pasemos como parámetro
function obtenerListaProductos($orden)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos todas las columnas de la tabla productos donde la columna exclusivo sea 'no',
		  y lo ordene por el criterio que le pasamos */
	$sql = "SELECT * FROM productos WHERE exclusivo = 'no' ORDER BY $orden ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
		   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no se han podido encontrar productos
	} else {
		echo "No se han podido encontrar productos ";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para añadir un producto a la tabla productos
function anadirProducto($nombre, $descripcion, $coste, $precio, $exclusivo)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que incluya nuevos valores en las columnas correspondientes de la tabla productos,
	y le damos como valores las variables pasadas como parámetros */
	$sql = "INSERT INTO productos (nombre, descripcion, coste, precio,exclusivo) VALUES ('$nombre','$descripcion',$coste,$precio,'$exclusivo') ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para editar un producto
function editarProducto($id, $nombre, $descripcion, $coste, $precio, $exclusivo)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde, mediante UPDATE, actualizamos los datos del producto donde el ID_producto sea
		  igual al id que pasamos como parámetro. Utilizamos SET para establecer como valores de las columnas las diferentes
		  variables pasadas por parámetros  */
	$sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', coste = $coste, precio = $precio, exclusivo = '$exclusivo' WHERE ID_producto = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
		   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}


// Creamos la función para borrar un producto por su id
function borrarProducto($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que se borre todo el producto donde el ID_producto sea igual al id
		  que pasamos como parámetro */
	$sql = "DELETE FROM productos WHERE ID_producto = $id ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener todos los datos de un usuario por su id
function obtenerUsuario($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos todas las columnas de la tabla usuarios donde el ID_usuario
		  sea igual al id que le hemos pasado como parámetro */
	$sql = "SELECT * FROM usuarios WHERE ID_usuario = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no existe ningún usuario con ese ID
	} else {
		echo "No hay ningún usuario con ese ID";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para añadir un usuario a la tabla usuarios, pero desde el perfil de administrador, ya que le pasamos también el tipo de usuario
function anadirUsuario($nombre, $apellidos, $email, $contraseña, $fechaNacimiento, $tipoUsuario)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que incluya nuevos valores en las columnas correspondientes de la tabla usuarios,
	y le damos como valores las variables pasadas como parámetros */
	$sql = "INSERT INTO usuarios (nombre, apellidos, email, contraseña, fechaNacimiento, tipoUsuario) VALUES ('$nombre','$apellidos', '$email', '$contraseña', '$fechaNacimiento', $tipoUsuario) ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función que añade un usuario a la tabla usuarios cuando el usuario se registra, estableciendo tipoUsuario como 0 por defecto
function registrarUsuario($nombre, $apellidos, $email, $contraseña, $fechaNacimiento)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que incluya nuevos valores en las columnas correspondientes de la tabla usuarios,
	y le damos como valores las variables pasadas como parámetros, y a la columna tipousuario, valor por defecto 0 */
	$sql = "INSERT INTO usuarios (nombre, apellidos, email, contraseña, fechaNacimiento, tipoUsuario) VALUES ('$nombre','$apellidos', '$email', '$contraseña', '$fechaNacimiento', '0') ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para editar un usuario
function editarUsuario($id, $nombre, $apellidos, $email, $contraseña, $fechaNacimiento, $tipoUsuario)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde, mediante UPDATE, actualizamos los datos del usuario donde el ID_usuario sea
		  igual al id que pasamos como parámetro. Utilizamos SET para establecer como valores de las columnas las diferentes
		  variables pasadas por parámetros  */
	$sql = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', email = '$email', contraseña = '$contraseña', fechaNacimiento = '$fechaNacimiento', tipoUsuario = $tipoUsuario WHERE ID_usuario = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
		   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para borrar un usuario por su ID
function borrarUsuario($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que se borre todo el usuario donde el ID_usuario sea igual al id
		  que pasamos como parámetro */
	$sql = "DELETE FROM usuarios WHERE ID_usuario = $id ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
			  y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener la lista de productos, incluidos los exclusivos, ordenados por el criterio que le pasemos como parámetro
function obtenerListaProductosExclusivos($orden)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos todas las columnas de la tabla productos
		  y lo ordene por el criterio que le pasamos como parámetro*/
	$sql = "SELECT * FROM productos ORDER BY $orden";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
				 y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no se han podido encontrar productos
	} else {
		echo "No se han podido encontrar productos exclusivos";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener todos los datos de un pedido por su id
function obtenerPedido($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos todas las columnas de la tabla pedidos donde el ID_pedido
				sea igual al id que le hemos pasado como parámetro */
	$sql = "SELECT * FROM pedidos WHERE ID_pedido = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
					y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no existe ningún producto con ese ID
	} else {
		echo "No hay ningún pedido con ese ID";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para añadir un pedido a la tabla pedidos cuando el usuario completa el formulario de solicitar productos
function anadirPedido($idUsuarioPedido, $idProducto, $nombre, $descripcion, $cantidad)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que incluya nuevos valores en las columnas correspondientes de la
		  tabla pedidos, y le damos como valores las variables pasadas como parámetros */
	$sql = "INSERT INTO pedidos (ID_usuariopedido, ID_productopedido, nombre, descripcion, cantidad, estado) VALUES ($idUsuarioPedido, $idProducto, '$nombre','$descripcion', $cantidad, 'Pendiente') ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
					y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función que marca el estado del pedido como enviado cuando el administrador pulsa "enviar" en los pedidos
function marcarEstadoEnviado($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde, mediante UPDATE, actualizamos los datos del pedido donde el ID_pedido sea
				igual al id que pasamos como parámetro. Utilizamos SET para establecer como valores de las columnas los nuevos valores */
	$sql = "UPDATE pedidos SET estado = 'Enviado' WHERE ID_pedido = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
				 y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función que marca el estado del pedido como cancelado cuando el administrador pulsa "rechazar" en los pedidos
function marcarEstadoCancelado($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde, mediante UPDATE, actualizamos los datos del pedido donde el ID_pedido sea
				igual al id que pasamos como parámetro. Utilizamos SET para establecer como valores de las columnas los nuevos valores */
	$sql = "UPDATE pedidos SET estado = 'Cancelado' WHERE ID_pedido = $id";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
				 y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para borrar un pedido por su ID
function borrarPedido($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	/* Creamos variable con la consulta donde solicitamos que se borre todo el pedido donde el ID_pedido sea igual al id
				que pasamos como parámetro */
	$sql = "DELETE FROM pedidos WHERE ID_pedido = $id ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
					y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Devolvemos el resultado
	return $result;
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener la lista de todos los pedidos, para el perfil de administrador
function obtenerListaPedidos()
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	// Creamos variable con la consulta donde solicitamos todas las columnas de la tabla pedidos
	$sql = "SELECT * FROM pedidos";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
				 y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no se han podido encontrar pedidos
	} else {
		echo "No se han podido encontrar pedidos ";
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}

// Creamos la función para obtener la lista de pedidos por el id de usuario, para mostrar en el perfil de cada usuario solo sus pedidos
function obtenerListaPedidosPorId($id)
{
	// Creamos la conexión a la base de datos
	$DB = crearConexion();
	// Creamos variable con la consulta donde solicitamos todas las columnas de la tabla pedidos donde el id sea el que le pasamos como parámetro
	$sql = "SELECT * FROM pedidos WHERE ID_usuariopedido = $id ";
	/* Guardamos en una variable el resultado de la consulta que lanzaremos mediante mysqli_query, pasándole la conexión
		   y la consulta como parámetros */
	$result = mysqli_query($DB, $sql);
	// Establecemos la condición de que si tenemos mas de 0 filas, es decir, tenemos datos, devuelva el resultado
	if (mysqli_num_rows($result) > 0) {
		return $result;
		//En caso contrario, mostramos un mensaje de que no se han podido encontrar pedidos
	} else {
		echo "No se han podido encontrar pedidos ";
		return false;
	}
	// Cerramos la conexión a la base de datos
	cerrarConexion($DB);
}
?>