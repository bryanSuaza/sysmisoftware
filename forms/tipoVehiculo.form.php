
<?php

require("./class/db.class.php");

?>
<head>
		<title>Tipos de Vehiculos</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container">
              <div style="text-align: center;">
              <h2><i class="fa fa-th-list"></i>Tipos de veh&iacute;culos</h2>
              </div>
              <br>

               <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un tipo de vehiculo por nombre" aria-label="Search">
              </div>
              <br>
            
              <div class="col-md-12">
              <form id="form" style="padding-left: 20px; padding-right: 20px;">
        
               
               <div class="row">
        

                    <div class="form-group col-md-6">
                    <input type="hidden" id="tipo_vehiculo_id" name="tipo_vehiculo_id">
                    <label>Nombre / Tipo: <span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="tipo" id="tipo" required>
                    </div>

                    <div class="form-group col-md-6">
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
        <script src="js/tipoVehiculo.js"></script>
    </body>	
</html>