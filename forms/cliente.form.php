<?php

require("./class/db.class.php");
require("./class/clienteDTO.php");
require("./class/clienteDAO.php");

$cliente_id = filter_input(INPUT_GET, "cliente_id", FILTER_SANITIZE_NUMBER_INT);
 
$clienteDTO = new clienteDTO();
$clienteDAO = new clienteDAO(); 

$tipo_persona = $clienteDAO->getTipo_persona();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear Cliente</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
              <div style="text-align: center;">
              <h2><i class="fa fa-user-plus"></i> CLIENTES</h2>
              </div>
              <br>
              <div class="input-group md-form form-sm form-1 pl-0" style="padding-left: 250px !important; padding-right: 250px;">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un cliente con su numero de identificación" aria-label="Search">
              </div>
              <br>
               <!-- Image loader -->
              <div id='loader' style="text-align: center; display: none">
                <img src='./images/loading.gif' width='80px' height='75px'>
              </div>
              <form id="form" style="padding-left: 40px; padding-right: 40px;">
               <div class="form-row">
               
                <div class="col">
                  <input type="hidden" class="form-control" name="cliente_id" id="cliente_id" value="<?php echo $cliente_id ?>">
                  <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']?>">
                  <label>Tipo Persona</label>
                  <select class="form-control" id="tipo_persona_id" name="tipo_persona_id">
                    <?php
                     while ($row = mysqli_fetch_array($tipo_persona)) {
                      echo '<option value="'.$row['tipo_persona_id'].'">'.$row['nombre'].'</option>';
                    }
                    ?>
                  </select>
                  <br>
                  <label>Primer Nombre</label>
                  <input type="text" class="form-control" placeholder="Primer nombre" name="primer_nombre" id="primer_nombre">
                  <br>
                  <label>Segundo Apellido</label>
                  <input type="text" class="form-control" placeholder="Segundo apellido" name="segundo_apellido" id="segundo_apellido">
                  <br>
                  <label>Banco</label>
                  <input type="text" class="form-control" placeholder="Digita nombre banco" name="banco" id="banco">
                  <br>
                  <label>Estado</label>
                  <select class="form-control" id="estado" name="estado">
                    <option value="A">ACTIVO</option>
                    <option value="I">INACTIVO</option>
                  </select>
                </div>

                <div class="col">
                  <label>Numero Identificaci&oacute;n</label>
                  <input type="number" class="form-control" placeholder="Digita numero identificación" name="numero_identificacion" id="numero_identificacion" required>
                  <br>
                  <label>Segundo Nombre</label>
                  <input type="text" class="form-control" placeholder="Segundo nombre" name="segundo_nombre" id="segundo_nombre">
                  <br>
                  <label>Razon Social</label>
                  <input type="text" class="form-control" placeholder="Digita la razon social" name="razon_social" id="razon_social">
                  <br>
                  <label>Numero Cuenta</label>
                  <input type="text" class="form-control" placeholder="Digita numero cuenta bancaria" name="numero_cuenta" id="numero_cuenta">
                </div>

                <div class="col">
                  <label>Digito Verificaci&oacute;n</label>
                  <input type="number" class="form-control" placeholder="Digita digito verificación" name="digito_verificacion" id="digito_verificacion" readonly="readonly">
                  <br>
                  <label>Primer Apellido</label>
                  <input type="text" class="form-control" placeholder="Primer apellido" name="primer_apellido" id="primer_apellido">
                  <br>
                  <label>Telefono</label>
                  <input type="number" class="form-control" placeholder="Digita Telefono" name="telefono" id="telefono" required>
                  <br>
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Digita correo electronico" name="email" id="email" required>
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
        <script src="js/cliente.js"></script>
    </body>	
</html>