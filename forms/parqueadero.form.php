<?php

require("./class/db.class.php");
require("./class/parqueaderoDTO.php");
require("./class/parqueaderoDAO.php");

//$producto_id = filter_input(INPUT_GET, "producto_id", FILTER_SANITIZE_NUMBER_INT);
$parqueaderoDTO = new parqueaderoDTO();
$parqueaderoDAO = new parqueaderoDAO(); 

$tipo_vehiculo = $parqueaderoDAO->getTipo_vehiculo();
$codigo_ticket = $parqueaderoDAO->getCodigo_ticket();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Ingresar Vehículo</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container">
              <div style="text-align: center;">
              <h3><i class="fa fa-motorcycle"></i> Ingreso veh&iacute;culo Parquedero</h3>
              </div>
              <div class="col" style="padding-left: 30px; padding-right: 30px; display: inline-block; text-align: center;"> 
                 <button class="btn btn-info" onclick="reporte()">Listado de Vehículos</button>&nbsp;&nbsp;
                 <button class="btn btn-info" onclick="reporteParqueadero()">Reporte Parqueadero</button>&nbsp;&nbsp;
                 <button class="btn btn-info" onclick="salidaVehiculo()">Salida Vehículo Parqueadero</button>
              </div>
              <br>
              <br>
              <div style="text-align: center">
              <form id="form" style="padding-left: 30px; padding-right: 30px; display: inline-block; text-align: center;">
               <div class="row">

                    <div class="form-group col-md-12">
                      <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']?>">
                      <label>Codigo Ticket</label>
                      <input type="text" class="form-control" name="codigo_ticket" id="codigo_ticket" value="<?php echo $codigo_ticket ?>" readonly="yes" required>
                    </div>

                    <div class="form-group col-md-12">
                      <label>Placa</label>
                      <input type="text" class="form-control placa" name="placa" id="placa" required>
                    </div>

                    <div class="form-group col-md-12">
                      <label>Tipo Vehículo</label>
                        <select class="form-control" id="tipo_vehiculo_id" name="tipo_vehiculo_id" required>
                        <option value="null">Seleccione</option>
                          <?php
                          while ($row = mysqli_fetch_array($tipo_vehiculo)) {
                            echo '<option value="'.$row['tipo_vehiculo_id'].'">'.$row['tipo'].'</option>';
                          }
                          ?>
                        </select>
                    </div>

                    
                          <div class="form-group col-md-3">    
                                    <label  for="por_horas">Por Horas</label>
                                    <input type="checkbox" id="por_horas" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                          </div> 
                          <div class="form-group col-md-3">     
                                    <label for="por_mes">Por Mes&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="checkbox" id="por_mes" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                          </div>
                          <div class="form-group col-md-3"> 
                                    <label  for="por_medio">Por Medio Dia&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="checkbox" id="por_medio" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                          </div>
                          <div class="form-group col-md-3">  
                                    <label for="por_dia">Por Dia&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="checkbox" id="por_dia" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                          </div> 
                        
                    </div>
              </div>
              <br>
              <div style="text-align: center">
              <?php
               if($_SESSION['guardar']=='SI'){
              ?>
                 <button type="submit" class="btn btn-primary" id="guardar">Ingresar</button>
              <?php
               }
              ?>
                <button type="submit" class="btn btn-primary" id="limpiar">Limpiar</button>
              </div>
               
               </form>
               </div>
            
        </div>
        <script src="js/parqueadero.js"></script>
    </body>	
</html>