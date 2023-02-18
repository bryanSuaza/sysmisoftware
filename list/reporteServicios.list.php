<?php

require ("./class/db.class.php");
require ("./class/servicioDTO.php");
require ("./class/servicioDAO.php");

$servicioDTO = new servicioDTO();
$servicioDAO = new servicioDAO();

$servicios = $servicioDAO->listarServicios();

?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Lista Servicios</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="frameworks/bootstrap/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="frameworks/bootstrap/css/responsive.bootstrap4.min.css">
	</head>
	<body>
	<div class="container">
      <div class="row">
        <div class="table-responsive">
            <div class="table-wrapper-scroll-y my-custom-scrollbar" style="padding-left: 20px; padding-right: 20px;">
              <table id="table_servicios" class="table table-striped table-bordered" style="width:100%">
              <div style="text-align: center;">
              <h3><i class="fa fa-table"></i> Lista Servicios</h3>
              </div>
              <br>
                <thead class="table-info">
                    <tr>
                        <th style="text-align: left" scope="col">Cod</th>
                        <th style="text-align: left" scope="col">Cliente</th>
                        <th style="text-align: left" scope="col">Num Ident</th>
                        <th style="text-align: left" scope="col">Habitacion</th>
                        <th style="text-align: left" scope="col">Productos</th>
                        <th style="text-align: left" scope="col">Fecha/hora</th>
                        <th style="text-align: left" >Valor</th>  
                        <th style="text-align: left" >Estado</th>
                        <th style="text-align: left" >Opcion</th>  
                    </tr>
                </thead>
                <tbody>
                	<?php
                    if ($servicios != "") {
                        while ($servicio = mysqli_fetch_array($servicios)) {
                                ?>
                            <tr>
                                <td>
                                    <?php echo $servicio['servicio_id']?>
                                </td>
                                <td>
                                    <?php echo $servicio['cliente']?>
                                </td>
                                <td>
                                    <?php echo $servicio['numero_identificacion']?>
                                </td>
                                <td>
                                    <?php echo $servicio['habitacion']?>
                                </td>
                                 <td>
                                    <?php echo $servicio['producto']?>
                                </td>
                                 <td>
                                    <?php echo $servicio['fecha']."-".$servicio['hora']?>
                                </td>
                                 <td>
                                    <?php echo $servicio['valor']?>
                                </td>
                                 <td>
                                    <?php echo $servicio['estado']?>
                                </td>
                                <td>   
                                    <button class="btn btn-primary" onclick="verServicio(<?php echo $servicio['servicio_id']?>)"><a class="fa fa-pencil"></a></button>
                                </td>
                            </tr> 
                            <?php
                        }
                    } 
                    ?>
                </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
         <script src="js/servicio.js"></script>
    </body>
</html>