<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <?php
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (isset ($_SESSION['tipoUsuario'])) {
        $tipoUsuario = $_SESSION['tipoUsuario'];
        // Configurar el menú y el mensaje de bienvenida según el tipo de usuario
        if ($tipoUsuario == 1) {
            // Usuario administrador
            $menu = "<div class='header'>
                    <img src='logo.png' alt='Logo corporativo' id='logo'/>
                    <div class='menu'>                   
                        <a href=''>Inicio</a>
                        <a href='catalogo.php'>Catálogo exclusivo</a>
                        <a href='pedidos.php'>Pedidos</a>
                        <a href='usuarios.php'>Usuarios</a>
                        <a href='logout.php'>Cerrar sesión</a>
                    </div>
                </div>";
            $mensajeBienvenida = "¡Bienvenid@ al perfil de administrador!";
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
            $mensajeBienvenida = "¡Bienvenid@ Usuari@!";
        }
    } else {
        // Si no hay sesión iniciada, mostrar el menú de invitado
        $menu = "<div class='header'>
                <img src='logo.png' alt='Logo corporativo' id='logo'/>
                <div class='menu'>
                    <a href=''>Inicio</a>
                    <a href='catalogo.php'>Catálogo</a>
                    <a href='login.php'>Iniciar sesión</a>           
                </div>
            </div>";
        $mensajeBienvenida = "";
    }
    ?>
    <!-- Imprimimos el menú correspondiente -->
    <?php echo $menu; ?>
    <!-- Creamos un div contenedor del texto y la imagen -->
    <div class="contenedor">
        <!-- Imprimimos el mensaje de bienvenida -->
        <h1>
            <?php echo $mensajeBienvenida; ?>
        </h1>
        <!-- Creamos un div para el texto -->
        <div class="texto">
            <h4>¿Quiénes somos?</h4>
            <p>En <b>Joyería Jomat</b>, creamos joyas excepcionales que reflejan la elegancia y la sofisticación. Cada
                pieza es una obra maestra única, elaborada con pasión y precisión artesanal.
                Nuestro compromiso es ofrecerte piezas de calidad que añadan un toque de belleza a tus momentos más
                especiales. Explora nuestra colección y encuentra la joya perfecta para ti o para esa persona especial
                en tu vida.
            </p>
            <p>
                <em>¡Bienvenido a Joyería Jomat, donde la elegancia cobra vida!</em>
            </p>

        </div>
        <!-- Creamos un div para la imagen -->
        <div class="img-index">
            <img id="foto-index" src="fotoindex.png" width="500" />
        </div>

    </div>
    <!-- Creamos el footer -->
    <footer>
        <div class='footer-content'>
            <p>Web creada por Álvaro Mateos © 2024 </p>
        </div>
    </footer>
</body>

</html>