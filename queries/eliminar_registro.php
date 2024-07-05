<?php
    $registro = $_POST['valor'];

    include '../includes/conexion.php';

    $query = mysqli_query($enlace, "delete from registro where id_registro = '$registro'") or 
                            die("No es posible eliminar el registro: " . mysqli_error($enlace));

    if($query){
        echo "Registro eliminado correctamente.";
    }
?>