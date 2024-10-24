<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <?php
    include "funciones.php";

    // Verificar si el usuario ha iniciado sesión
    if (isset ($_SESSION['tipoUsuario'])) {
        $tipoUsuario = $_SESSION['tipoUsuario'];
        // Configurar el menú y la tabla de usuarios según el tipo de usuario
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

            // Construimos la tabla de usuarios
            $tablaUsuarios = "<a href='formularioUsuarios.php?Anadir' class='boton-usuario'>Añadir usuario</a>
            <table>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Fecha Nacimiento</th>
                    <th>Tipo Usuario</th>
                    <th>Acciones</th>
                </tr>";

            // Obtenemos la lista de usuarios
            $usuarios = obtenerListaUsuarios();

            // Comprobamos si hay usuarios
            if ($usuarios !== false) {
                // Iteramos sobre los usuarios
                while ($fila = mysqli_fetch_assoc($usuarios)) {
                    // Guardamos los valores en variables
                    $idUsuario = $fila['ID_usuario'];
                    $nombre = $fila['nombre'];
                    $apellidos = $fila['apellidos'];
                    $email = $fila['email'];
                    $contraseña = $fila['contraseña'];
                    $fechaNacimiento = $fila['fechaNacimiento'];
                    $tipoUsuario = $fila['tipoUsuario'];

                    // Imprimimos una fila de la tabla con los valores obtenidos
                    $tablaUsuarios .= "<tr>";
                    $tablaUsuarios .= "<td>" . $idUsuario . "</td>";
                    $tablaUsuarios .= "<td>" . $nombre . "</td>";
                    $tablaUsuarios .= "<td>" . $apellidos . "</td>";
                    $tablaUsuarios .= "<td>" . $email . "</td>";
                    $tablaUsuarios .= "<td>" . $contraseña . "</td>";
                    $tablaUsuarios .= "<td>" . $fechaNacimiento . "</td>";
                    $tablaUsuarios .= "<td>" . $tipoUsuario . "</td>";
                    $tablaUsuarios .= "<td><a href='formularioUsuarios.php?Editar=" . $fila['ID_usuario'] . "' class='boton'>Editar</a>  <button onclick='borrarUsuario({$idUsuario})' class='boton'>Borrar</button></td>";
                    $tablaUsuarios .= "</tr>";
                }
                $tablaUsuarios .= "</table>"; // Cierra la tabla
            }
        } elseif ($tipoUsuario == 0) {
            // Usuario registrado
            $menu = "<div class='header'>
         <img src='logo.png' alt='Logo corporativo' id='logo'/>
         <div class='menu'>
             <a href=''>Inicio</a>
             <a href='catalogo.php'>Catálogo exclusivo</a>
             <a href='pedidos.php'>Pedidos</a>
             <a href='logout.php'>Cerrar sesión</a>
         </div>
     </div>";
            /* En tablaUsuarios guardamos mensaje de que no tiene permisos ya que solo el administrador (usuario tipo 1)
            puede gestionar usuarios */
            $tablaUsuarios = "<h1>No tiene permisos para estar aquí</h1>";
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
        /* En tablaUsuarios guardamos mensaje de que no tiene permisos ya que solo el administrador (usuario tipo 1)
             puede gestionar usuarios */
        $tablaUsuarios = "<h1>No tiene permisos para estar aquí</h1>";

    }

    ?>
    <!-- Bloque script donde definimos las funciones que son llamadas desde los botones de borrar, enviar, rechazar o cancelar 
y que mostrarán las diferentes ventanas emergentes-->
    <script>
        // Función para borrar el usuario que muestra la ventana emergente y envía los datos al archivo funciones.php
        function borrarUsuario(idUsuario) {
            if (confirm("¿Estás seguro de que quieres borrar este usuario?")) {
                // Realizar solicitud AJAX para borrar el usuario
                fetch("funciones.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "idUsuario_borrar=" + idUsuario
                })
                    // Si la resùesta es correcta mostrar mensaje de éxito
                    .then(response => {
                        if (response.ok) {
                            alert("El usuario ha sido borrado correctamente");
                            window.location.reload(); // Recargar la página
                        } else {
                            throw new Error("Error al borrar el usuario");
                        }
                    })
                    // Si no es correcta, mostrar mensaje de error
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error al borrar el usuario");
                    });
            }
        }
    </script>

    <!-- Imprimimos el menú y la tabla correspondientes -->
    <?php echo $menu; ?>
    <div class="tabla">
        <?php echo $tablaUsuarios; ?>
    </div>

</body>

</html>