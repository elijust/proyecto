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


    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Comprobar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "<script>alert('El archivo ya existe.');</script>";
        $uploadOk = 0;
    }

    // Limitar el tamaño del archivo (opcional)
    if ($_FILES['file']['size'] > 8000000) { // 8 MB 
        echo "<script>alert('El archivo es demasiado grande.');</script>";
        $uploadOk = 0;
    }

    // Permitir solo ciertos tipos de archivo
    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'ppt', 'pptx');

    if (!in_array($fileType, $allowedFileTypes)) {
        echo "<script>alert('Solo se permiten archivos JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, PPT y PPTX.');</script>";
        $uploadOk = 0;
    }

    // Si todo está bien, intentar subir el archivo
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo "<script>alert('El archivo se ha subido correctamente.'); window.location.href = 'aprendiz.php';</script>";
            exit; // Terminar la ejecución después de la redirección
        } else {
            echo "<script>alert('Hubo un error al subir el archivo.');</script>";
        }
    }
}
