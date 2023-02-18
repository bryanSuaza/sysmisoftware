<?php

require("./class/db.class.php");
require("./class/rolDTO.php");
require("./class/rolDAO.php");

$rol_id = filter_input(INPUT_GET, "rol_id", FILTER_SANITIZE_NUMBER_INT);
 
$rolDTO = new rolDTO();
$rolDAO = new rolDAO(); 

$permisos = $rolDAO->getPermisos();

/*if($rol){
  $rolDTO->mapear($rol);
} */

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear rol</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
              <div style="text-align: center;">
              <h2><i class="fa fa-gears"></i> ROLES</h2>
              </div>
              <br>
              <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un rol" aria-label="Search">
              </div>
              <br>
              <form id="form">

                <div class="row">
                    <div class="form-group col-md-4">
                      <input type="hidden" class="form-control" name="rol_id" id="rol_id">
                      <label>Nombre Rol<span style="color:red">*</span></label>
                      <input type="text" class="form-control"  name="rol" id="rol" required>
                    </div>
                  
                   
                    <div class="form-group col-md-4">
                      <label>Permisos<span style="color:red">*</span></label>
                      <select class="form-control" id="permiso_id" multiple required>
                        <?php
                        while ($row = mysqli_fetch_array($permisos)) {
                        echo '<option value="'.$row['permiso_id'].'">'.$row['permiso'].'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  
                    
                    <div class="form-group col-md-4">
                      <label>Estado<span style="color:red">*</span</label>
                      <select class="form-control" id="estado" name="estado">
                        <option value="A">ACTIVO</option>
                        <option value="I">INACTIVO</option>
                      </select>
                    </div>
                </div>
             
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
        <script src="js/rol.js"></script>
    </body>	
</html>