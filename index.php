<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación Presupuesto</title>
    <link rel="stylesheet" href="css/estilos.css"/>
</head>
<body onload="cargarValores()">
    <div class="cabecero">
        <div class="presupuesto"> 
            <div style="text-align: center;"><?php include "includes/sesion.php"; ?></div>
            <div class="presupuesto_titulo">
                Presupuesto Disponible
                <button class="btn-out" style="float: right;"><a href="logout.php">Salir</a></button>
            </div>
            <div class="presupuesto_valor" id="presupuesto"></div>
            <div class="presupuesto_ingreso limpiarEstilos">
                <div class="presupuesto_ingreso--texto">Ingresos</div>
                <div class="derecha">
                    <div class="presupuesto_ingreso--valor" id="ingresos"></div>
                    <div class="presupuesto_ingreso--porcentaje">&nbsp;</div>
                </div>
            </div>
            <div class="presupuesto_egreso limpiarEstilos">
                <div class="presupuesto_egreso--texto">Egresos</div>
                <div class="derecha limpiarEstilos">
                    <div class="presupuesto_egreso--valor" id="egresos"></div>
                    <div class="presupuesto_egreso--porcentaje" id="porcentaje"></div>
                </div>
            </div>
        </div>
    </div>

    <form id="forma" method="POST" action="queries/agregar_registro.php">
        <div class="agregar">
            <div class="agregar_contenedor">
                <select class="agregar_tipo" id="tipo" name="tipo">
                    <option value="Ingreso" selected>+</option>
                    <option value="Egreso">-</option>
                </select>
                <input type="text" class="agregar_descripcion"
                placeholder="Agregar Descripcion" id="descripcion" name="descripcion">
                <input type="number" class="agregar_valor"
                placeholder="Valor" id="valor" name="valor">
                <button class="agregar_btn">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                </button>
            </div>
        </div>
    </form>

    <div class="contenedor limpiarEstilos">
        <div class="ingreso">
            <h2 class="ingreso_titulo">Ingresos</h2>
            <div id="lista-ingresos">
                <?php
                    include 'includes/conexion.php';
                    $ingresos = mysqli_query($enlace, "select * from registro where tipo = 'Ingreso'") or 
                                            die("Imposible traer la lista de Ingresos: " . mysqli_error($enlace));
                    while($ingreso = mysqli_fetch_array($ingresos, MYSQLI_ASSOC)){
                        $fecha = $ingreso['fecha'];
                        $fecha_objeto = new DateTime($fecha);
                        $fecha_formato = $fecha_objeto->format("d-m-y");
                        echo '<div class="elemento limpiarEstilos">
                                    <div class="elemento_descripcion">' . $ingreso["descripcion"] . '</div>
                                    <div class="derecha limpiarEstilos">
                                        <div class="elemento_valor">+ $' . number_format($ingreso["total"], "2", ",", ".") . ' ' . '</div>
                                        <div class="elemento_valor">/' . $fecha_formato . '</div>
                                        <div class="elemento_eliminar">
                                            <button class="elemento_eliminar--btn">
                                                <ion-icon name="trash-outline"
                                                onclick="eliminarIngreso(' . $ingreso["id_registro"] . ')"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>';
                    }
                ?>
            </div>
        </div>
        <div class="egreso">
            <h2 class="egreso_titulo">Egresos</h2>
            <div id="lista-egresos">
                <?php
                    $egresos = mysqli_query($enlace, "select * from registro where tipo = 'Egreso'") or 
                                            die("Imposible traer la lista de egresos: " . mysqli_error($enlace));
                    while($egreso = mysqli_fetch_array($egresos, MYSQLI_ASSOC)){
                        $fecha = $egreso['fecha'];
                        $fecha_objeto = new DateTime($fecha);
                        $fecha_formato = $fecha_objeto->format("d-m-y");
                        echo '<div class="elemento limpiarEstilos">
                                    <div class="elemento_descripcion">' . $egreso["descripcion"] . '</div>
                                    <div class="derecha limpiarEstilos">
                                        <div class="elemento_valor">- $' . number_format($egreso["total"], "2", ",", ".") . '</div>
                                        <div class="elemento_valor">/' . $fecha_formato . '</div>
                                        <div class="elemento_eliminar">
                                            <button class="elemento_eliminar--btn">
                                                <ion-icon name="trash-outline"
                                                onclick="eliminarIngreso(' . $egreso["id_registro"] . ')"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>';
                    }
                    mysqli_close($enlace);
                ?>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function cargarValores(){
            resultadosArr = [];
            presupuesto = document.getElementById('presupuesto');
            ingresos = document.getElementById('ingresos');
            egresos = document.getElementById('egresos');
            porcentaje_egresos = document.getElementById('porcentaje');
            $.ajax({
                url: 'queries/buscar_valores.php',
                success: function(response) {
                    resultados = response;
                    resultadosArr = resultados.split('/');
                    presupuesto.innerHTML = formatoMoneda(parseInt(resultadosArr[0]));
                    ingresos.innerHTML = formatoMoneda(parseInt(resultadosArr[1]));
                    egresos.innerHTML = formatoMoneda(parseInt(resultadosArr[2]));
                    porcentaje_egresos.innerHTML = formatoPorcentaje(parseFloat(resultadosArr[3]));
                }
            });
        }

        const formatoMoneda = (valor) =>{
            return valor.toLocaleString('en-US', {style:'currency', currency:'USD', minimumFractionDigits:2});
        }

        const formatoPorcentaje = (valor) =>{
            
            return valor.toLocaleString('en-US', {style:'percent', minimumFractionDigits:2});
        }

        function eliminarIngreso(registro){
            $.ajax({
                url: 'queries/eliminar_registro.php',
                type: 'POST',
                data: {valor: registro},
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>