<?php
session_start();
require_once("configuraciones/bd.php");

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

try {
  $conexion = BD::crearInstancia();

  // Obtener mensajes recibidos para el usuario actual
  $consultaMensajes = $conexion->prepare("SELECT m.*, u.correo AS correoRemitente
                                            FROM mensajeria m
                                            JOIN usuarios u ON m.idUsuarioEnvia = u.id
                                            WHERE m.usuarioDestino = :nombre_usuario");
  $consultaMensajes->bindParam(":nombre_usuario", $_SESSION['nombre_usuario']);
  $consultaMensajes->execute();
} catch (PDOException $e) {
  // Manejo de errores
  echo "Error en la conexión a la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Bandeja de Entrada</title>
</head>

<body>
  <h1>Bandeja de Entrada</h1>

  <?php
  while ($filaMensaje = $consultaMensajes->fetch(PDO::FETCH_ASSOC)) {
    echo "De: {$filaMensaje['usuarioEnvia']} ({$filaMensaje['correoRemitente']})<br>";
    echo "Mensaje: {$filaMensaje['mensaje']}<br>";
    echo "Fecha: {$filaMensaje['fecha']}<br>";

    // Formulario de respuesta
    echo '<form action="responder_mensaje.php" method="POST">';
    echo '<input type="hidden" name="idMensaje" value="' . $filaMensaje['id'] . '">';
    echo '<label for="respuesta">Responder a ' . $filaMensaje['usuarioEnvia'] . ':</label><br>';
    echo '<textarea name="respuesta" rows="2" cols="30"></textarea><br>';
    echo '<input type="submit" value="Responder">';
    echo '</form>';

    echo "<hr>";
  }
  ?>
</body>

</html>