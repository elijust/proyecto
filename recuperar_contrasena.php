<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $contrasena_actual = $_POST["contrasena"];
  $nueva_contrasena = $_POST["nueva_contrasena"];

  require_once("configuraciones/bd.php");

  try {
    $conexion = BD::crearInstancia();

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $consulta->bindParam(":nombre", $nombre);
    $consulta->execute();

    $usuarioInfo = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuarioInfo) {
      // Verificar si la contraseña actual es válida o si es una contraseña temporal
      if (password_verify($contrasena_actual, $usuarioInfo['contraseña']) || esTemporal($usuarioInfo['contraseña'])) {
        if (!validarContrasena($nueva_contrasena)) {
          echo '<div class="error">La nueva contraseña debe tener al menos 8 caracteres, una mayúscula y un número <span class="fa-solid fa-gear"></span></div>';
        } else {
          $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
          $actualizar = $conexion->prepare("UPDATE usuarios SET contraseña = :contrasena WHERE nombre = :nombre");
          $actualizar->bindParam(":contrasena", $contrasena_hash);
          $actualizar->bindParam(":nombre", $nombre);
          $actualizar->execute();

          // Mensaje de éxito con estilo
          echo '<div class="mensaje-exito">Contraseña actualizada con éxito <span class="fa-solid fa-circle-check"></span></div>';
        }
      } else {
        // Mensaje de error si la contraseña actual no es válida
        echo '<div class="mensaje-error">Contraseña actual incorrecta <span class="fa-solid fa-circle-xmark"></span></div>';
      }
    } else {
      // Mensaje de error si el usuario no existe
      echo '<div class="mensaje-error">Usuario no encontrado <span class="fa-solid fa-user-xmark"></span></div>';
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function validarContrasena($contrasena)
{
  return preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $contrasena);
}

function esTemporal($contrasena)
{
  return strpos($contrasena, "temp_pass_") === 0;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="contra_recu.css" />
  <link rel="stylesheet" href="librerias/fontawesome-free-6.4.0-web/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <title>Actualizar contraseña</title>
</head>
<style>
  .mensaje-exito,
  .mensaje-error {
    position: fixed;
    top: 20%;
    /* Posición vertical al 50% de la pantalla */
    left: 50%;
    /* Posición horizontal al 50% de la pantalla */
    transform: translate(-50%, -50%);
    /* Centrar el mensaje */
    background-color: rgba(242, 242, 242, 0.08);
    border: 2px solid rgba(255, 255, 255, .2);

    /* o #f44336 para error */
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
  }

  /* Estilos para el mensaje de éxito */
  .mensaje-exito {
    background-color: #4caf50;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 3px;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
  }

  /* Estilos para el mensaje de error */
  .mensaje-error {
    background-color: red;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 3px;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
  }

  .error {
    position: fixed;
    top: 20%;
    /* Posición vertical al 50% de la pantalla */
    left: 50%;
    /* Posición horizontal al 50% de la pantalla */
    transform: translate(-50%, -50%);
    /* Centrar el mensaje */
    background-color: rgba(242, 242, 242, 0.08);
    border: 2px solid rgba(255, 255, 255, .2);

    /* o #f44336 para error */
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    background-color: red;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 3px;
    width: 47rem;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
  }

  .wrapper input[type="submit"] {
    width: 100%;
    height: 45px;
    background: #FF9900;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    font-size: 16px;
    color: #fff;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s ease;
    margin-bottom: 5px;
  }

  a {
    padding-top: 3px;
    text-decoration: none;
    color: white;
    transition: 0.1s;
  }

  a:hover {
    text-decoration: none;
    transition: 0.1s;
  }

  input[type="submit"]:hover {
    color: #f2f2f2;
    background-color: #E58E00;
  }
</style>

<body>
  <div class="wrapper">
    <form action="recuperar_contrasena.php" method="post">
      <h1>Actualizar Contraseña</h1>
      <div class="input-box">
        <div class="text">
          <input type="text" placeholder="Nombre y Apellido" name="nombre" required /> <!-- Cambiado de "Usuario" a "Nombre" -->
          <i class="bx bxs-user"></i>
        </div>
      </div>
      <div class="input-box">
        <div class="text">
          <input type="password" placeholder="Contraseña actual" name="contrasena" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Nueva Contraseña" name="nueva_contrasena" required />
        <i class="bx bxs-lock-open-alt"></i>
      </div>
      <input type="submit" value="Recuperar Contraseña" id="submitButton" />
      <a href="login.php" class="volver"><span class="fa-solid fa-arrow-left"></span> Volver</a>
    </form>
  </div>
</body>

</html>