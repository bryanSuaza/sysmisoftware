<?php

require("./class/db.class.php");
require("./class/parqueaderoDTO.php");
require("./class/parqueaderoDAO.php");
/* require("./class/parqueaderoDTO.php");
require("./class/parqueaderoDAO.php"); */

//$producto_id = filter_input(INPUT_GET, "producto_id", FILTER_SANITIZE_NUMBER_INT);
$parqueaderoDTO = new parqueaderoDTO();
$parqueaderoDAO = new parqueaderoDAO(); 

$tipo_vehiculo = $parqueaderoDAO->getTipo_vehiculo();

?>

<head>
		<title>Tarifas Parqueadero</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container">
              <div style="text-align: center;">
              <h2><i class="fa fa-motorcycle"></i>Tarifas parqueadero</h2>
              </div>
              <br>

               <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca una tarifa" aria-label="Search">
              </div>
              <br>
            
              <div class="col-md-12">
              <form id="form" style="padding-left: 20px; padding-right: 20px;">
        
               
               <div class="row">
                    <div class="form-group col-md-4">
                      <input type="hidden" id="tarifas_parqueadero_id" name="tarifas_parqueadero_id">
                      <label>Tipo Vehículo<span style="color:red">*</span></label>
                      <select class="form-control" id="tipo_vehiculo_id" name="tipo_vehiculo_id">
                      <option value="null">Seleccione</option>
                          <?php
                          while ($row = mysqli_fetch_array($tipo_vehiculo)) {
                          echo '<option value="'.$row['tipo_vehiculo_id'].'">'.$row['tipo'].'</option>';
                          }
                          ?>
                      </select>
                    </div>

                    <div class="form-group col-md-4">
                    <label>Valor Hora/Fracción Diurna<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="valor_hora_diurna" id="valor_hora_diurna" required>
                    </div>

                   <div class="form-group col-md-4">
                    <label>Valor Hora/Fracción Nocturna<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="valor_hora_nocturna" id="valor_hora_nocturna" required>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Valor Medio Dia<span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="valor_medio_dia" id="valor_medio_dia" required>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Valor Día<span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="valor_dia" id="valor_dia" required>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Valor mes<span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="valor_mes" id="valor_mes">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Cobro a Partir De:(min)<span style="color:red">*</span></label>
                      <input type="number" class="form-control" name="tiempo_cobro" id="tiempo_cobro" min="0" max="60" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Estado<span style="color:red">*</span></label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="A">ACTIVO</option>
                            <option value="I">INACTIVO</option>
                        </select>
                    </div>

                </div>
              <br>
              <div style="text-align: center">
              <?php
               if($_SESSION['guardar']=='SI'){
              ?>
                 <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
              <?php
               }
               if($_SESSION['actualizar']=='SI'){
              ?>
                <button type="submit" class="btn btn-primary" id="actualizar">Actualizar</button>
              <?php
               }
               if($_SESSION['eliminar']=='SI'){
              ?>
                <button type="submit" class="btn btn-primary" id="eliminar">Eliminar</button>
              <?php
               }
               ?>  
                <button type="submit" class="btn btn-primary" id="limpiar">Limpiar</button>
              </div>
               
               </form>
               </div>
            
        </div>
        <script src="js/tarifaParqueadero.js"></script>
    </body>	
</html>