<?php include('cabecera.php'); ?>
<?php include('cursos.php'); ?>
<?php
//seguridad de sesiones para pagina
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion = '') {
    header("Location: login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar cita</title>
</head>
<style>
    body {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        color: white;
        background-color: #fcfcfcf6;
    }


    .btn-container {
        margin-right: 10px;
    }

    .container {

        padding-top: 28px;
        margin-top: 80px;
        background-color: rgba(242, 242, 242, 0.08);
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        padding-bottom: 28px;
        border-radius: 5px;

    }

    .header {
        background-color: #a8a8a8c7;
    }

    .custom-card-header {
        color: white;
    }

    .card-header {
        border-radius: 5px;
        background-color: #FF9900 !important;

    }

    .fa-file-pdf {
        color: #ff5252;
    }

    .card-body {
        border-radius: 5px;
        background-color: rgba(0, 128, 0, 0.2);
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <div class="row">
                <div class="col-md-5">
                    <form action="" method="post">
                        <div class="card ">
                            <div class="card-header text-white">
                                Citas
                            </div>
                            <div class="card-body">
                                <div class="mb-3 d-none">
                                    <label for="id" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id" id="id" value="<?php echo $id; ?>" aria-describedby="helpId" placeholder="ID">

                                </div>
                                <div class="mb-3">
                                    <label for="nombre_curso" class="form-label">Nombre de la cita</label>
                                    <input type="text" class="form-control" name="nombre_curso" id="nombre_curso" value="<?php echo $nombre_curso; ?>" aria-describedby="helpId" placeholder="">

                                </div>
                                <div class="btn-group" role="group" aria-label="Button group name">
                                    <div class="btn-container">
                                        <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
                                    </div>
                                    <div class="btn-container">
                                        <button type="submit" name="accion" value="editar" class="btn btn-primary">Guardar</button>
                                    </div>
                                    <div class="btn-container">
                                        <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
                                    </div>
                                </div>




                            </div>



                        </div>


                    </form>




                </div>


                <div class="col-md-7">

                    <div class="table-responsive">
                        <table class="table table-success">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Editar Cita</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaCursos as $curso) { ?>
                                    <tr class="">
                                        <td> <?php echo $curso['id']; ?></td>
                                        <td><?php echo $curso['nombre_curso']; ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" id="id" value="<?php echo $curso['id']; ?>">
                                                <input type="submit" value="Seleccionar" name="accion" class="btn btn-success">
                                            </form>


                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>

</div>

</html>

<?php include('pie.php'); ?>