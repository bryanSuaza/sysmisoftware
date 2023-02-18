<?php

require ("./class/db.class.php");
require ("./class/parqueaderoDTO.php");
require ("./class/parqueaderoDAO.php");

$parqueaderoDTO = new parqueaderoDTO();
$parqueaderoDAO = new parqueaderoDAO();

$listaParqueadero = $parqueaderoDAO->listarVehiculosParqueadero();
$tipo_vehiculo = $parqueaderoDAO->getTipo_vehiculo();

?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Lista Vehiculos Parqueadero</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="frameworks/bootstrap/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="styles/css/tables.css">
	</head>
	<body>
	<div class="container">

              <div style="text-align: center;">
              <h3><i class="fa fa-table"></i> Lista Veh&iacute;culos Parqueadero </h3>
              </div>
              
              <div class="col" style="display: inline-block; text-align: center;">
                 <button class="btn btn-info" onclick="ingresarVehiculo()">Ingresar Veh&iacute;culo Parqueadero</button>
                 &nbsp;&nbsp;<button class="btn btn-info" onclick="salidaVehiculo()">Salida Veh&iacute;culo Parqueadero</button>
                 &nbsp;&nbsp;<button class="btn btn-info" onclick="reporteParqueadero()">Reporte Parqueadero</button>
              </div>
              <br>
              <br>
              <div class="col-md-11">
              <table  id="table_parqueadero" class="table table-striped table-bordered table-hover" style="width:100%; overflow: auto; font-size:13px">
                <thead class="table-info">
                    <tr>
                        <th></th> 
                        <th></th>  
                        <th></th> 
                        <th></th> 
                        <th>Ticket</th>
                        <th>Placa</th>
                        <th>Tipo Veh&iacute;culo</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Estado</th>
                        <th>Descripcion</th>
                        <th>Valor</th>
                        <th>Tipo Servicio</th>
                        <th>Horas</th>
                        <th>Medios Dias</th>
                        <th>Dias</th>
                        <th>Usuario Registra</th>
                        <th>Fecha Registra</th>
                        <th>Usuario Actualiza</th>
                        <th>Fecha Actualiza</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                    if ($listaParqueadero != "") {
                        while ($lista = mysqli_fetch_array($listaParqueadero)) {
                                ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                <?php
                                 if($_SESSION['actualizar']=='SI'){
                                ?>
                                    <button  type="button" class="btn btn-primary" id="actualizar" data-toggle="modal" data-target="#modal_actualizar_parqueadero"><i class="fa fa-pencil" style="font-size:15px;" aria-hidden="true"></i></button>
                                <?php
                                }
                                ?>
                                </td>
                                <td>
                                <?php
                                if($_SESSION['eliminar']=='SI'){
                                ?>
                                    <button  class="btn btn-danger" id="eliminar"><i class="fa fa-trash" style="font-size:15px;" aria-hidden="true"></i></button>
                                <?php
                                }
                                ?>
                                </td>
                                <td>
                                    <button  class="btn btn-dark" id="print"><i class="fa fa-print" style="font-size:15px;" aria-hidden="true"></i></button>
                                </td>

                                <td>
                                    <input type="hidden" id="parqueadero_id" value="<?php echo $lista['parqueadero_id']?>">
                                    <input type="hidden" id="codigo_ticket" value="<?php echo $lista['codigo_ticket']?>">
                                    <?php echo $lista['codigo_ticket']?>
                                </td>
                                <td>
                                    <input type="hidden" id="placa" value="<?php echo $lista['placa']?>">
                                    <?php echo $lista['placa']?>
                                </td>
                                <td>
                                    <input type="hidden" id="tipo_vehiculo_id" value="<?php echo $lista['tipo_vehiculo_id']?>">
                                    <?php echo $lista['tipo_vehiculo']?>
                                </td>
                                <td>
                                    <input type="hidden" id="fecha_hora_ingreso" value="<?php echo $lista['fecha_hora_ingreso']?>">
                                    <?php echo $lista['fecha_hora_ingreso']?>
                                </td>
                                <td>
                                    <input type="hidden" id="fecha_hora_salida" value="<?php echo $lista['fecha_hora_salida']?>">
                                    <?php echo $lista['fecha_hora_salida']?>
                                </td>
                                <?php 
                                  if($lista['estado']=='ACTIVO'){
                                    ?>
                                     <td style="background-color:#17a2b8; color:#fff">
                                      <input type="hidden" id="estado" value="<?php echo $lista['estado_val']?>">
                                      <b><?php echo $lista['estado']?></b>
                                     </td>
                                  <?php 
                                  }else{
                                    ?>
                                     <td style="background-color:#c82333; color:#fff">
                                      <input type="hidden" id="estado" value="<?php echo $lista['estado_val']?>">
                                      <b><?php echo $lista['estado']?></b>
                                     </td>
                                  <?php 
                                  }
                                  ?>                                
                                <td>
                                    <input type="hidden" id="descripcion" value="<?php echo $lista['descripcion']?>">
                                    <?php echo $lista['descripcion'];?>
                                </td>
                                 <td>
                                    <input type="hidden" id="valor_servicio" value="<?php echo $lista['valor_servicio']?>">
                                    <?php echo $lista['valor_servicio']?>
                                </td>
                                <td>
                                    <?php 
                                      if($lista['tipo_servicio']=='mensual'){
                                    ?>
                                         <input type="hidden" id="por_mes_mod" value="1">
                                         <input type="hidden" id="por_dia_mod" value="0">
                                         <input type="hidden" id="por_medio_mod" value="0">
                                         <input type="hidden" id="por_horas_mod" value="0">
                                    <?php
                                      }else if($lista['tipo_servicio']=='por medio dia'){
                                    ?>
                                          <input type="hidden" id="por_medio_mod" value="1">
                                          <input type="hidden" id="por_dia_mod" value="0">
                                          <input type="hidden" id="por_mes_mod" value="0">
                                          <input type="hidden" id="por_horas_mod" value="0">
                                    <?php
                                      }else if($lista['tipo_servicio']=='por horas'){
                                    ?>
                                          <input type="hidden" id="por_horas_mod" value="1">
                                          <input type="hidden" id="por_dia_mod" value="0">
                                          <input type="hidden" id="por_mes_mod" value="0">
                                          <input type="hidden" id="por_medio_mod" value="0">
                                    <?php
                                      }else if($lista['tipo_servicio']=='por dia'){
                                    ?>
                                          <input type="hidden" id="por_dia_mod" value="1">
                                          <input type="hidden" id="por_horas_mod" value="0">
                                          <input type="hidden" id="por_mes_mod" value="0">
                                          <input type="hidden" id="por_medio_mod" value="0">
                                    <?php
                                      }
                                    echo $lista['tipo_servicio']
                                    ?>
                                </td>
                                 <td>
                                    <?php echo $lista['horas']?>
                                </td>
                                 <td>
                                    <?php echo $lista['medios_dias']?>
                                </td>
                                 <td>
                                    <?php echo $lista['dias']?>
                                </td>
                                 <td>
                                    <?php echo $lista['usuario']?>
                                </td>
                                <td>
                                    <?php echo $lista['fecha_registro']?>
                                </td>
                                <td>     
                                    <?php echo $lista['usuario_actualiza']?>
                                </td>
                                <td>
                                    <?php echo $lista['fecha_actualiza']?>
                                </td>

                            </tr> 
                            <?php
                        }
                    } 
                    ?>
                </tbody>
        </table>
        </div>
       
        
        </div>

           <!-- Modal actualizar -->
              <div class="modal fade" id="modal_actualizar_parqueadero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Servicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      
                      <form>
                      <div class="row">

                      <div class="form-group col-md-6">
                            <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="<?php echo $_SESSION['usuario_id']?>">
                            <input type="hidden" class="form-control" id="parqueadero_id_modal" value="">
                            <label for="iva" class="col-form-label">Placa:</label>
                            <input type="text" class="form-control" name="placa_modal" id="placa_modal">
                      </div>

                      <div class="form-group col-md-6">
                            <label for="descuento" class="col-form-label">Tipo Vehículo:</label>
                             <select class="form-control" id="tipo_vehiculo_id_modal" name="tipo_vehiculo_id_modal" required>
                             <option value="null">Seleccione</option>
                                <?php
                                while ($row = mysqli_fetch_array($tipo_vehiculo)) {
                                echo '<option value="'.$row['tipo_vehiculo_id'].'">'.$row['tipo'].'</option>';
                                }
                                ?>
                            </select>
                      </div> 

                      <div class="form-group col-md-6">
                            <label for="fecha_ingreso" class="col-form-label">Fecha/Hora Ingreso:</label>
                            <input type="text" class="form-control" name="fecha_hora_ingreso_modal" id="fecha_hora_ingreso_modal">     
                      </div>

                      <div class="form-group col-md-6">
                            <label for="fecha_salida" class="col-form-label">Fecha/Hora Salida:</label>
                            <input type="text" class="form-control" name="fecha_hora_salida_modal" id="fecha_hora_salida_modal">
                      </div>
                          
                      <div class="form-group col-md-6">
                            <label for="descripcion" class="col-form-label">Descripción:</label>
                           <textarea class="form-control" id="descripcion_modal" rows="2"></textarea>
                      </div>

                      <div class="form-group col-md-6">
                            <label for="valor_servicio" class="col-form-label">Valor Servicio:</label>
                            <input type="text" class="form-control" name="valor_servicio_modal" id="valor_servicio_modal">
                      </div>
                      
                      <!----------------tipos de servicio----------------->
                      <div class="form-group col-md-6">    
                            <label  for="por_horas_modal">Por Horas</label><br>
                            <input type="checkbox" id="por_horas_modal" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                      </div> 
                      <div class="form-group col-md-6">     
                            <label for="por_mes_modal">Por Mes</label><br>
                            <input type="checkbox" id="por_mes_modal" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                      </div>
                      <div class="form-group col-md-6"> 
                            <label  for="por_medio_modal">Por Medio Dia</label><br>
                            <input type="checkbox" id="por_medio_modal" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                     </div>
                     <div class="form-group col-md-6">  
                            <label for="por_dia_modal">Por Dia</label><br>
                            <input type="checkbox" id="por_dia_modal" data-toggle="toggle" data-on="SI" data-off="NO" data-onstyle="info" data-offstyle="secondary">
                     </div>
                    <!----------------tipos de servicio----------------->

                      <div class="form-group col-md-6">
                            <label for="descuento" class="col-form-label">Estado:</label>
                             <select class="form-control" id="estado_modal" name="estado_modal" required>
                             <option value="null">Seleccione</option>
                             <option value="A">ACTIVO</option>
                             <option value="F">FINALIZADO</option>
                            </select>
                      </div> 

                        </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" data-dismiss="modal" id="actualizar_parqueadero">Actualizar</button>
                      </div>
                    </div>
                  </div>
                </div>

        <script src="js/parqueadero.js"></script>
    </body>
</html>