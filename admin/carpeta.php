<?php
session_start();

$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
    header("Location: login.php");
    die();
}

$conexion = mysqli_connect("localhost", "root", "", "aplicacion");

$carpetaPersonal = 'files/' . $_SESSION['carpeta_personal'] . '/';

if (!file_exists($carpetaPersonal)) {
    mkdir($carpetaPersonal, 0777, true);
}

$carpetaSeleccionada = $_GET['carpeta'] ?? '';

if (isset($_POST['nombre_carpeta'])) {
    $nuevaCarpeta = $_POST['nombre_carpeta'];
    $rutaNuevaCarpeta = $carpetaPersonal . $carpetaSeleccionada . '/' . $nuevaCarpeta;

    if (!file_exists($rutaNuevaCarpeta)) {
        mkdir($rutaNuevaCarpeta, 0777, true);
        echo "Carpeta '$nuevaCarpeta' creada exitosamente.";
    } else {
        echo "Ya existe una carpeta con ese nombre.";
    }
}

$carpetaActual = $carpetaPersonal . $carpetaSeleccionada;
$archivosCarpeta = scandir($carpetaActual);
$archivosCarpeta = array_diff($archivosCarpeta, array('.', '..'));
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../librerias/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Contenido de la Carpeta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .cuerpo {
            background-color: #008000;
            color: #fff;
            padding: 10px;
            margin: 0;
            display: flex;
            /* Utilizar display flex para alinear verticalmente los elementos */
            align-items: center;
            /* Centrar verticalmente los elementos dentro de .cuerpo */
        }

        .cuerpo img {
            margin-top: 2px;
            /* Ajustar el margen superior de la imagen */
            margin-right: 34rem;
            /* Mover la imagen a la derecha para alinearla con el título */
        }

        .form-container {
            width: 40rem;
            display: flex;
            justify-content: space-between;
            margin: 20px;
            border: 1px solid #ddd;
            /* Agregar un borde al contenedor del formulario */
            padding: 10px;
            /* Agregar un espacio interno para separar los elementos del formulario */
            border-radius: 4px;
            /* Añadir esquinas redondeadas al formulario */
            background-color: #f1f1f1;
            /* Cambiar el color de fondo */
        }

        .form-container form {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Espacio entre los elementos del formulario */
        }

        .form-container input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            /* Agregar un borde al campo de carga de archivos */
            border-radius: 4px;
            /* Esquinas redondeadas */
        }

        h2 {
            margin-left: 40px;
        }

        .form-container input[type="submit"] {
            background-color: #008000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            /* Esquinas redondeadas para el botón */
        }


        .file-list {
            list-style: none;
            padding: 0;
            margin: 20px;
        }

        .file-list li {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .archivo-lista {
            width: 90rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .archivo-lista li {
            margin-bottom: 10px;
        }

        .carpeta {
            display: inline-block;
            padding: 5px 10px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .archivo {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f1f1f1;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }

        .carpeta:hover,
        .archivo:hover {
            background-color: #2980b9;
            color: #fff;
        }

        .archivo-lista li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .nombre-archivo {
            flex: 1;
            /* Aprovechar el espacio disponible */
            margin-right: 10px;
            /* Margen a la derecha para separar el nombre del archivo */
        }

        .acciones-archivo {
            font-size: 20px;
            display: flex;
            gap: 40px;
            /* Espacio entre los íconos de las acciones */
        }
    </style>

<body>
    <div class="cuerpo">
        <a href="admin.php"><img src="../css/imagenes/Documento_sin_título-removebg-preview.png" alt="Acomite" width="200px"></a>
        <h1>Contenido de la Carpeta</h1>
    </div>



    <div class="form-container">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="archivo">
            <input type="submit" value="Subir Archivo">
        </form>

    </div>

    <div>
        <h2>Contenido de la carpeta actual:</h2>
        <ul class="file-list">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Procesar la subida de archivos
                if (isset($_FILES['archivo'])) {
                    $archivoSubido = $_FILES['archivo'];
                    $nombreArchivo = $archivoSubido['name'];
                    $rutaArchivo = $carpetaActual . '/' . $nombreArchivo;
                    $uploadOk = 1;

                    // ... (Validaciones adicionales aquí)

                    if ($uploadOk) {
                        if (move_uploaded_file($archivoSubido['tmp_name'], $rutaArchivo)) {
                            echo "Archivo '$nombreArchivo' subido exitosamente.";
                        } else {
                            echo "Hubo un error al subir el archivo.";
                        }
                    }
                }
            }

            echo '<ul class="archivo-lista">';
            foreach ($archivosCarpeta as $archivo) {
                $rutaArchivo = $carpetaActual . '/' . $archivo;
                if (is_dir($rutaArchivo)) {
                } else {
                    echo "<li>";
                    echo "<span class='nombre-archivo'>$archivo</span>";
                    echo "<div class='acciones-archivo'>";

                    // Enlace para descargar archivo (mismo archivo)
                    echo "<a href='$rutaArchivo' download><span class='fa-solid fa-file-arrow-down'></span></a>";

                    // Enlace para eliminar archivo (mismo archivo)
                    echo "<a href='carpeta.php?eliminar=" . urlencode($archivo) . "'><span class='fa-solid fa-trash'></span></a>";

                    echo "</div>";
                    echo "</li>";
                }
            }
            echo '</ul>';

            // Procesar acción de eliminar archivo
            if (isset($_GET['eliminar'])) {
                $archivoAEliminar = $_GET['eliminar'];
                $rutaArchivoAEliminar = $carpetaActual . '/' . $archivoAEliminar;

                if (is_file($rutaArchivoAEliminar)) {
                    unlink($rutaArchivoAEliminar); // Eliminar el archivo
                    echo "<script>alert('Archivo \"$archivoAEliminar\" eliminado exitosamente.'); window.location.href = 'carpeta.php';</script>";
                } else {
                    echo "<script>alert('El archivo \"$archivoAEliminar\" no existe o es una carpeta.');</script>";
                }
            }

            ?>

        </ul>
    </div>
</body>

</html>