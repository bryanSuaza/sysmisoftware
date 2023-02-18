<?php

require ("./class/db.class.php");
//require ("./class/reporteParqueaderoDTO.php");
//require ("./class/reporteParqueaderoDAO.php");

//$reporteParqueaderoDTO = new reporteParqueaderoDTO();
//$reporteParqueaderoDAO = new reporteParqueaderoDAO();

//$listaParqueadero = $reporteParqueaderoDAO->listarVehiculosParqueadero();
//$tipo_vehiculo = $reporteParqueaderoDAO->getTipo_vehiculo();

?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Reporte Parqueadero</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="frameworks/bootstrap/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/buttons.dataTables.min.css">
	</head>
	<body>
	<div class="container">

              <div style="text-align: center;">
              <h3><i class="fa fa-table"></i> Reporte Parqueadero </h3>
              </div>
              
              <div class="col" style="display: inline-block; text-align: center;">
                 <button class="btn btn-info" onclick="reporte()">Listado de Vehículos</button>&nbsp;&nbsp;
                 <button class="btn btn-info" onclick="ingresarVehiculo()">Ingresar Veh&iacute;culo Parqueadero</button>
                 &nbsp;&nbsp;<button class="btn btn-info" onclick="salidaVehiculo()">Salida Veh&iacute;culo Parqueadero</button>
              </div>
              <br>
              <br>

            <form id="form" style="padding-left: 20px; padding-right: 20px;">
               <div class="row">
                
                    <div class="form-group col-md-3">
                    <label>Fecha Desde<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="fecha_desde" id="fecha_desde" required>
                    </div>

                    <div class="form-group col-md-3">
                    <label>Fecha Hasta<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="fecha_hasta" id="fecha_hasta" required>
                    </div>

                    <div class="form-group col-md-3">
                    <label>Placa</label>
                    <input type="text" class="form-control" name="placa" id="placa">
                    </div>  

                    <div class="form-group col-md-3">
                    <label>Estado<span style="color:red">*</span></label>
                      <select class="form-control" id="estado" name="estado">
                        <option value="A">ACTIVO</option>
                        <option value="F">FINALIZADO</option>
                      </select>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary" id="generar">Generar Reporte</button>&nbsp;
                <button type="submit" class="btn btn-primary" id="limpiar">Limpiar</button>
                <button class="btn btn-success"onclick="exportTableToExcel('table_reporte')">Exportar Excel</button>&nbsp;
                
            </form>
            <br>

        <div class="col-md-12">
            <div style="border: 1px solid; border-radius:4px; padding:2px">
             <table class="table table-bordered table-striped" id="table_reporte">
                 <thead class="table-primary">
                    <tr>

                    <th scope="col">Ticket</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Tipo Vehiculo</th>
                    <th scope="col">Fecha Ingreso</th>
                    <th scope="col">Fecha Salida</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Estado</th> 
                   
                    </tr>
                    <tr>
                        <th scope="col">Valor Total Servicios</th>
                        <td colspan="100"><input type="text" id="total" class="form-control" readonly></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
               </table>

         </div>
           
        </div>
        
    </div>

           <script src="js/reporteParqueadero.js"></script>
    </body>
</html>