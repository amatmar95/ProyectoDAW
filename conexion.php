<?php

// Definimos la función que creará la conexión con la base de datos
function crearConexion()
{
	/* Definimos las variables que pasaremos como parámetros a la función para hacer la conexión. Establecemos el host,
			 el usuario, una contraseña(si la hubiera) y la base de datos con la que queremos hacer la conexión */
	$host = "localhost";
	$user = "root";
	$pass = "";
	$baseDatos = "proyectodaw_joyeriajomat";

	// Establecemos la conexión con la base de datos mediante mysqli_connect() y lo guardamos en una variable
	$conexion = mysqli_connect($host, $user, $pass, $baseDatos);

	// Si hay un error en la conexión, lo mostramos y detenemos la misma
	if (!$conexion) {
		die ("<br>Error de conexión con la base de datos: " . mysqli_connect_error());
	}
	// Si esta todo correcto, devolvemos el resultado de la conexión con la base de datos.
	else {
		return $conexion;
	}
}

// Definimos la función que cerrará la conexión con la base de datos
function cerrarConexion($conexion)
{
	// Cerramos la conexión mediante mysqli_close y pasamos como parámetro la conexión que queremos que cierre
	mysqli_close($conexion);
}


?>