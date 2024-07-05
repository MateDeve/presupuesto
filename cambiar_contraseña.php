<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/estilos.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- También puedes descargar Bootstrap e incluirlo desde tu servidor local -->
</head>
<body>

<div class="container mt-5">
    <div style="text-align: center;"><?php include "includes/sesion.php"; ?></div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Ingresa la nueva contraseña</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="cambiar_contraseña.php">
                        <div class="form-group">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="pass" placeholder="Ingrese su contraseña">
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    session_start();
    if(!empty($_SESSION['id_usuario'])){
        if(!empty($_POST['pass'])){
            $new_pass = $_POST['pass'];
            $user = $_SESSION['id_usuario'];

            include 'includes/conexion.php';

            $query = mysqli_query($enlace, "update usuarios set contraseña = '$new_pass', status = 1 where id_usuario = '$user'") or 
                                    die("Fue imposible actualizar la contraseña: " . mysqli_error($enlace));
            
            header('Location: index.php');

        }

    }

?>
<!-- Agrega la referencia a Bootstrap JS y Popper.js (necesarios para algunas funciones de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>