<?php
session_start();
require_once("configuraciones/bd.php"); // Asegúrate de que la ruta sea correcta

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $destinatario = $_POST['destinatario'];
  $mensaje = $_POST['mensaje'];

  try {
    $conexion = BD::crearInstancia();

    // Obtener información del usuario actual (remitente)
    $consultaRemitente = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $consultaRemitente->bindParam(":nombre", $_SESSION['nombre_usuario']);
    $consultaRemitente->execute();
    $remitente = $consultaRemitente->fetch(PDO::FETCH_ASSOC);

    // Obtener información del destinatario
    $consultaDestinatario = $conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $consultaDestinatario->bindParam(":correo", $destinatario);
    $consultaDestinatario->execute();
    $destinatario = $consultaDestinatario->fetch(PDO::FETCH_ASSOC);

    // Insertar mensaje en la tabla de mensajería
    $consultaInsertar = $conexion->prepare("INSERT INTO mensajeria (idUsuarioEnvia, usuarioEnvia, mensaje, fecha, idUsuarioDestino, usuarioDestino)
                                                VALUES (:idUsuarioEnvia, :usuarioEnvia, :mensaje, NOW(), :idUsuarioDestino, :usuarioDestino)");
    $consultaInsertar->bindParam(":idUsuarioEnvia", $remitente['id']);
    $consultaInsertar->bindParam(":usuarioEnvia", $remitente['nombre']);
    $consultaInsertar->bindParam(":mensaje", $mensaje);
    $consultaInsertar->bindParam(":idUsuarioDestino", $destinatario['id']);
    $consultaInsertar->bindParam(":usuarioDestino", $destinatario['nombre']);

    if ($consultaInsertar->execute()) {
      header("Location: bandeja_entrada.php"); // Redirigir a la bandeja de entrada
      exit();
    } else {
      // Manejo de error en caso de que la inserción falle
      header("Location: dash.php");
      exit();
    }
  } catch (PDOException $e) {
    // Manejo de errores
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
  }
}
