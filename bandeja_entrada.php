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
  <link rel="stylesheet" href="librerias/fontawesome-free-6.4.0-web/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>

<body>
  <h1>Bandeja de Entrada</h1>
   <div class="sidebar">
        <a class="imagen" href="index.php"><img src="css/imagenes/Documento_sin_título-removebg-preview.png" alt="Acomite" width="120px"></a>
        <ul class="iconos">
            <li class="no-esp"><a class="ico" href="index.php"><span class="fas fa-home"></span><label class="label">Menú</label></a>
            </li>
            <li class="no-esp"><a class="ico" href="correo.php"><span class="fas fa-user-graduate"></span><label class="label">Nuevo correo</label></a>
            </li>
            <li class="no-esp"><a class="ico" href="bandeja_entrada.php"><span class="fa-solid fa-file-signature"></span><label class="citar">Bandeja de entrada</label></a>
            </li>

            <li class="no-esp"><a class="ico" href="#"><span class="fa-solid fa-envelopes-bulk"></span><label class="citar">Enviados</label></a>
            </li>

            <li class="no-esp"><a class="ico" href="cerrar_sesion.php"><span class="fa-solid fa-door-open"></span><label class="label">Salir</label></a>
            </li>

        </ul>
    </div>

  <?php
  while ($filaMensaje = $consultaMensajes->fetch(PDO::FETCH_ASSOC)) {
    echo "De: {$filaMensaje['usuarioEnvia']} ({$filaMensaje['correoRemitente']})<br>";
    echo "Mensaje: {$filaMensaje['mensaje']}<br>";
    echo "Fecha: {$filaMensaje['fecha']}<br>";

    // Formulario de respuesta
    echo '<form action="responder_mensaje.php" method="POST">';
    echo '<input type="hidden" name="idMensaje" value="' . $filaMensaje['id'] . '">';
    echo '<input type="hidden" name="correoDestinatario" value="' . $filaMensaje['usuarioEnvia'] . '">';
    echo '<label for="respuesta">Responder a ' . $filaMensaje['usuarioEnvia'] . ':</label><br>';
    echo '<textarea name="respuesta" rows="2" cols="30"></textarea><br>';
    echo '<input type="submit" value="Responder">';
    echo '</form>';

    echo "<hr>";

    echo '<a href="correo.php">Nuevo correo </a><span class="fa-regular fa-paper-plane"></span>';
    
    echo '<br>';
    echo '<span class="fa-solid fa-arrow-left"></span><a href="dash.php"> Volver</a>';
  }
  ?>
</body>

</html>