<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //AGREGAR EL session_start 
    session_start();
    $varsesion = $_SESSION['usuario'];
    if ($varsesion == null || $varsesion == '') {
        header("Location: login.php");
        die();
    }

    $targetDir = 'files/' . $_SESSION['carpeta_personal'] . '/';   //ESTA REEMPLAZA LA LINEA DE ABAJO

    //$targetDir = 'files/';    //eliminar

    $targetFile = $targetDir . basename($_FILES['file']['name']);   //ACA LE TOCA AÑADIR LA RUTA DEL USUARIO DESPUES DEL files/
    //OSEA QUE LE TOCA CONSULTAR LA CARPETA DEL USUARIO QUE ESTA LOGUEADO 
    //O TRAER ESE DATO EN UNA VARIABLE DE SESIÒN
    //PARA QUE EL ARCHIVO QUEDE EN LA CARPETA DEL USUARIO QUE ESTA LOGUEADO


    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'ppt', 'pptx');
    $fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <style>
        body {

            margin: 0;
            /* Elimina el margen del cuerpo */
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(5, 7, 12, 0.55), rgba(5, 7, 12, 0.55)), url(css/imagenes/Scene-24.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            height: 100vh;
            max-width: 800px;
            padding: 20px;
            box-sizing: border-box;
        }

        .error-message,
        .success-message {
            position: fixed;
            top: 10px;
            /* Ajusta la distancia desde la parte superior según tus preferencias */
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(252, 195, 195, 0.229);
            border: 2px solid rgba(255, 255, 255, .2);
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            z-index: 1000;
            /* Asegura que el mensaje esté por encima del contenido */
        }
    </style>

    <?php
    function showMessage($message, $isSuccess = false, $redirectUrl = null)
    {
        $messageClass = $isSuccess ? 'success-message' : 'error-message';
        echo "<div class='$messageClass'>$message</div>";
        if ($redirectUrl) {
            echo "<script>setTimeout(function() { window.location.href = '$redirectUrl'; }, 3000);</script>";
        }
    }

    // Tu código para comprobar y subir el archivo
    if (file_exists($targetFile)) {
        showMessage('El archivo ya existe.', false, 'dash.php');
    } else if ($_FILES['file']['size'] > 8000000) {
        showMessage('El archivo es demasiado grande.', false, 'dash.php');
    } else if (!in_array($fileType, $allowedFileTypes)) {
        showMessage('Solo se permiten archivos JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, PPT y PPTX.', false, 'dash.php');
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            showMessage('El archivo se ha subido correctamente.', true, 'dash.php');
            exit;
        } else {
            showMessage('Hubo un error al subir el archivo.');
            echo '<script>setTimeout(function() { window.location.href = "dash.php"; }, 3000);</script>';
        }
    }

    ?>


</body>

</html>