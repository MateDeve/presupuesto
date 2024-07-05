<?php
    $tipo = $_POST['tipo'];
    $total = $_POST['valor'];
    $descripcion = $_POST['descripcion'];

    include '../includes/conexion.php';

    $query = mysqli_query($enlace, "insert into registro (tipo, descripcion, total) values ('$tipo', '$descripcion', '$total')") or 
                            die("Imposible ingresar el registro: " . mysqli_error($enlace));
    if($query){
        header('Location: ../index.php');
    }
?>