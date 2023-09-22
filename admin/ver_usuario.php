<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>
    <style>
        body {
            background: linear-gradient(rgba(5, 7, 12, 0.52), rgba(5, 7, 12, 0.52)), url(../css/imagenes/123Z_2101.w020.n001.947B.p15.947.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            backdrop-filter: blur(3px);

        }

        /* Estilos para el contenedor */
        .table-container {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            margin-top: 3.7rem;
            margin-top: 5.5rem;
            background-color: rgba(252, 195, 195, 0.04);
            border-radius: 10px;
            position: relative;
            backdrop-filter: blur(3px);

            /* Ajusta la cantidad de margen superior según tu preferencia */
        }

        /* Estilos para el título */
        h1 {
            margin-left: 22rem;
            margin-bottom: 10px;
            /* Ajusta el margen inferior del título según tu preferencia */
        }

        /* Estilos para la tabla */
        table {
            border-collapse: collapse;
            width: 55%;
            max-width: 600px;
            /* Ancho máximo de la tabla */
            overflow-y: auto;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: rgba(0, 88, 51, 0.5);
        }

        th {
            background-color: #005833;
        }

        .custom-button {
            font-size: 17px;
            background-color: #005833;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 14px;
        }

        .custom-button:hover {
            background-color: #004724;
        }
    </style>
</head>

<body>
    <h1>Lista de Usuarios</h1>
    <div class="table-container">

        <?php
        include_once("../configuraciones/bd.php");

        // Obtener la instancia de la conexión PDO
        $conexion = BD::crearInstancia();

        // Realizar la consulta para obtener todos los usuarios
        $consulta = "SELECT id, nombre, usuario FROM usuarios";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->rowCount() > 0) {
            // Crear una tabla para mostrar los usuarios
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Usuario</th></tr>";

            // Iterar sobre los resultados y mostrar los usuarios en filas de la tabla
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['usuario'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron usuarios.";
        }
        ?>
        <button class="custom-button" onclick="location.href = 'admin.php';">Ir al menú</button>
    </div>
</body>

</html>