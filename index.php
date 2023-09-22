<?php
//seguridad de sesiones para pagina
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion = '') {
    header("Location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html>
<title>Menú principal</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: url(css/imagenes/elegante-fondo-blanco-textura_23-2148438345.jpg);
            display: flex;
            background-repeat: no-repeat;
            background-position: center;
            justify-content: center;
            align-items: center;
            background-size: cover;
            min-height: 100vh;
            background-color: #dcdcdc;
        }

        .carousel-container hr {
            border-color: #0a0202f1;

        }


        .card-img-top {
            max-height: 160px;
            object-fit: contain;
        }

        .custom-bg {
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .card {
            padding-top: 10px;
            background-color: #d3d3d3;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .carousel-container {
            max-width: 800px;
            margin: 10px;
            margin-bottom: 27px;
        }

        .btn-orange {
            color: #0a0202f1;
            background-color: #FF9900;
        }
    </style>
</head>


<body>
    <div class="carousel-container container bg-lg custom-bg">
        <h1>Bienvenido al Sistema de Llamado a Comité</h1>
        <p>Genere citaciones de acuerdo a la situación</p>
        <hr>
        <p>Secciones:</p>

        <div class="carousel-container">
            <div id="slider" class="carousel slide custom-slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <img src="imagenes/4092564-about-mobile-ui-profile-ui-user-website_114033.png" class="card-img-top" alt="Aprendiz">
                                    <div class="card-body">
                                        <h5 class="card-title">Aprendiz</h5>
                                        <p class="card-text">Vea las citaciones del aprendiz.</p>

                                        <div class="d-grid gap-2 col-6 mx-auto text-center">
                                            <a href="vista_alumnos.php" class="btn btn-orange" type="button">Ir a la página alumnos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <img src="imagenes/time_timer_clock_hour_icon_205921.png" class="card-img-top" alt="Citacion">
                                    <div class="card-body">
                                        <h5 class="card-title">Citaciones</h5>
                                        <p class="card-text">Genere las citaciones que desee.</p>
                                        <div class="d-grid gap-2 col-6 mx-auto text-center">
                                            <a href="vista_cursos.php" class="btn btn-orange" type="button">Ir a la página de citaciones</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <img src="imagenes/3643772-archive-archives-document-folder-open_113445.png" class="card-img-top" alt="Gestionar archivos">
                                    <div class="card-body">
                                        <h5 class="card-title">Gestor de archivos</h5>
                                        <p class="card-text">Gestione los archivos.</p>
                                        <div class="d-grid gap-2 col-6 mx-auto text-center">
                                            <a href="dash.php" class="btn btn-orange" type="button">Ir a gestionar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <img src="imagenes/mail_icon-icons.com_72317.png" class="card-img-top" alt="Correo">
                                    <div class="card-body">
                                        <h5 class="card-title">Sistema de correos</h5>
                                        <p class="card-text">Gestion de correos.</p>
                                        <div class="d-grid gap-2 col-6 mx-auto text-center">
                                            <a href="bandeja_entrada.php" class="btn btn-orange" type="button">Ir a gestionar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <img src="imagenes/4115235-exit-logout-sign-out_114030.png" class="card-img-top" alt="Salir">
                                    <div class="card-body">
                                        <h5 class="card-title">Ir al inicio de sesión</h5>
                                        <p class="card-text">Haga clic para salir.</p>
                                        <div class="d-grid gap-2 col-6 mx-auto text-center">
                                            <a href="cerrar_sesion.php" class="btn btn-orange" type="button">Ir al inicio de sesión</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>

</html>