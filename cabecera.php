<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="librerias/fontawesome-free-6.4.0-web/css/all.css">



    <style>
        body {

            margin: 0;
            padding: 0;
        }

        .header {
            background-color: rgba(242, 242, 242, 0.05);
            color: white;
            padding: 14px;
            text-align: center;
        }

        .header a {
            font-size: 20px;
            color: white;
            text-decoration: none;
            margin-right: 20px;

            /* Agregar una línea inferior transparente */
        }

        .header a {
            margin-right: 46px;

        }

        .header a:last-child {
            margin-right: 0;

        }


        .header a:hover {
            color: #f5f5f5;
        }

        @media only screen and (max-width: 600px) {
            .header a {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php"><span class="fa-solid fa-house"></span> Inicio</a>
        <a href="vista_alumnos.php"> <span class="fas fa-user-graduate"></span> Aprendiz</a>
        <a href="vista_cursos.php"><span class="fa-solid fa-file-signature"></span> Citas</a>
        <a href="dash.php"><span class="fa-regular fa-folder-open"></span> Gestionar</a>
        <a href="cerrar_sesion.php"><span class="fa-solid fa-door-open"></span> Salir</a>
    </div>


</html>