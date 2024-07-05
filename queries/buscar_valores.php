<?php
    include '../includes/conexion.php';
    $total_ingresos = 0;
    $total_egresos = 0;
    $registros = mysqli_query($enlace, "select total, tipo from registro") or
                            die("Imposible traer la suma: " . mysqli_error($enlace));

    while($registro = mysqli_fetch_array($registros, MYSQLI_ASSOC)){
        if($registro['tipo'] == 'Ingreso'){
            $total_ingresos += $registro['total'];
        }
        else if($registro['tipo'] == 'Egreso'){
            $total_egresos += $registro['total'];
        }
    }
    $total_presupuesto = $total_ingresos - $total_egresos;
    $porcentaje_egresos = $total_egresos / $total_ingresos;
    mysqli_close($enlace);
    echo $total_presupuesto . '/' . $total_ingresos . '/' . $total_egresos . '/' . $porcentaje_egresos;
?>