<!DOCTYPE html>
<html>

<head>
    <title>Enviar Mensaje</title>
    <link rel="stylesheet" href="librerias/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <?php
    session_start();
    require_once("configuraciones/bd.php"); // Asegúrate de que la ruta sea correcta

    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    try {
        $conexion = BD::crearInstancia();

        // Obtener usuarios con diferente cargo
        $consultaUsuarios = $conexion->prepare("SELECT * FROM usuarios WHERE id_cargo != :id_cargo");
        $consultaUsuarios->bindParam(":id_cargo", $_SESSION['id_cargo']);
        $consultaUsuarios->execute();
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
    }
    ?>

    <!-- Formulario de envío de mensajes -->
    <form action="enviar_mensaje.php" method="POST">
        <label for="destinatario">Destinatario (correo):</label><br>
        <input type="text" name="destinatario" id="destinatario"><br>
        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" id="mensaje" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Enviar mensaje">
    </form>
    <span class="fa-solid fa-inbox"></span><a href="bandeja_entrada.php"> Bandeja</a>
</body>

</html>