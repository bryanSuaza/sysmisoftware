<?php

require("./class/db.class.php");
require("./class/servicioDTO.php");
require("./class/servicioDAO.php");

$servicio_id = filter_input(INPUT_GET, "servicio_id", FILTER_SANITIZE_NUMBER_INT);
 
$servicioDTO = new servicioDTO();
$servicioDAO = new servicioDAO();

$habitaciones = $servicioDAO -> getHabitaciones();
$habitaciones_clon = $servicioDAO -> getHabitaciones();
$productos = $servicioDAO -> getProductos();
$productos_clon = $servicioDAO -> getProductos();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Servicio Reserva</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
        <div class="panel panel-default">
              <div style="text-align: center;">
              <h2><i class="fa fa-book"></i> SERVICIO</h2>
              </div>
              <br>
    
              <div class="input-group md-form form-sm form-1 pl-0" style="padding-left: 250px !important; padding-right: 250px;">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca una reserva con el numero de identificacion del cliente" aria-label="Search">
              </div>
              <br>

              <form id="form" style="padding-left: 20px; padding-right: 20px;">
               <div class="form-row">
               
                <div class="col-sm">
            
                  <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']?>">
                  <label>Codigo</label>
                  <input type="number" class="form-control" placeholder="codigo" name="servicio_id" id="servicio_id" value="<?php echo $servicio_id ?>" readonly>
                  <br>
                  <label>Fecha</label>
                  <input type="text" class="form-control" name="fecha" id="fecha" required>
                </div>

                <div class="col-sm">
                  <label>Cliente</label>
                  <input type="hidden" class="form-control"  name="cliente_id" id="cliente_id" required>
                  <input type="text" class="form-control" placeholder="Digita número identificación cliente" name="cliente" id="cliente" required>
                  <br>
                  <label>Hora</label>
                  <input type="time" class="form-control"  name="hora" id="hora" required>
                </div>

                <div class="col-sm">
                 <label>Numero Identificación</label>
                  <input type="number" class="form-control" name="numero_identificacion" id="numero_identificacion" readonly>
                  <br>
                  <label>Estado</label>
                  <select class="form-control" id="estado" name="estado" disabled>
                    <option value="A">ACTIVO</option>
                    <option value="F">FACTURADO</option>
                    <option value="I">ANULADO</option>
                  </select>
                </div>

              </div>
              <br>
              <br>
              <div class="col-sm-12" style="text-align: center">
              <?php
               if($_SESSION['guardar']=='SI'){
              ?>
                 <button type="submit" class="btn btn-primary" id="guardar">Continuar</button>
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
              <br>
              <section id="detalles_servicio">
               <div style="text-align:rigth;">
               
                <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#modal_habitacion"><i class="fa fa-image"></i> Habitacion</button>
                <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#modal_producto"><i class="fa fa-product-hunt"></i> Producto</button>
              </div>
              <br>
              <div style="text-align:center;">
               <table class="table table-bordered table-striped" id="detalles">
                 <thead class="table-primary">
                    <tr>
                    <th scope="col">Concepto</th>
                    <th scope="col">Observacion</th>
                    <th scope="col">Cant/Dias</th>
                    <th scope="col">Valor</th>
                    <th scope="co" colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
               </table>
               
               </div>
                <div style="width:20%; background-color: #B8DAFF; text-align:center; margin-left: 400px;" >
                <label><b>Valor Total Servicio</b></label>
                <input type="text" class="form-control" name="total" id="total" readonly>
                </div>
              </section>




              <!-- Modal Habitacion guardar -->
              <div class="modal fade" id="modal_habitacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar habitación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="habitacion" class="col-form-label">Habitacion</label>
                            <select class="form-control" id="habitacion_id" name="habitacion_id" required>
                              <option value="null">Seleccione</option>
                              <?php
                              while ($row = mysqli_fetch_array($habitaciones)) {
                              echo '<option value="'.$row['habitacion_id'].'">'.$row['numero'].'-'.$row['descripcion'].'</option>'; 
                              } 
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="observacion" class="col-form-label">Observación:</label>
                            <textarea class="form-control" id="concepto" rows="1"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="cantidad" class="col-form-label">Dias:</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-form-label">Valor:</label>
                            <input type="number" class="form-control" name="valor" id="valor" required>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_detalle_habitacion">Agregar</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal Habitacion actualizar -->
              <div class="modal fade" id="modal_habitacion_actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar habitación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                          <input type="hidden" class="form-control" id="detalle_servicio_id_modal" value="">
                            <label for="habitacion" class="col-form-label">Habitacion</label>
                            <select class="form-control" id="habitacion_id_modal" name="habitacion_id_modal" required>
                              <option value="null">Seleccione</option>
                              <?php
                              while ($row = mysqli_fetch_array($habitaciones_clon)) {
                              echo '<option value="'.$row['habitacion_id'].'">'.$row['numero'].'-'.$row['descripcion'].'</option>'; 
                              } 
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="observacion" class="col-form-label">Observación:</label>
                            <textarea class="form-control" id="concepto_modal" rows="1"></textarea>
                          </div>
                          <div class="cantidad">
                            <label for="message-text" class="col-form-label">Dias:</label>
                            <input type="number" class="form-control" name="cantidad_modal" id="cantidad_modal" required>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-form-label">Valor:</label>
                            <input type="number" class="form-control" name="valor_modal" id="valor_modal" required>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="actualizar_detalle_habitacion">Actualizar</button>
                      </div>
                    </div>
                  </div>
                </div>



                <!-- modal producto -->
                <div class="modal fade" id="modal_producto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="producto" class="col-form-label">Producto</label>
                            <select class="form-control" id="producto_id" name="producto_id" required>
                              <option value="null">Seleccione</option>
                              <?php
                              while ($row = mysqli_fetch_array($productos)) {
                              echo '<option value="'.$row['producto_id'].'">'.$row['nombre'].'</option>'; 
                              } 
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="observacion" class="col-form-label">Observación:</label>
                            <textarea class="form-control" id="concepto_pro" rows="1"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="cantidad" class="col-form-label">Cantidad:</label>
                            <input type="number" class="form-control" name="cantidad_pro" id="cantidad_pro" required>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-form-label">Valor:</label>
                            <input type="number" class="form-control" name="valor_pro" id="valor_pro" required>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_detalle_producto">Agregar</button>
                      </div>
                    </div>
                  </div>
                </div>
                
               <!--modal actualizar producto-->
                <div class="modal fade" id="modal_producto_actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                          <input type="hidden" class="form-control" id="detalle_servicio_id_modal_pro" value="">
                            <label for="producto" class="col-form-label">producto</label>
                            <select class="form-control" id="producto_id_modal" name="producto_id_modal" required>
                              <option value="null">Seleccione</option>
                              <?php
                              while ($row = mysqli_fetch_array($productos_clon)) {
                              echo '<option value="'.$row['producto_id'].'">'.$row['nombre'].'</option>'; 
                              } 
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="observacion" class="col-form-label">Observación:</label>
                            <textarea class="form-control" id="concepto_modal_pro" rows="1"></textarea>
                          </div>
                          <div class="cantidad">
                            <label for="message-text" class="col-form-label">Dias:</label>
                            <input type="number" class="form-control" name="cantidad_modal_pro" id="cantidad_modal_pro" required>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-form-label">Valor:</label>
                            <input type="number" class="form-control" name="valor_modal_pro" id="valor_modal_pro" required>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="actualizar_detalle_producto">Actualizar</button>
                      </div>
                    </div>
                  </div>
                </div>


           
              <!-- <section id="detalles_servicio">
              <div>
            
              <i type="button" class="fa fa-plus btn btn-success" id="agregar" style="font-size:24px;" aria-hidden="true"> Nuevo</i>

              </div>
              <br>
                <table class="table" id="detalles">
                <thead class="table-primary">
                    <tr>
                    <th scope="col"></th>
                    <th scope="col">Habitación</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Dias</th>
                    <th scope="col">Valor</th>
                    <th scope="co" colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
          
                    <tr>
                    <td><input type="hidden" class="form-control" name="detalle_servicio_id" id="detalle_servicio_id" readonly></td>
                    <td>
                    <select class="form-control habitacion" id="habitacion_id" name="habitacion_id">
                    <option value="null">Seleccione</option>
                    <?php
                    /* while ($row = mysqli_fetch_array($habitaciones)) {
                     echo '<option value="'.$row['habitacion_id'].'">'.$row['numero'].'-'.$row['descripcion'].'</option>'; 
                    } */
                    ?>
                    </select>
                    </td>
                    <td>
                    <textarea class="form-control" id="concepto" rows="1"></textarea>
                    </td>
                    <td><input type="number" class="form-control cantidad" name="cantidad" id="cantidad"></td>
                    <td><input type="number" class="form-control" name="valor" id="valor"></td>
                    <td><button type="submit" class="btn btn-success" id="guardar_detalle"><i class="fa fa-floppy-o" style="font-size:28px;" aria-hidden="true"></i></button></td>
                    <td><i type="button" id="quitar" class="btn btn-danger fa fa-trash" aria-hidden="true" style="font-size:30px;"></i></td>
                    </tr>
                </tbody>
                </table>
                <div style="width:20%; background-color: #B8DAFF; text-align:center; margin-left: 400px;" >
                <label><b>Valor Toltal Servicio</b></label>
                <input type="text" class="form-control" name="total" id="total" readonly>
                </div>
              </section> -->
               
               </form>
               
        </div>
        <script src="js/servicio.js"></script>
    </body>	
</html>