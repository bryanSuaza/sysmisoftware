<?php

require ("./class/db.class.php");
require ("./class/clienteDTO.php");
require ("./class/clienteDAO.php");

$clienteDTO = new clienteDTO();
$clienteDAO = new clienteDAO();

$clientes = $clienteDAO->listarclientes();

?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Lista de Clientes</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="frameworks/bootstrap/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/responsive.bootstrap4.min.css">
	</head>
	<body>
	<div class="container">
      <div class="row">
        <div class="table-responsive">
            <div class="table-wrapper-scroll-y my-custom-scrollbar" style="padding-left: 20px; padding-right: 20px;">
              <table  id="table_clientes" class="table table-striped table-bordered" style="width:100%">
              <div style="text-align: center;">
              <h3><i class="fa fa-table"></i> Lista Clientes</h3>
              </div>
              <br>
                <thead class="table-info">
                    <tr>
                        <th>&nbsp;</th>
                        <th style="text-align: left" scope="col">Cod</th>
                         <th style="text-align: left" scope="col">Tipo Persona</th>
                        <th style="text-align: left" scope="col">Identifica</th>
                        <th style="text-align: left" scope="col">DV</th>
                        <th style="text-align: left" scope="col">Nombre</th>
                        <th style="text-align: left" scope="col">Email</th>
                        <th style="text-align: left" scope="col">Telefono</th>
                        <th style="text-align: left" >Estado</th>
                        <th style="text-align: left" >Opcion</th>  
                    </tr>
                </thead>
                <tbody>
                	<?php
                    if ($clientes != "") {
                        while ($cliente = mysqli_fetch_array($clientes)) {
                                ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <?php echo $cliente['cliente_id']?>
                                </td>
                                <td>
                                    <?php echo $cliente['tipo_persona']?>
                                </td>
                                <td>
                                    <?php echo $cliente['numero_identificacion']?>
                                </td>
                                <td>
                                    <?php echo $cliente['digito_verificacion']?>
                                </td>
                                <td>
                                    <?php echo $cliente['nombre']?>
                                </td>
                                 <td>
                                    <?php echo $cliente['email']?>
                                </td>
                                <td>
                                    <?php echo $cliente['telefono'];?>
                                </td>
                                 <td>
                                    <?php echo $cliente['estado']?>
                                </td>
                                 <td>   
                                    <button class="btn btn-primary" onclick="verCliente(<?php echo $cliente['cliente_id']?>)"><a class="fa fa-pencil"></a></button>
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
        </div>
        </div>
        <script src="js/cliente.js"></script>
    </body>
</html>