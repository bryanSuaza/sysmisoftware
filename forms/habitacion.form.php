<?php

require("./class/db.class.php");
require("./class/habitacionDTO.php");
require("./class/habitacionDAO.php");

$habitacion_id = filter_input(INPUT_GET, "habitacion_id", FILTER_SANITIZE_NUMBER_INT);
 
$habitacionDTO = new habitacionDTO();
$habitacionDAO = new habitacionDAO(); 

$tipo_habitacion = $habitacionDAO->getTipo_habitacion();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear Habitacion</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
        <div class="panel panel-default">
              <div style="text-align: center;">
              <h2><i class="fa fa-image"></i> HABITACIONES</h2>
              </div>
              <br>
              <div style="text-align: center; padding-left: 70px !important; padding-right: 70px;">
              <img id="imagen" class="img-thumbnail"  src="images/ejemploHabitacion.jpg"  style="height:300px;"/>
              </div>
               <br><br>
             
              <div class="input-group md-form form-sm form-1 pl-0" style="padding-left: 250px !important; padding-right: 250px;">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un habitacion con su número" aria-label="Search">
              </div>
              <br>
              <form id="form" method="POST" enctype="multipart/form-data" style="padding-left: 60px; padding-right: 60px;">
               <div class="form-row">
               
                <div class="col">
                  <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']?>">
                  <input type="hidden" class="form-control" name="habitacion_id" id="habitacion_id">
                  <label>Numero Habitaci&oacute;n</label>
                  <input type="number" class="form-control" placeholder="Digita número habitación" name="numero" id="numero" required>
                  <br>
                  <label>Descripci&oacute;n</label>
                  <textarea class="form-control"  rows="3" name="descripcion" id="descripcion" required></textarea>
                  <br>
                  <label>Tipo</label>
                  <select class="form-control" id="tipo_habitacion_id" name="tipo_habitacion_id">
                    <?php
                     while ($row = mysqli_fetch_array($tipo_habitacion)) {
                      echo '<option value="'.$row['tipo_habitacion_id'].'">'.$row['tipo'].'</option>';
                    }
                    ?>
                  </select>
  
                </div>

                <div class="col">
                  <label>Valor</label>
                  <input type="number" class="form-control" placeholder="Digita valor habitación" name="valor" id="valor" required>
                  <br>
                 <label>Estado</label>
                  <select class="form-control" id="estado" name="estado">
                    <option value="D">DISPONIBLE</option>
                    <option value="O">OCUPADA</option>
                  </select>
                  <br>
                  <label for="foto">Subir Imagen</label>
                  <input type="file" class="form-control" id="foto" name="foto" lang="es">
                </div>

              </div>
              <br>
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
        <script src="js/habitacion.js"></script>
    </body>	
</html>