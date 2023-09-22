<?php
session_start();
require_once("../configuraciones/bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    try {
        $conexion = BD::crearInstancia();

        // Recuperar datos del formulario
        $correoDestinatario = $_POST['correoDestinatario'];
        $respuesta = $_POST['respuesta'];
        $idUsuarioDestino = $_POST['idUsuarioDestino'];
        $usuarioEnvia = $_SESSION['usuario'];

        // Insertar la respuesta en la base de datos
        $insertarRespuesta = $conexion->prepare("INSERT INTO mensajeria (usuarioEnvia, usuarioDestino, mensaje, idUsuarioEnvia) VALUES (:usuarioEnvia, :correoDestinatario, :mensaje, :idUsuarioEnvia)");
        $insertarRespuesta->bindParam(":usuarioEnvia", $usuarioEnvia);
        $insertarRespuesta->bindParam(":correoDestinatario", $correoDestinatario);
        $insertarRespuesta->bindParam(":mensaje", $respuesta);
        $insertarRespuesta->bindParam(":idUsuarioEnvia", $idUsuarioDestino);
        $insertarRespuesta->execute();

        // Redirigir de vuelta a la bandeja de entrada
        header("Location: bandeja_entrada.php");
        exit();
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error en la conexión a la base de datos: " . $e->getMessage();
    }
} else {
    header("Location: bandeja_entrada.php");
    exit();
}
