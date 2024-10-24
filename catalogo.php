<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <?php
    // Incluir el archivo de funciones
    include "funciones.php";

    // Verificar si el usuario ha iniciado sesión
    if (isset ($_SESSION['tipoUsuario'])) {
        // Guardar en variables los datos de sesión
        $tipoUsuario = $_SESSION['tipoUsuario'];
        $idUsuario = $_SESSION['ID_usuario'];
        // Configurar el menú y la tabla de productos según el tipo de usuario
        if ($tipoUsuario == 1) {
            // Usuario administrador
            $menu = "<div class='header'>
                        <img src='logo.png' alt='Logo corporativo' id='logo'>
                        <div class='menu'>
                            <a href='index.php'>Inicio</a>
                            <a href='catalogo.php'>Catálogo exclusivo</a>
                            <a href='pedidos.php'>Pedidos</a>
                            <a href='usuarios.php'>Usuarios</a>
                            <a href='logout.php'>Cerrar sesión</a>
                        </div>
                    </div>";

            // Construir la tabla de productos para el administrador
            $tablaProductos = "<a href='formularioProductos.php?Anadir' class='boton-anadir'>Añadir producto</a>
            <table>
                <tr>
                    <th><a href='catalogo.php?orden=ID_producto'>ID Producto</a></th>
                    <th><a href='catalogo.php?orden=nombre'>Nombre</a></th>
                    <th><a>Descripción</a></th>
                    <th><a href='catalogo.php?orden=coste'>Coste</a></th>
                    <th><a href='catalogo.php?orden=precio'>Precio</a></th>
                    <th><a>Exclusivo</a></th>
                    <th><a>Acciones</a></th>
                </tr>";

            if (!isset ($_GET["orden"])) {
                $orden = "ID_producto";
            } else {
                // En caso de que se reciba un parámetro "orden" por GET, establecer el orden según lo especificado
                $orden = $_GET["orden"];
            }
            // Obtener todos los productos, incluidos los exclusivos, del catálogo
            $productos = obtenerListaProductosExclusivos($orden);

            // Comprobar si hay productos
            if ($productos !== false) {
                // Iterar sobre los productos
                while ($fila = mysqli_fetch_assoc($productos)) {
                    // Guardar los valores en las variables
                    $idProducto = $fila['ID_producto'];
                    $nombre = $fila['nombre'];
                    $descripcion = $fila['descripcion'];
                    $coste = $fila['coste'];
                    $precio = $fila['precio'];
                    $exclusivo = $fila['exclusivo'];

                    // Imprimir una fila de la tabla con los valores obtenidos
                    $tablaProductos .= "<tr>";
                    $tablaProductos .= "<td>" . $idProducto . "</td>";
                    $tablaProductos .= "<td>" . $nombre . "</td>";
                    $tablaProductos .= "<td>" . $descripcion . "</td>";
                    $tablaProductos .= "<td>" . $coste . "</td>";
                    $tablaProductos .= "<td>" . $precio . "</td>";
                    $tablaProductos .= "<td>" . $exclusivo . "</td>";
                    $tablaProductos .= "<td><a href='formularioProductos.php?Editar=" . $fila['ID_producto'] . "' class='boton'>Editar</a> <button onclick='borrarProducto({$idProducto})' class='boton'>Borrar</button></td>";
                    $tablaProductos .= "</tr>";
                }
                $tablaProductos .= "</table>"; // Cerrar la tabla
            }
        } elseif ($tipoUsuario == 0) {
            // Usuario registrado
            $menu = "<div class='header'>
                        <img src='logo.png' alt='Logo corporativo' id='logo'>
                        <div class='menu'>
                            <a href='index.php'>Inicio</a>
                            <a href='catalogo.php'>Catálogo exclusivo</a>
                            <a href='pedidos.php'>Pedidos</a>
                            <a href='logout.php'>Cerrar sesión</a>
                        </div>
                    </div>";
            $tablaProductos = "
            <table>
                <tr>
                    <th><a href='catalogo.php?orden=ID_producto'>ID Producto</a></th>
                    <th><a href='catalogo.php?orden=nombre'>Nombre</a></th>
                    <th><a>Descripción</a></th>
                    <th><a href='catalogo.php?orden=coste'>Coste</a></th>
                    <th><a href='catalogo.php?orden=precio'>Precio</a></th>
                    <th><a>Solicitud</a></th>
                </tr>";

            if (!isset ($_GET["orden"])) {
                $orden = "ID_producto";
            } else {
                // En caso de que se reciba un parámetro "orden" por GET, establecer el orden según lo especificado
                $orden = $_GET["orden"];
            }
            // Obtener todos los productos, incluidos los exclusivos, del catálogo
            $productos = obtenerListaProductosExclusivos($orden);

            // Comprobar si hay productos
            if ($productos !== false) {
                // Iterar sobre los productos
                while ($fila = mysqli_fetch_assoc($productos)) {
                    // Guardar los valores en las variables
                    $idProducto = $fila['ID_producto'];
                    $nombre = $fila['nombre'];
                    $descripcion = $fila['descripcion'];
                    $coste = $fila['coste'];
                    $precio = $fila['precio'];

                    // Imprimir una fila de la tabla con los valores obtenidos
                    $tablaProductos .= "<tr>";
                    $tablaProductos .= "<td>" . $idProducto . "</td>";
                    $tablaProductos .= "<td>" . $nombre . "</td>";
                    $tablaProductos .= "<td>" . $descripcion . "</td>";
                    $tablaProductos .= "<td>" . $coste . "</td>";
                    $tablaProductos .= "<td>" . $precio . "</td>";
                    $tablaProductos .= "<td><a href='formularioPedidos.php?Solicitar&ID_producto=" . urlencode($idProducto) . "&ID_usuario=" . urlencode($idUsuario) . "&nombre=" . urlencode($nombre) . "&descripcion=" . urlencode($descripcion) . "&coste=" . urlencode($coste) . "&precio=" . urlencode($precio) . "' class='boton'>Solicitar</a>";
                    $tablaProductos .= "</tr>";
                }
                $tablaProductos .= "</table>"; // Cerrar la tabla
            }
        }
    } else {
        // Si no hay sesión iniciada, crear el menú de invitado
        $menu = "<div class='header'>
                    <img src='logo.png' alt='Logo corporativo' id='logo'>
                    <div class='menu'>
                        <a href='index.php'>Inicio</a>
                        <a href='catalogo.php'>Catálogo</a>
                        <a href='login.php'>Iniciar sesión</a>           
                    </div>
                </div>";
        $tablaProductos = "
        <table>
            <tr>
                <th><a href='catalogo.php?orden=ID_producto'>ID Producto</a></th>
                <th><a href='catalogo.php?orden=nombre'>Nombre</a></th>
                <th><a>Descripción</a></th>
                <th><a href='catalogo.php?orden=coste'>Coste</a></th>
                <th><a href='catalogo.php?orden=precio'>Precio</a></th>
            </tr>";

        if (!isset ($_GET["orden"])) {
            $orden = "ID_producto";
        } else {
            // En caso de que se reciba un parámetro "orden" por GET, establecer el orden según lo especificado
            $orden = $_GET["orden"];
        }
        // Obtener los productos no exclusivos del catálogo
        $productos = obtenerListaProductos($orden);

        // Comprobar si hay productos
        if ($productos !== false) {
            // Iterar sobre los productos
            while ($fila = mysqli_fetch_assoc($productos)) {
                // Guardar los valores en las variables
                $idProducto = $fila['ID_producto'];
                $nombre = $fila['nombre'];
                $descripcion = $fila['descripcion'];
                $coste = $fila['coste'];
                $precio = $fila['precio'];

                // Imprimir una fila de la tabla con los valores obtenidos
                $tablaProductos .= "<tr>";
                $tablaProductos .= "<td>" . $idProducto . "</td>";
                $tablaProductos .= "<td>" . $nombre . "</td>";
                $tablaProductos .= "<td>" . $descripcion . "</td>";
                $tablaProductos .= "<td>" . $coste . "</td>";
                $tablaProductos .= "<td>" . $precio . "</td>";
                $tablaProductos .= "</tr>";
            }
            $tablaProductos .= "</table>"; // Cerrar la tabla
        }
    }
    ?>

    <!-- Bloque script donde definimos las funciones que son llamadas desde los botones de borrar, enviar, rechazar o cancelar 
y que mostrarán las diferentes ventanas emergentes-->
    <script>
        // Función para borrar el producto que muestra la ventana emergente y envía los datos al archivo funciones.php
        function borrarProducto(idProducto) {
            if (confirm("¿Estás seguro de que quieres borrar este producto?")) {
                // Realizar solicitud AJAX para borrar el producto enviando los datos al archivo funciones.php
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idProducto_borrar=" + idProducto
                })
                    // Si la respuesta es correcta, mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El producto ha sido borrado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al borrar el producto");
                        }
                    })
                    // Si es errónea, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al borrar el producto");
                    });
            }
        }
    </script>
    <!-- Imprimimos el menú y la tabla correspondiente según el tipo de usuario que tenga sesión iniciada-->
    <?php echo $menu; ?>
    <?php echo $tablaProductos; ?>

</body>

</html>