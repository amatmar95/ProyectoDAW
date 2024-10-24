<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <?php
    include "funciones.php";

    // Verificar si el usuario ha iniciado sesión
    if (isset ($_SESSION['tipoUsuario'])) {
        // Guardar en variables los datos de la sesión
        $tipoUsuario = $_SESSION['tipoUsuario'];
        $idUsuario = $_SESSION['ID_usuario'];
        // Configurar el menú y la tabla de pedidos según el tipo de usuario
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

            // Construimos la tabla de pedidos
            $tablaPedidos = "
            <table>
                <tr>
                    <th>ID Pedido</th>
                    <th>ID Usuario</th>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Solicitud</th>
                </tr>";

            // Obtenemos la lista de todos los pedidos
            $pedidos = obtenerListaPedidos();

            // Comprobamos si hay pedidos
            if ($pedidos !== false) {
                // Iteramos sobre los pedidos
                while ($fila = mysqli_fetch_assoc($pedidos)) {
                    // Guardamos los valores en las variables
                    $idPedido = $fila['ID_pedido'];
                    $idUsuario = $fila['ID_usuariopedido'];
                    $idProducto = $fila['ID_productopedido'];
                    $nombre = $fila['nombre'];
                    $descripcion = $fila['descripcion'];
                    $cantidad = $fila['cantidad'];
                    $estado = $fila['estado'];

                    // Imprimimos una fila de la tabla con los valores obtenidos
                    $tablaPedidos .= "<tr>";
                    $tablaPedidos .= "<td>" . $idPedido . "</td>";
                    $tablaPedidos .= "<td>" . $idUsuario . "</td>";
                    $tablaPedidos .= "<td>" . $idProducto . "</td>";
                    $tablaPedidos .= "<td>" . $nombre . "</td>";
                    $tablaPedidos .= "<td>" . $descripcion . "</td>";
                    $tablaPedidos .= "<td>" . $cantidad . "</td>";
                    $tablaPedidos .= "<td>" . $estado . "</td>";
                    if ($estado == 'Pendiente') {
                        $tablaPedidos .= "<td><button onclick='enviarPedido({$idPedido})' class='boton'>Enviar</button> <button onclick='rechazarPedido({$idPedido})' class='boton'>Rechazar</button></td>";
                    } else {
                        $tablaPedidos .= "<td><button onclick='borrarPedido({$idPedido})' class='boton'>Borrar</button></td>";
                    }
                    $tablaPedidos .= "</tr>";
                }
                $tablaPedidos .= "</table>"; // Cierra la tabla
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
            $tablaPedidos = "
            <table>
                <tr>
                    <th>ID Pedido</th>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Cancelar</th>
                </tr>";

            // Obtenemos la lista de pedidos por el ID del usuario para mostrar solo los suyos
            $pedidos = obtenerListaPedidosPorId($idUsuario);
            // Comprobamos si hay pedidos
            if ($pedidos !== false) {
                // Iteramos sobre los pedidos
                while ($fila = mysqli_fetch_assoc($pedidos)) {
                    // Guardamos los valores en las variables
                    $idPedido = $fila['ID_pedido'];
                    $idProducto = $fila['ID_productopedido'];
                    $nombre = $fila['nombre'];
                    $descripcion = $fila['descripcion'];
                    $cantidad = $fila['cantidad'];
                    $estado = $fila['estado'];

                    // Imprimimos una fila de la tabla con los valores obtenidos
                    $tablaPedidos .= "<tr>";
                    $tablaPedidos .= "<td>" . $idPedido . "</td>";
                    $tablaPedidos .= "<td>" . $idProducto . "</td>";
                    $tablaPedidos .= "<td>" . $nombre . "</td>";
                    $tablaPedidos .= "<td>" . $descripcion . "</td>";
                    $tablaPedidos .= "<td>" . $cantidad . "</td>";
                    $tablaPedidos .= "<td>" . $estado . "</td>";
                    $tablaPedidos .= "<td>";
                    if ($estado == 'Pendiente') {
                        $tablaPedidos .= "<button onclick='cancelarPedido({$idPedido})' class='boton'>Cancelar</button>";
                    }
                    $tablaPedidos .= "</td>";
                    $tablaPedidos .= "</tr>";
                }
                $tablaPedidos .= "</table>"; // Cierra la tabla
            }
        }

    } else {
        // Si no hay sesión iniciada, mostrar el menú de invitado y mensaje de que no tiene permisos para estar en dicha página
        $menu = "<div class='header'>
                <img src='logo.png' alt='Logo corporativo' id='logo'>
                <div class='menu'>
                    <a href='index.php'>Inicio</a>
                    <a href='catalogo.php'>Catálogo</a>
                    <a href='login.php'>Iniciar sesión</a>           
                </div>
            </div>";
        $tablaPedidos = "<h1>No tiene permisos para estar aquí</h1>";


    }
    ?>

    <!-- Bloque script donde definimos las funciones que son llamadas desde los botones de borrar, enviar, rechazar o cancelar 
y que mostrarán las diferentes ventanas emergentes-->
    <script>
        // Función para cancelar el pedido que muestra la ventana emergente y envía los datos al archivo funciones.php
        function cancelarPedido(idPedido) {
            if (confirm("¿Estás seguro de que quieres cancelar este pedido?")) {
                // Realizar solicitud AJAX para cancelar el pedido
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idPedido_cancelar=" + idPedido
                })
                    // Si la respuesta es correcta mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El pedido ha sido cancelado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al cancelar el pedido");
                        }
                    })
                    // Si no es correcta, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al cancelar el pedido");
                    });
            }
        }
        // Función para borrar el pedido que muestra la ventana emergente y envía los datos al archivo funciones.php
        function borrarPedido(idPedido) {
            if (confirm("¿Estás seguro de que quieres borrar este pedido?")) {
                // Realizar solicitud AJAX para cancelar el pedido
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idPedido_borrar=" + idPedido
                })
                    // Si la respuesta es correcta mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El pedido ha sido borrado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al borrar el pedido");
                        }
                    })
                    // Si no es correcta, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al borrar el pedido");
                    });
            }
        }

        // Función para enviar el pedido que muestra la ventana emergente y envía los datos al archivo funciones.php
        function enviarPedido(idPedido) {
            if (confirm("¿Estás seguro de que quieres enviar este pedido?")) {
                // Realizar solicitud AJAX para cancelar el pedido
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idPedido_enviar=" + idPedido
                })
                    // Si la respuesta es correcta mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El pedido ha sido enviado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al enviar el pedido");
                        }
                    })
                    // Si no es correcta, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al enviar el pedido");
                    });
            }
        }

        // Función para rechazar el pedido que muestra la ventana emergente y envía los datos al archivo funciones.php
        function rechazarPedido(idPedido) {
            if (confirm("¿Estás seguro de que quieres rechazar este pedido?")) {
                // Realizar solicitud AJAX para cancelar el pedido
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idPedido_rechazar=" + idPedido
                })
                    // Si la respuesta es correcta, mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El pedido ha sido rechazado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al rechazar el pedido");
                        }
                    })
                    // Si no es correcta, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al rechazar el pedido");
                    });
            }
        }
    </script>
    <!-- Imprimimos el menú y la tabla correspondientes -->
    <?php echo $menu; ?>
    <div class="tabla">
        <?php echo $tablaPedidos; ?>
    </div>

</body>

</html>