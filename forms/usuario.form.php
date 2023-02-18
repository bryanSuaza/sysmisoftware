<?php

require("./class/db.class.php");
require("./class/usuarioDTO.php");
require("./class/usuarioDAO.php");

$usuario_id = filter_input(INPUT_GET, "usuario_id", FILTER_SANITIZE_NUMBER_INT);

$usuarioDTO = new usuarioDTO();
$usuarioDAO = new usuarioDAO(); 

$rol = $usuarioDAO->getRol();
$tipo_persona = $usuarioDAO->getTipo_persona();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear Usuario</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
              <div style="text-align: center;">
              <h2><i class="fa fa-user"></i> USUARIOS</h2>
              </div>
              <br>
              <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>

                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un usuario con su numero de identificación" aria-label="Search">
              </div>
              <br>
              <!-- Image loader -->
              <div id='loader' style="text-align: center; display: none">
                <img src='./images/loading.gif' width='80px' height='75px'>
              </div>
              <form id="form" style="padding-left: 40px; padding-right: 40px;">
               <div class="row">
                    <div class="form-group col-md-4">
                      <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $usuario_id ?>">
                      <label>Tipo Persona<span style="color:red">*</span></label>
                      <select class="form-control" id="tipo_persona_id" name="tipo_persona_id">
                        <?php
                        while ($row = mysqli_fetch_array($tipo_persona)) {
                          echo '<option value="'.$row['tipo_persona_id'].'">'.$row['nombre'].'</option>';
                        }
                        ?>
                      </select>
                  </div>
                  
                  <div class="form-group col-md-4">
                    <label>Primer Nombre<span style="color:red">*</span></label>
                    <input type="text" class="form-control"  name="primer_nombre" id="primer_nombre" required>
                  </div>

                  
                  <div class="form-group col-md-4">
                      <label>Segundo Nombre</label>
                      <input type="text" class="form-control"  name="segundo_nombre" id="segundo_nombre">
                  </div>

                  
                  <div class="form-group col-md-4">
                    <label>Primer Apellido<span style="color:red">*</span></label>
                    <input type="text" class="form-control"  name="primer_apellido" id="primer_apellido" required>
                  </div>

                
                <div class="form-group col-md-4">
                   <label>Segundo Apellido</label>
                   <input type="text" class="form-control"  name="segundo_apellido" id="segundo_apellido">
                </div>
                
                <div class="form-group col-md-4">
                  <label>Numero Identificaci&oacute;n<span style="color:red">*</span></label>
                  <input type="number" class="form-control"  name="numero_identificacion" id="numero_identificacion" required>
                </div>

                <div class="form-group col-md-4">
                  <label>Telefono<span style="color:red">*</span></label>
                  <input type="number" class="form-control"  name="telefono" id="telefono" required>
                </div>
                
                <div class="form-group col-md-4">
                  <label>Email<span style="color:red">*</span></label>
                  <input type="email" class="form-control"  name="email" id="email" required>
                </div>

                <div class="form-group col-md-4">
                  <label>Usuario<span style="color:red">*</span></label>
                  <input type="text" class="form-control"  name="username" id="username" required>
                </div>

                <div class="form-group col-md-4">
                  <label>Password<span style="color:red">*</span></label>
                  <input type="text" class="form-control"  name="password" id="password" required>
                </div>

                <div class="form-group col-md-4">
                  <label>Rol<span style="color:red">*</span></label>
                  <select class="form-control" id="rol_id" name="rol_id">
                    <?php
                     while ($row = mysqli_fetch_array($rol)) {
                      echo '<option value="'.$row['rol_id'].'">'.$row['rol'].'</option>';
                    }
                    ?>
                  </select>
                  </div>



                  <div class="form-group col-md-4">
                    <label>Estado<span style="color:red">*</span></label>
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
        <script src="js/usuario.js"></script>
    </body>	
</html>