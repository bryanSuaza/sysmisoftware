<?php

require("./class/db.class.php");
require("./class/parqueaderoDTO.php");
require("./class/parqueaderoDAO.php");

//$producto_id = filter_input(INPUT_GET, "producto_id", FILTER_SANITIZE_NUMBER_INT);
$parqueaderoDTO = new parqueaderoDTO();
$parqueaderoDAO = new parqueaderoDAO(); 

$tipo_vehiculo = $parqueaderoDAO->getTipo_vehiculo();

?>

<!DOCTYPE html>
<html lang="es">
	
	<head>
		<title>Salida Vehículo</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container">
              <div style="text-align: center;">
              <h3><i class="fa fa-motorcycle"></i> Salida Veh&iacute;culo Parqueadero</h3>
              </div>
              <div class="col" style="padding-left: 30px; padding-right: 30px; display: inline-block; text-align: center;"> 
                   <button class="btn btn-info" onclick="reporte()">Listado de Vehículos</button>&nbsp;&nbsp;
                   <button class="btn btn-info" onclick="reporteParqueadero()">Reporte Parqueadero</button>&nbsp;&nbsp;
                   <button class="btn btn-info" onclick="ingresarVehiculo()">Ingreso Vehículo Parqueadero</button>
              </div>
              <br>
              <br>
              <div class="col-md-12">
              <form id="form" style="padding-left: 20px; padding-right: 20px;">
                <div class="col" style="text-align:center">
                  <label>Placa</label>
                  <input type="text" class="form-control placa" name="placa" id="placa" required> 
                </div>
                <br>
               
               <div class="row">
                    <div class="form-group col-md-4">
                    <label>Codigo Ticket</label>
                    <input type="text" class="form-control" name="codigo_ticket" id="codigo_ticket" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Tipo Vehículo</label>
                      <select class="form-control" id="tipo_vehiculo_id" name="tipo_vehiculo_id" readonly="yes">
                      <option value="null">Seleccione</option>
                          <?php
                          while ($row = mysqli_fetch_array($tipo_vehiculo)) {
                          echo '<option value="'.$row['tipo_vehiculo_id'].'">'.$row['tipo'].'</option>';
                          }
                          ?>
                      </select>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Fecha/Hora Ingreso</label>
                      <input type="text" class="form-control" name="fecha_hora_ingreso" id="fecha_hora_ingreso" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Fecha/hora Salida</label>
                      <input type="text" class="form-control" name="fecha_hora_salida" id="fecha_hora_salida" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Valor Hora/Fracción</label>
                      <input type="text" class="form-control" name="valor_hora" id="valor_hora" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Total Dias</label>
                      <input type="text" class="form-control" name="dias" id="dias" readonly="yes">
                    </div>

                     <div class="form-group col-md-4">
                      <label>Total Medios Dias</label>
                      <input type="text" class="form-control" name="medios_dias" id="medios_dias" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Total Horas</label>
                      <input type="text" class="form-control" name="horas" id="horas" readonly="yes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Valor Servicio</label>
                      <input type="text" class="form-control valor" name="valor_servicio" id="valor_servicio" readonly="yes">
                    </div>

                </div>
              <br>
              <div style="text-align: center">
              <?php
               if($_SESSION['guardar']=='SI'){
              ?>
                 <button type="submit" class="btn btn-primary" id="guardar">Finalizar Servicio</button>
                 <button type="submit" class="btn btn-primary" id="imprimir_salida">Imprimir Ticket</button>
              <?php
               }
              ?>
                <button type="submit" class="btn btn-primary" id="limpiar">Limpiar</button>
              </div>
               
               </form>
               </div>
            
        </div>
        <script src="js/salidaParqueadero.js"></script>
    </body>	
</html>