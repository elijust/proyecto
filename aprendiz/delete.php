
<?php

session_start();
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
    header("Location: login.php");
    die();
}

if (isset($_GET['file'])) {
    $fileToDelete = $_GET['file'];
    $fullPath = 'files/' . $_SESSION['carpeta_personal'] . '/' . $fileToDelete;

    if (is_dir($fullPath)) { // Verificar si es una carpeta
        if (eliminarCarpeta($fullPath)) {
            echo "<script>alert('La carpeta ha sido eliminada correctamente.'); window.location.href = 'dash.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar la carpeta.'); window.location.href = 'dash.php';</script>";
        }
    } elseif (file_exists($fullPath)) { // Verificar si es un archivo
        unlink($fullPath);
        echo "<script>alert('El archivo ha sido eliminado correctamente.'); window.location.href = 'dash.php';</script>";
    } else {
        echo "<script>alert('El archivo o carpeta no existe.'); window.location.href = 'dash.php';</script>";
    }
    exit; // Terminar la ejecución después de la redirección
}

function eliminarCarpeta($ruta)
{
    if (!file_exists($ruta)) {
        return false;
    }

    $archivos = array_diff(scandir($ruta), array('.', '..'));
    foreach ($archivos as $archivo) {
        if (is_dir("$ruta/$archivo")) {
            eliminarCarpeta("$ruta/$archivo");
        } else {
            unlink("$ruta/$archivo");
        }
    }

    return rmdir($ruta);
}

?>
