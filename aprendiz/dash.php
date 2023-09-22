<?php
session_start();
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
    header("Location: login.php");
    die();
}

$conexion = mysqli_connect("localhost", "root", "", "aplicacion");

// Obtener la carpeta personal del usuario actual
$carpetaPersonal = 'files/' . $_SESSION['carpeta_personal'] . '/';

// Crear la carpeta personal del usuario si aún no existe
if (!file_exists($carpetaPersonal)) {
    mkdir($carpetaPersonal, 0777, true);
}

// Procesar el formulario de creación de carpetas
if (isset($_POST['nombre_carpeta'])) {
    $nuevaCarpeta = $_POST['nombre_carpeta'];
    $rutaNuevaCarpeta = $carpetaPersonal . $nuevaCarpeta;

    // Verificar si la carpeta ya existe
    if (!file_exists($rutaNuevaCarpeta)) {
        mkdir($rutaNuevaCarpeta, 0777, true);
    } else {
        echo "Ya existe una carpeta con ese nombre.";
    }
}

// Verificar si hay un mensaje en la URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];

    // Mostrar mensaje correspondiente
    if ($message === 'exists') {
        echo '<div class="message">El archivo ya existe.</div>';
    } elseif ($message === 'large') {
        echo '<div class="message">El archivo es demasiado grande.</div>';
    }
}

// Obtener la lista de carpetas después de crear una nueva
$carpetas = scandir($carpetaPersonal);
$carpetas = array_diff($carpetas, array('.', '..'));
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../librerias/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Gestionar archivos</title>
    <style>
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;

            /* Asegura que el cuerpo ocupe toda la altura del viewport */
        }

        body {

            margin: 0;
            /* Elimina el margen del cuerpo */
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(5, 7, 12, 0.55), rgba(5, 7, 12, 0.55)), url(../css/imagenes/Scene-24.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            height: 100vh;
            max-width: 800px;
            padding: 20px;
            box-sizing: border-box;
        }



        .container {
            margin-top: 4.4rem;
            margin-bottom: 8px;
            width: 56rem;
            padding-top: 28px;
            background-color: rgba(242, 242, 242, 0.08);
            padding-bottom: 15px;
            border-radius: 5px;
            height: 700px;
            overflow-y: auto;
            backdrop-filter: blur(29px);
        }

        h1 {
            font-size: 25px;
            margin: 0;
            color: white;
            padding: 25px;
            width: 100%;
            text-align: center;

        }


        .casillas {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .casilla {
            padding-top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 46.6rem;
            background-color: rgba(5, 7, 7, 0.13);
            padding: 4px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .nombre-archivo {

            font-size: 13px;
            margin-right: 50px;
        }

        .acciones-archivo {

            display: flex;
        }

        .acciones-archivo a {
            color: #fff;
            text-decoration: none;
            margin-right: 5px;
        }

        .acciones-archivo a:hover {
            text-decoration: underline;
        }

        .descripcion-archivos {
            display: flex;
            justify-content: flex-start;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .descripcion-archivos li {
            margin-right: 20px;
        }

        #file {
            font-size: 15px;
            margin-right: 4px;
            margin-left: 4px;
        }


        .fa-ghost {
            color: rgba(255, 255, 255, 0.4);
            padding-top: 25px;
            margin: auto;
            font-size: 80px;
        }

        .error {
            margin: auto;
        }

        .iconos {
            list-style: none;
            /* Elimina el marcador (bullet) de la lista */
            padding: 0;
            /* Elimina el relleno */
            margin: 0;
            /* Elimina el margen */

        }

        .abrirCorreo {
            margin: 6px;
            padding-top: 3px;
            align-items: center;
            transition: 0.3s;
            width: 8.2rem;
            cursor: pointer;
            border-radius: 8px;
            background-color: #008000;
        }

        .abrirCorreo:hover {
            color: #b9bdbf;
        }

        li {
            margin-bottom: 10px;
        }

        p {
            margin-left: 40px;
            font-size: 20px;
        }

        label {
            font-size: 17px;
        }

        h2 {
            margin-top: 2px;
            margin-left: 16rem;
            font-size: 20px;
            padding-bottom: 19px;
        }

        .linea {
            width: 125px;
            padding: 0;
            margin: auto;
            margin-left: 44%;
            margin-bottom: 8px;
            background-color: #B0B0B0;
        }

        hr {
            background: #fff;
            padding: .5px;
            margin-left: 50px;
            color: #fff;
            width: 82.6%;
        }

        a {
            margin-left: 35px;
            color: #fff;
            text-decoration: none;
        }

        span {
            padding: 5px;
            margin-right: 4px;
            margin-left: 4px;
        }

        a:hover {
            text-decoration: underline;
        }

        .volver {
            padding: 20px;
            margin: auto;

        }

        .volver:hover {
            text-decoration: none;
            color: #b9bdbf;
        }

        .opciones {
            padding-top: 2px;
            margin-left: 75px;
        }

        @media screen and (max-width: 768px) {
            .container {
                max-width: 90%;
                /* Reducir el ancho del contenedor en pantallas pequeñas */
            }

            .casilla {
                flex-direction: column;
                /* Apilar los íconos debajo del nombre en pantallas pequeñas */
                align-items: flex-start;
                /* Alinear íconos a la izquierda en pantallas pequeñas */
                padding: 4px;
                /* Reducir el espacio entre casillas en pantallas pequeñas */
            }

            .nombre-archivo {
                margin-right: 0;
                /* Eliminar el margen derecho del nombre en pantallas pequeñas */
                margin-bottom: 10px;
                /* Añadir un margen inferior al nombre en pantallas pequeñas */
            }

            .acciones-archivo {
                justify-content: flex-start;
                /* Alinear íconos a la izquierda en pantallas pequeñas */
            }

        }

        .menu {
            position: fixed;
            bottom: 20px;
            right: 20px;

            padding: 10px;
        }



        .icono-archivo {
            font-size: 20px;

        }

        .buscar-filtrar {

            margin-left: 4rem;
            display: flex;
            align-items: center;
        }

        .buscar-filtrar form {
            margin-top: 7px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            border-radius: 5px;
        }

        .buscar-filtrar input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border: none;
            border-radius: 1px;
            outline: none;
        }

        .buscar-filtrar button {
            padding: 10px 16px;
            font-size: 14px;
            background-color: #FF9900;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            border: none;
            outline: none;

        }

        .sidebar {
            border-radius: 3px;
            border: 2px solid rgba(255, 255, 255, .05);
            background: rgba(255, 255, 255, 0.055);
            /* Color de fondo de la barra lateral */
            color: #fff;
            /* Color del texto en la barra lateral */
            width: 9rem;
            /* Ancho de la barra lateral */
            height: 100vh;
            /* Altura al 100% del viewport */
            padding-top: 25px;
            /* Espacio superior */
            position: fixed;
            /* Fija la barra lateral en su lugar */
            left: 0;
            /* Posiciona la barra en la izquierda */
            top: 0;
            /* Posiciona la barra en la parte superior */
        }

        /* Estilo para el contenido principal */
        .main-content {
            margin-left: 30rem;
            /* Ajusta el margen para dejar espacio para la barra lateral */

            /* Espacio interior para separar del borde */
        }

        .sidebar .iconos {
            list-style: none;
            /* Elimina el marcador (bullet) de la lista */
        }

        /* Estilos para el contenedor principal */
        .contenedor-principal {
            position: fixed;
            margin-left: 9rem;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* Pegar arriba */
            padding: 7px;
            background-color: rgba(242, 242, 242, 0.1);
            z-index: 999;
            backdrop-filter: blur(15px);
            box-sizing: border-box;
        }

        /* Estilos para el formulario de subir archivos */
        .subir {
            margin-left: 13rem;
            width: 32%;
            /* Ancho de cada elemento */
            font-size: 14px;
            /* Tamaño de fuente más pequeño */
            background-color: rgba(242, 242, 242, 0.06);
            border-radius: 5px;
            padding: 7.5px;
            /* Menor espacio interno */
            text-align: center;
            box-sizing: border-box;

            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .carpeta {
            margin-right: 22rem;
            width: 31%;
            /* Ancho de cada elemento */
            font-size: 14px;
            /* Tamaño de fuente más pequeño */
            background-color: rgba(242, 242, 242, 0.06);
            border-radius: 5px;
            padding: 10px;
            /* Menor espacio interno */
            text-align: center;
            box-sizing: border-box;

            display: flex;
            flex-direction: column;
        }

        .nombre_carpeta {
            margin-left: 0;
        }

        .folder {
            align-items: center;
            width: auto;
            padding: 5px;
            background: rgba(255, 255, 255, .2);
            border: none;
            outline: none;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 5px;
            color: #fff;
        }




        .iconos {
            font-size: 21px;
            list-style: none;
            /* Elimina el marcador (bullet) de la lista */
            padding: 0;
            /* Elimina el relleno */
            margin: 0;
            /* Elimina el margen */
            position: fixed;
            /* Fija el elemento en la pantalla */
            left: 0;
            /* Ajusta la posición a la izquierda */
            top: 33%;
            /* Ajusta la posición vertical al centro */
            transform: translateY(-50%);
        }

        .iconos li {
            margin-top: 15.6px;
            margin-bottom: 15.6px;
            /* Añade un margen inferior para separar los íconos si es necesario */
        }

        .iconos li a {
            display: block;
            /* Hace que el enlace ocupe todo el ancho del contenedor */
            padding: 0 0;
            /* Añade relleno (espaciado) vertical */
        }

        .iconos li a span {
            margin-right: 0;
            /* Añade un margen derecho para separar el icono del texto si es necesario */
        }

        .ico {
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, .2);
            margin: 6px;
            transition: 0.3s;
        }

        .ico:hover {
            color: #b9bdbf;
            transition: 0.3s;
        }

        .iconos a {
            color: inherit;
            /* Hereda el color del texto de su elemento padre */
        }


        .lista {
            text-decoration: none;
            transition: 0.3s;
        }

        .lista:hover {
            text-decoration: none;
            color: #b9bdbf;
            transition: 0.3s;
        }

        .loading {
            pointer-events: none;
        }

        .loading .loader {
            display: block;
        }

        .buscar {
            display: flex;
        }

        /* Estilo del botón para mostrar/ocultar el contenedor de correo */
        .toggle-btn {
            border-radius: 7px;
            position: fixed;
            top: 46%;
            left: 117rem;
            transform: translateY(-50%);
            background-color: rgba(242, 242, 242, 0.08);
            padding-top: 20px;
            align-items: center;
            height: 70px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            cursor: pointer;
        }

        /* Estilo del ícono de flecha en el botón */
        #toggle-icon {
            font-size: 20px;
            font-family: "Font Awesome 6 Free";
            font-weight: 900;

        }


        /* Estilo del contenedor del sistema de correo */
        .correo-derecha {
            display: none;
            /* Ocultar el contenedor por defecto */
            position: fixed;

            top: 190.7px;
            right: 20px;

            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            height: 730px;
            width: 700px;
            border: 1px solid rgba(242, 242, 242, 0.3);
            bottom: 0;
            /* Fijamos el contenedor en la parte inferior de la pantalla */
            max-height: 0;
            /* Inicialmente, el contenedor estará oculto */
            overflow: hidden;
            /* Para ocultar el contenido que exceda la altura máxima */
            transition: max-height 0.3s ease;
        }

        /* Estilo del ícono de flecha cuando el formulario esté abierto */
        .correo-derecha.show #toggle-icon {
            transform: rotate(180deg);
            /* Rotamos el ícono 180 grados cuando el formulario esté abierto */

        }

        /* Estilo para mostrar el contenedor cuando esté visible */
        .correo-derecha.show {
            margin-right: 28px;
            display: block;
            background-color: rgba(5, 7, 12, 0.04);
            border-radius: 4px;
            overflow-y: auto;
            backdrop-filter: blur(40px);
            max-height: 90%;
        }

        /* Estilo para centrar el formulario dentro del contenedor */
        .correo-derecha form {
            margin-left: 2px;
            display: flex;
            flex-direction: column;
        }

        /* Estilo para los inputs y el textarea */
        .adjunto-container input.adjunto,
        .adjunto-container textarea,
        .formu,
        .texto {
            border: 2px solid rgba(255, 255, 255, .2);
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: (50px);
            color: #fff;
            padding: 10px;
        }

        /* Estilo para los placeholders en los campos de entrada */
        .adjunto-container input.adjunto::placeholder,
        .formu::placeholder,
        .texto::placeholder {
            color: white;
            opacity: 0.80;
            /* Asegura que el color sea completamente visible */
        }



        .form-group {
            width: 103%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        .formu {

            border-radius: 10px;
            width: 40.4rem;
            height: 40px;
        }

        .texto {
            border-radius: 5px;
            width: 40.4rem;
            height: 270px;
        }

        .enviar {
            width: 8rem;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }


        /* Estilo del campo de adjunto */
        .adjunto-container {
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }

        #lista-adjuntos {
            list-style-type: none;
            padding-left: 0;
        }

        .list-unstyled {
            margin-left: 35px;
        }


        .adjunto {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            cursor: pointer;
        }

        .adjunto-label {
            display: flex;
            align-items: center;
            padding: 4px 8px;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 4px;
            cursor: pointer;
        }

        .adjunto-label .fa-paperclip {
            margin-right: 8px;
        }

        .nombre-archivo {
            margin-left: 8px;
        }

        /* Estilo del botón de enviar */
        .enviar {
            padding: 8px 16px;
            background-color: #008000;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .fa-paper-plane {
            font-size: 18px;
        }

        /* Para navegadores que soportan scrollbar-color */
        ::-webkit-scrollbar {

            width: 10px;
        }

        ::-webkit-scrollbar-track {
            border-radius: 1px;
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Para otros navegadores */
        /* Estilos generales del scroll */
        ::-webkit-scrollbar {
            width: 11px;
        }

        /* Estilos del thumb (barra de scroll) */
        ::-webkit-scrollbar-thumb {
            border-radius: 2px;
            background: #FF9900;
        }

        /* Estilos del track (fondo del scroll) */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .puntor {
            cursor: pointer;
        }

        .label {
            padding-left: 2px;
            cursor: pointer;
        }

        .citar {
            cursor: pointer;
        }

        .archivo {
            font-size: 20px;
        }

        .imagen {
            margin-left: 9px;
        }

        /* Estilo para la animación de carga */
        .buscar-filtrar {
            position: relative;
            /* Establecer el contexto de posición para los elementos hijos */
        }

        .loader {
            display: none;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 23px;
            height: 23px;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 39%;
            right: 20px;
            left: 105%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .linea-vertical {
            border-right: 2px solid #ccc;
            height: 33px;
            padding-right: 4px;
            /* Ajusta la altura según sea necesario */
            margin: 0 3px;
            /* Agrega espacio entre la línea y el icono/nombre */
        }

        .basura {
            padding-left: 0;
            padding-right: 20px;
        }




        .nombre_carpeta {
            padding: 0;
            margin: 0;
        }


        .disabled-icon {
            display: none;
            /* Oculta los íconos */
            pointer-events: none;
            /* Desactiva la interacción */
        }

        .mb-4,
        .my-4 {
            margin-bottom: 13.3px !important;
        }

        /* Estilos para el botón personalizado */
        .file-upload-button {
            display: inline-block;
            padding: 7px;
            background-color: #FF9900;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .file-upload-button span {
            margin-right: 8px;
        }

        .file-upload-button:hover {
            background-color: #E58E00;
        }

        .crear {
            display: inline-block;
            padding: 7px;
            background-color: #FF9900;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .crear:hover {
            background-color: #E58E00;
        }

        .ordenar-form {
            margin-left: 33rem;
            border: none;
            display: flex;
            align-items: center;
        }



        .ordenar-form label {
            border: none;
            margin-right: 10px;
        }

        .ordenar-select {
            border: none;
            position: relative;

        }

        .ordenar-icon {
            border: none;
            cursor: pointer;
        }

        .ordenar-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            padding: 5px;
            width: 190px;
            border: none;
        }

        .aplicar {
            border: none;
            border-radius: 3px;
        }

        .hidden-checkbox {
            border: none;
            display: none;
        }

        .hidden-checkbox:checked+.ordenar-icon+.ordenar-options {
            display: block;
        }
    </style>

</head>

<body>

    <div class="sidebar">
        <a class="imagen" href="index.php"><img src="../css/imagenes/Documento_sin_título-removebg-preview.png" alt="Acomite" width="120px"></a>
        <ul class="iconos">

            <li class="abrirCorreo">
                <span class="fa-solid fa-feather-pointed" onclick="toggleCorreo()"></span><label class="puntor" onclick="toggleCorreo()">Redactar</label>
            </li>

            <li class="no-esp"><a class="ico" href="index.php"><span class="fas fa-home"></span><label class="label">Menú</label></a>

            <li class="no-esp"><a class="ico" href="../cerrar_sesion.php"><span class="fa-solid fa-door-open"></span><label class="label">Salir</label></a>
            </li>

        </ul>
    </div>
    <div class="main-content">
        <div class="contenedor-principal">
            <div class="subir">
                <form action="upload.php" method="post" enctype="multipart/form-data" class="file-upload-form" onsubmit="return validarFormulario()">
                    <label for="file" class="file-upload-label">
                        <input type="file" name="file" id="file" class="file-upload-input" onchange="mostrarNombreArchivo()">
                    </label>
                    <button type="submit" class="file-upload-button"><span class="fa-solid fa-cloud-arrow-down"></span> Subir archivo</button>

                </form>
                <div id="nombre-archivo"></div>

            </div>

            <div class="carpeta">
                <form method="post" action="">
                    <label class="nombre_carpeta" for="nombre_carpeta">
                        <span class="fas fa-folder"></span> <!-- Ícono de carpeta de Font Awesome -->
                        Nombre de la carpeta:
                    </label>
                    <input class="folder" type="text" name="nombre_carpeta" id="nombre_carpeta" required>
                    <button class="crear" type="submit">
                        <span class="fas fa-plus"></span>
                        Crear Carpeta
                    </button>
                </form>
            </div>
        </div>



        <script>
            function mostrarNombreArchivo() {
                const fileInput = document.getElementById('file');
                const nombreArchivoDiv = document.getElementById('nombre-archivo');

                if (fileInput.files && fileInput.files[0]) {
                    const archivo = fileInput.files[0];

                    // Mostrar el nombre del archivo en el elemento <div>
                    nombreArchivoDiv.textContent = archivo.name;
                } else {
                    // Si no se selecciona ningún archivo, mostrar un mensaje vacío
                    nombreArchivoDiv.textContent = '';
                }

            }
        </script>
        <div class="container">

            <div class="casillas">
                <div class="buscar">
                    <div class="buscar-filtrar">
                        <form method="get" action="dash.php">
                            <input type="text" name="search" placeholder="Buscar por nombre">
                            <button type="submit" class="btn-buscar"><span class="fas fa-search"></span></button>
                            <div class="loader loader-nombre"></div> <!-- Agrega una clase única para el loader de búsqueda por nombre -->
                        </form>
                    </div>
                    <div class="buscar-filtrar">
                        <form method="get" action="dash.php" onsubmit="agregarPunto()">
                            <input type="hidden" name="search_type" value="extension">
                            <input type="text" id="searchInput" name="search" placeholder="Buscar por extensión">
                            <button type="submit" class="btn-buscar"><span class="fas fa-search"></span></button>
                            <div class="loader loader-extension"></div>
                        </form>

                    </div>
                </div>

                <form method="get" class="ordenar-form">
                    <label for="ordenarPor">Ordenar por:</label>
                    <div class="ordenar-select">
                        <input type="checkbox" id="mostrarOpciones" class="hidden-checkbox">
                        <label class="ordenar-icon" for="mostrarOpciones"><i class="fa-solid fa-filter"></i></label>
                        <select name="ordenarPor" id="ordenarPor" class="ordenar-options">
                            <option value="nombre_asc">Nombre ascendente</option>
                            <option value="nombre_desc">Nombre descendente</option>
                        </select>
                    </div>
                    <button class="aplicar" type="submit">Aplicar</button>
                </form>

                <hr>

                <?php
                $elementosPorPagina = 10;

                //$carpetaPersonal = 'files/';    //ACA LE TOCA AÑADIR LA RUTA DEL USUARIO DESPUES DEL files/
                //OSEA QUE LE TOCA CONSULTAR LA CARPETA DEL USUARIO QUE ESTA LOGUEADO 
                //O TRAER ESE DATO EN UNA VARIABLE DE SESIÒN

                $files = scandir($carpetaPersonal);
                $archivosReales = array_diff($files, array('.', '..'));
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $archivosEncontrados = array_filter($archivosReales, function ($file) use ($search) {
                    return stripos($file, $search) !== false;
                });

                $totalArchivos = count($archivosEncontrados);
                $totalPaginas = ceil($totalArchivos / $elementosPorPagina);
                $paginaActual = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $indiceInicio = ($paginaActual - 1) * $elementosPorPagina;
                $archivosPaginados = array_slice($archivosEncontrados, $indiceInicio, $elementosPorPagina);
                $extensionesIconos = array(
                    'pdf' => 'fa-file-pdf',
                    'txt' => 'fa-file-alt',
                    'docx' => 'fa-file-word',
                    'png' => 'fa-file-image',
                    'jpg' => 'fa-file-image',
                    'jpeg' => 'fa-file-image',
                    'xls' => 'fa-file-excel',
                    'xlsx' => 'fa-file-excel',
                    'ppt' => 'fa-file-powerpoint',
                    'pptx' => 'fa-file-powerpoint',
                    'dir' => 'fa-folder'
                    // Agrega más extensiones y sus íconos aquí
                );

                echo '<ul class="list-unstyled">'; // Agrega la clase "list-unstyled" para eliminar estilos por defecto de la lista

                $ordenarPor = $_GET['ordenarPor'] ?? ''; // Obtener el valor del campo de selección

                // Ordenar los archivos y carpetas según la selección
                if ($ordenarPor === 'nombre_asc') {
                    sort($archivosPaginados);
                } elseif ($ordenarPor === 'nombre_desc') {
                    rsort($archivosPaginados);
                }

                // Separar carpetas y archivos
                $carpetas = [];
                $archivos = [];

                foreach ($archivosPaginados as $file) {
                    $filePath = $carpetaPersonal . $file;
                    if (is_dir($filePath)) {
                        $carpetas[] = $file;
                    } else {
                        $archivos[] = $file;
                    }
                }

                // Ordenar carpetas al principio y luego los archivos
                sort($carpetas);
                sort($archivos);

                // Unir carpetas y archivos en una lista ordenada
                $archivosOrdenados = array_merge($carpetas, $archivos);


                foreach ($archivosPaginados as $file) {
                    $filePath = $carpetaPersonal . $file;
                    $iconClass = '';

                    if (is_dir($filePath)) {
                        $iconClass = $extensionesIconos['dir'];
                        $fileLink = "carpeta.php?carpeta=" . urlencode($file);
                    } else {
                        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                        $iconClass = isset($extensionesIconos[$fileExtension]) ? $extensionesIconos[$fileExtension] : 'fa-file';
                        $fileLink = $filePath;
                    }

                    echo "<li class='casilla mb-4 border-bottom'>"; // Agrega las clases para separación y división
                    echo "<div class='d-flex align-items-center'>";

                    // Línea vertical a la izquierda de los iconos
                    echo "<span class='icono-archivo me-3'><i class='fas $iconClass'></i></span>";

                    // Línea vertical a la derecha de los iconos
                    echo "<span class='linea-vertical'></span>";

                    // Verificar si es una carpeta y crear el enlace correspondiente
                    if (is_dir($filePath)) {
                        echo "<a href='$fileLink'>$file</a>"; // Enlace para la carpeta
                    } else {
                        echo "<span class='nombre-archivo'>$file</span>"; // Sin enlace para archivo
                    }

                    echo "</div>";
                    echo "<div class='acciones-archivo '>";

                    // Línea vertical a la izquierda de los íconos en las acciones
                    if (!is_dir($filePath)) {
                        echo "<a href='$filePath' target='_blank' class='me-2'><span class='fa-regular fa-eye'></span></a>";
                    }

                    echo "<a href='delete.php?file=$file' class='me-2'><span class='fa-solid fa-trash basura'></span></a>";

                    // Línea vertical entre íconos
                    echo "<span class='linea-vertical'></span>";

                    // Verificar si es un archivo y mostrar el ícono de descarga
                    if (!is_dir($filePath)) {
                        echo "<a href='$filePath' download><span class='fa-solid fa-file-arrow-down'></span></a>";
                    }

                    // Línea vertical a la derecha de los íconos en las acciones
                    echo "</div>";
                    echo "</li>";
                }
                echo '</ul>';



                if (!$archivosPaginados) {
                    echo '<p class="error">No se encontraron archivos coincidentes.</p>';
                    echo '<span class="fa-solid fa-ghost fa-beat-fade"></span>';
                    echo '<a class="volver" href="dash.php"><span class="fa-regular fa-clipboard"></span>Volver a la lista</a>';
                }

                if (isset($_GET['search'])) {
                    $extension = $_GET['search'];
                    $directorio = "files/";
                    $archivosEncontrados = array();

                    if ($extension != '') {
                        $archivos = scandir($directorio);

                        foreach ($archivos as $archivo) {
                            $rutaArchivo = $directorio . $archivo;
                            if (is_file($rutaArchivo) && pathinfo($archivo, PATHINFO_EXTENSION) == $extension) {
                                $archivosEncontrados[] = $archivo;
                            }
                        }
                    }
                }

                if ($totalPaginas > 1) {
                    echo '<div class="pagination">';
                    if ($paginaActual > 1) {
                        echo '<a href="?search=' . urlencode($search) . '&page=' . ($paginaActual - 1) . '">Anterior</a>';
                    }
                    for ($i = 1; $i <= $totalPaginas; $i++) {
                        if ($i == $paginaActual) {
                            echo '<span class="active">' . $i . '</span>';
                        } else {
                            echo '<a href="?search=' . urlencode($search) . '&page=' . $i . '">' . $i . '</a>';
                        }
                    }
                    if ($paginaActual < $totalPaginas) {
                        echo '<a href="?search=' . urlencode($search) . '&page=' . ($paginaActual + 1) . '">Siguiente</a>';
                    }
                    echo '</div>';
                }
                ?>

            </div>
        </div>
        <a class="lista" href="dash.php"><span class="fa-regular fa-clipboard"></span>Volver a la lista</a>

        <!-- Agregamos el sistema de correo en la parte derecha e inferior -->

        <div class="correo-derecha">
            <form method="post" action="enviar_correo.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Destinatario:</label>
                    <input class="formu" type="email" name="destinatario" id="destinatario" placeholder="Destinatario" required>
                </div>
                <div class="form-group">
                    <label>Asunto:</label>
                    <input class="formu" type="text" name="asunto" id="asunto" placeholder="Asunto" required>
                </div>

                <!-- Campo de adjunto con icono y nombre del archivo -->
                <div class="form-group">
                    <div class="adjunto-container">
                        <input class="adjunto" type="file" name="adjunto" id="adjunto" onchange="actualizarNombreArchivo()">
                        <label class="adjunto-label" for="adjunto">
                            <span class="fas fa-paperclip"></span> Adjuntar
                        </label>
                    </div>
                </div>

                <!-- Campo de mensaje -->
                <div class="form-group">
                    <textarea class="texto" name="mensaje" id="mensaje" placeholder="Mensaje" required></textarea>
                </div>

                <!-- Lista de archivos adjuntos -->
                <div class="form-group">
                    <ul id="lista-adjuntos"></ul>
                </div>

                <!-- Botón de enviar -->
                <button class="enviar" type="submit">Enviar<span class="fa-regular fa-paper-plane"></span></button>
            </form>

        </div>

        <div class="toggle-btn" onclick="toggleCorreo()">
            <span class="fa-solid fa-envelope" id="toggle-icon"></span>
        </div>

        <script>
            function toggleCorreo() {
                var correoContainer = document.querySelector(".correo-derecha");
                correoContainer.classList.toggle("show");

                var toggleIcon = document.getElementById("toggle-icon");
                toggleIcon.classList.toggle("fa-envelope");
                toggleIcon.classList.toggle("fa-envelope-open");
            }
        </script>

        <script>
            function validarFormulario() {
                var archivo = document.getElementById('file').value;
                if (archivo === '') {
                    alert('Por favor, seleccione un archivo antes de subirlo.');
                    return false; // Evita que el formulario se envíe
                }
                return true; // Permite que el formulario se envíe
            }
        </script>

        <script>
            const toggleButton = document.getElementById('toggleButton');
            const barside = document.getElementById('barside');

            toggleButton.addEventListener('click', () => {
                // Si la barra lateral está abierta, la cerramos. Si está cerrada, la abrimos.
                const isOpen = barside.style.transform === 'translateX(0px)';
                barside.style.transform = isOpen ? 'translateX(-200px)' : 'translateX(0px)';
            });
        </script>


        <script>
            function actualizarNombreArchivo() {
                var inputAdjunto = document.getElementById("adjunto");
                var nombreArchivo = inputAdjunto.files[0].name;
                var extensionArchivo = nombreArchivo.split('.').pop().toLowerCase();

                var listaAdjuntos = document.getElementById("lista-adjuntos");
                var liElement = document.createElement("li");
                liElement.innerHTML = `<span class="archivo fas fa-file-${obtenerIcono(extensionArchivo)}"></span> Archivo: ${nombreArchivo}`;
                listaAdjuntos.appendChild(liElement);
            }

            function obtenerIcono(extension) {
                // Define la relación entre extensiones de archivo y los íconos
                var extensionesIconos = {
                    'pdf': 'pdf',
                    'txt': 'alt',
                    'docx': 'word',
                    'png': 'image',
                    'jpg': 'image',
                    'jpeg': 'image',
                    'xls': 'excel',
                    'xlsx': 'excel',
                    'ppt': 'powerpoint',
                    'pptx': 'powerpoint'
                    // Agrega más extensiones y sus íconos aquí
                };

                // Si la extensión está definida en el objeto extensionesIconos, devuelve el ícono correspondiente
                if (extensionesIconos.hasOwnProperty(extension)) {
                    return extensionesIconos[extension];
                }

                // Si no hay un ícono definido para la extensión, devuelve 'file' como ícono genérico
                return 'file';
            }
        </script>

        <script>
            // Función para mostrar el icono según la extensión del archivo
            function mostrarIconoPorExtension(ext) {
                const iconosPorExtension = {
                    pdf: '<i class="fas fa-file-pdf"></i>',
                    txt: '<i class="fas fa-file-alt"></i>',
                    doc: '<i class="fas fa-file-word"></i>',
                    docx: '<i class="fas fa-file-word"></i>',
                    png: '<i class="fas fa-file-image"></i>',
                    ppt: '<i class="fa-solid fa-file-powerpoint"></i>',
                    pptx: '<i class="fas fa-file-powerpoint"></i>',
                    jpg: '<i class="fas fa-file-image"></i>',

                    // Agrega más extensiones y sus iconos aquí
                };

                return iconosPorExtension[ext] || '<i class="fas fa-file"></i>';
            }

            // Función para actualizar el contenido del elemento #nombre-archivo
            function mostrarNombreArchivo() {
                const inputAdjunto = document.getElementById("file");
                const nombreArchivoSpan = document.getElementById("nombre-archivo");

                if (inputAdjunto.files.length > 0) {
                    const archivo = inputAdjunto.files[0];
                    const extension = archivo.name.split('.').pop().toLowerCase();
                    const icono = mostrarIconoPorExtension(extension);

                    nombreArchivoSpan.innerHTML = `${icono} ${archivo.name}`;
                } else {
                    nombreArchivoSpan.innerHTML = '';
                }
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const formulariosBuscar = document.querySelectorAll(".buscar-filtrar form");

                formulariosBuscar.forEach(formulario => {
                    const botonBuscar = formulario.querySelector(".btn-buscar");
                    const loader = formulario.querySelector(".loader");

                    formulario.addEventListener("submit", function() {
                        loader.style.display = "block"; // Mostrar el loader durante la búsqueda
                    });

                    botonBuscar.addEventListener("click", function() {
                        loader.style.display = "none"; // Ocultar el loader cuando se hace clic en el botón de búsqueda
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const formulariosBuscar = document.querySelectorAll(".buscar-filtrar form");

                formulariosBuscar.forEach(formulario => {
                    formulario.addEventListener("submit", function() {
                        const loader = formulario.querySelector(".loader");
                        loader.style.display = "block"; // Mostrar el loader durante la búsqueda
                    });
                });
            });
        </script>

        <script>
            function agregarPunto() {
                var searchInput = document.getElementById("searchInput");
                var searchValue = searchInput.value.trim();

                if (searchValue !== "" && !searchValue.startsWith(".")) {
                    searchInput.value = "." + searchValue;
                }
            }
        </script>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>