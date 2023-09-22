<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $contraseña = $_POST['contraseña'];

  require_once("configuraciones/bd.php");

  try {
    $conexion = BD::crearInstancia();

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $consulta->bindParam(":nombre", $nombre);
    $consulta->execute();

    $fila = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
      if (strpos($fila['contraseña'], 'temp_pass_') !== false) {
        if (strtotime($fila['contraseña_expiracion']) <= time()) {
          // Mensaje de contraseña expirada
          echo '<div class="mensaje-error">La contraseña temporal ha expirado. Debes actualizarla <span class="fa-solid fa-clock"></span></div>';
        } else {
          $_SESSION['cambio_contraseña'] = true;
          header("Location: recuperar_contrasena.php");
          exit();
        }
      }
      if (password_verify($contraseña, $fila['contraseña'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['nombre_usuario'] = $fila['nombre'];
        $_SESSION['carpeta_personal'] = $fila['carpeta_personal'];

        if ($fila['id_cargo'] == 1) {
          header("Location: admin/admin.php");
          exit();
        } elseif ($fila['id_cargo'] == 2) {
          header("Location: index.php");
          exit();
        } elseif ($fila['id_cargo'] == 3) {
          header("Location: aprendiz/index.php");
          exit();
        }
      }
    }

    // Si llegamos aquí, el usuario o la contraseña son incorrectos
    header("Location: error_sesion.html");
    exit();
  } catch (PDOException $e) {
    // Redirigir a la página de error
    header("Location: error_sesion.html");
    exit();
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="librerias/fontawesome-free-6.4.0-web/css/all.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <title>Iniciar Sesion</title>
</head>

<style>
  /* Estilos para el loader */
  .loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #005833dd;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
    display: none;
    /* Ocultar el loader inicialmente */
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>

<body>
  <div class="wrapper">
    <form action="login.php" method="post" id="loginForm" onsubmit="return validarFormulario()">
      <img src="css/imagenes/Documento_sin_título-removebg-preview.png" alt="" />
      <h1>Iniciar Sesion</h1>

      <div class="input-box">
        <div class="text">
          <input type="text" placeholder="Nombre y Apellido" name="nombre" required />
          <i class="bx bxs-user"></i>
        </div>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Contraseña" name="contraseña" required />
        <i class="bx bxs-lock-alt"></i>
      </div>

      <div class="remember-forgot">
        <label><a href="recuperar_contrasena.php">Actualizar contraseña </a><span class="fa-regular fa-pen-to-square"></span></label>
      </div>

      <input type="submit" value="Ingresar" id="submitButton" />
      <div id="loader" class="loader"></div>
    </form>

  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const loginForm = document.getElementById("loginForm");
      const submitButton = document.getElementById("submitButton");
      const loader = document.getElementById("loader");

      loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        // Mostrar el loader y deshabilitar el botón de envío
        loader.style.display = "block";
        submitButton.disabled = true;

        // Simular un retraso para demostrar el loader (puedes eliminar esto en producción)
        setTimeout(function() {
          // Envía el formulario (puedes hacerlo con AJAX si es necesario)
          loginForm.submit();
        }, 1000); // Cambia este valor al tiempo que quieras simular

      });
    });
  </script>
</body>

</html>