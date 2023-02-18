<?php

require("./class/db.class.php");
require("./class/productoDTO.php");
require("./class/productoDAO.php");

$producto_id = filter_input(INPUT_GET, "producto_id", FILTER_SANITIZE_NUMBER_INT);
$productoDTO = new productoDTO();
$productoDAO = new productoDAO(); 

$categoria = $productoDAO->getCategoria();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear producto</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
              <div style="text-align: center;">
              <h2><i class="fa fa-product-hunt"></i> PRODUCTOS</h2>
              </div>
              <br>
              <div class="input-group md-form form-sm form-1 pl-0" style="padding-left: 300px !important; padding-right: 300px;">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca un producto" aria-label="Search">
              </div>
              <br>
              <form id="form" style="padding-left: 200px; padding-right: 200px;">
               <div class="form-row">
               
                <div class="col">
                  <label>Codigo</label>
                  <input type="text" class="form-control" name="producto_id" id="producto_id" readonly="yes">
                  <br>
                  <label>Valor Costo</label>
                  <input type="text" class="form-control"  name="valor_costo" id="valor_costo" required>   
                </div>

                <div class="col">
                  <label>Nombre Producto</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" required>
                  <br>
                  <label>Valor Venta</label>
                  <input type="text" class="form-control" name="valor_venta" id="valor_venta" required>
                </div>

                <div class="col">
                 <label>Categoria</label>
                  <select class="form-control" id="categoria_id" name="categoria_id" required>
                  <option value="null">Seleccione</option>
                    <?php
                     while ($row = mysqli_fetch_array($categoria)) {
                      echo '<option value="'.$row['categoria_id'].'">'.$row['nombre'].'</option>';
                    }
                    ?>
                  </select>
                  <br>
                  <label>Estado</label>
                  <select class="form-control" id="estado" name="estado">
                    <option value="A">ACTIVO</option>
                    <option value="I">INACTIVO</option>
                  </select> 
                              
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
        <script src="js/producto.js"></script>
    </body>	
</html>