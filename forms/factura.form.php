<?php

require("./class/db.class.php");
require("./class/facturaDTO.php");
require("./class/facturaDAO.php");

$factura_id = filter_input(INPUT_GET, "factura_id", FILTER_SANITIZE_NUMBER_INT);

$facturaDTO = new facturaDTO();
$facturaDAO = new facturaDAO();

$productos = $facturaDAO -> getProductos();
$productos_clon = $facturaDAO -> getProductos();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Factura</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
        <div class="panel panel-default">
              <div style="text-align: center;">
              <h2><i class="fa fa-file-text"></i> FACTURA</h2>
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
                  <input type="number" class="form-control" name="factura_id" id="factura_id" value="<?php echo $factura_id ?>" readonly>
                  <br>
                  <label>Fecha</label>
                  <input type="text" class="form-control" name="fecha" id="fecha" required>
                </div>

                <div class="col-sm">
                  <label>Cliente</label>
                  <input type="hidden" class="form-control"  name="cliente_id" id="cliente_id" required>
                  <input type="text" class="form-control" placeholder="Digita número identificación cliente" name="cliente" id="cliente" required>
                  <br>
                 <label>Valor</label>
                  <input type="text" class="form-control" name="valor_total" id="valor_total" readonly>
                </div>

                <div class="col-sm">
                 <label>Numero Identificación</label>
                  <input type="number" class="form-control" name="numero_identificacion" id="numero_identificacion" readonly>
                  <br>
                  <label>Estado</label>
                  <select class="form-control" id="estado" name="estado" disabled>
                    <option value="A">ACTIVA</option>
                    <option value="F">PAGADA</option>
                    <option value="I">ANULADA</option>
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
                <button type="submit" class="btn btn-primary" id="print">Imprimir</button>
              </div>
              <br>
              <section id="detalles_factura">
               <div style="text-align:right;">
                <button type="button" class="btn btn-info"  id="servicio" data-toggle="modal" data-target="#modal_servicio"><i class="fa fa-book"></i> Servicio</button>
                <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#modal_producto"><i class="fa fa-product-hunt"></i> Producto</button>
                <button type="button" class="btn btn-danger" id="eliminar_servicio" ><i class="fa fa-trash-o"></i> Eliminar Servicios</button>
              </div>
              <br>
              <div style="text-align:center;">
               <table class="table table-bordered table-striped" id="detalles">
                 <thead class="table-primary">
                    <tr>
                    <th scope="col">Cant/Dias</th>
                    <th scope="col">Concepto</th>
                    <th scope="col">Valor Unitario</th>
                    <th scope="col">Desc %</th>
                    <th scope="col">Iva %</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Opcion </th> 
                    <th>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" id="checkboxDetalleAll" title="Eliminar Servicios">
                               </div>
                    </th>
                   
                    </tr>
                </thead>
                <tbody>
                </tbody>
               </table>
               
               </div>

                <div class="container">
                   <div class="row">
                   <div class="col-sm-7">
                   </div>
                    <div class="col-sm-5">
                    <table class="table">
                    <tr>
                    <td><b>Base</b></td><td><input type="text" class="form-control" name="base_total" id="base_total" readonly></td>
                    </tr>
                     <tr>
                    <td><b>Impuesto</b></td><td><input type="text" class="form-control" name="impuesto_total" id="impuesto_total" readonly></td>
                    </tr>
                     <tr>
                    <td><b>Descuento</b></td><td><input type="text" class="form-control" name="descuento_total" id="descuento_total" readonly></td>
                    </tr>
                     <tr>
                    <td><b>Total</b></td><td><input type="text" class="form-control" name="total" id="total" readonly></td>
                    </tr>
                    </table>
                    </div>
                   </div>
                </div>
              </section>
               

              <!-- Modal Servicio guardar -->
              <div class="modal fade" id="modal_servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar servicios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <table class="table table-bordered table-striped" id="detalles_modal">
                        <thead>
                          <th>
                               <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="checkbox" id="checkboxAll">
                               </div>
                          </th>
                          <th>Cod</th>
                          <th>Cliente</th>
                          <th>Fecha</th>
                          <th>Valor</th>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="guardar_detalle_servicio">Agregar</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal servicio actualizar -->
              <div class="modal fade" id="modal_servicio_actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Servicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="detalle_factura_id_modal" value="">
                            <label for="iva" class="col-form-label">Iva %:</label>
                            <input type="number" class="form-control" name="iva_modal" id="iva_modal">
                          </div>
                          <div class="form-group">
                            <label for="descuento" class="col-form-label">Descuento %:</label>
                            <input type="number" class="form-control" name="descuento_modal" id="descuento_modal">
                          </div> 
                        </form>
                      </div>
                      <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" data-dismiss="modal" id="actualizar_detalle_servicio">Actualizar</button>
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
                          <input type="hidden" class="form-control" id="detalle_factura_id_modal_pro" value="">
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
                            <label for="message-text" class="col-form-label">Cantidad:</label>
                            <input type="number" class="form-control" name="cantidad_modal_pro" id="cantidad_modal_pro" required>
                          </div>
                          <div class="form-group">
                            <label for="valor" class="col-form-label">Valor:</label>
                            <input type="number" class="form-control" name="valor_modal_pro" id="valor_modal_pro" required>
                          </div>
                            <div class="form-group">
                            <label for="iva" class="col-form-label">Iva %:</label>
                            <input type="number" class="form-control" name="iva_modal_pro" id="iva_modal_pro">
                          </div>
                          <div class="form-group">
                            <label for="descuento" class="col-form-label">Descuento %:</label>
                            <input type="number" class="form-control" name="descuento_modal_pro" id="descuento_modal_pro">
                          </div> 
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="actualizar_detalle_producto">Actualizar</button>
                      </div>
                    </div>
                  </div>
                </div>
               
               </form>
               
        </div>
        <script src="js/factura.js"></script>
    </body>	
</html>