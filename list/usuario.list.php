<?php

require ("./class/db.class.php");
require ("./class/usuarioDTO.php");
require ("./class/usuarioDAO.php");

$usuarioDTO = new usuarioDTO();
$usuarioDAO = new usuarioDAO();

$usuarios = $usuarioDAO->listarUsuarios();

?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Lista de Usuarios</title>
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
              <table id="table_usuarios" class="table table-striped table-bordered" style="width:100%">
              <div style="text-align: center;">
              <h3><i class="fa fa-user"></i> Lista Usuarios</h3>
              </div>
              <br>
                <thead class="table-info">
                    <tr>
                        <th style="text-align: left" scope="col">Cod</th>
                         <th style="text-align: left" scope="col">Nombre</th>
                        <th style="text-align: left" scope="col">Num Identificación</th>
                        <th style="text-align: left" scope="col">Telefono</th>
                        <th style="text-align: left" scope="col">Rol</th>
                        <th style="text-align: left" scope="col">Username</th>
                        <th style="text-align: left" scope="col">Estado</th>
                        <th style="text-align: left" scope="col">Opcion</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                    if ($usuarios != "") {
                        while ($usuario = mysqli_fetch_array($usuarios)) {
                                ?>
                            <tr>
                                <td>
                                    <?php echo $usuario['usuario_id']?>
                                </td>
                                <td>
                                    <?php echo $usuario['nombre']?>
                                </td>
                                <td>
                                    <?php echo $usuario['numero_identificacion']?>
                                </td>
                                <td>
                                    <?php echo $usuario['telefono']?>
                                </td>
                                <td>
                                    <?php echo $usuario['rol']?>
                                </td>
                                 <td>
                                    <?php echo $usuario['username']?>
                                </td>
                                <td>
                                    <?php echo $usuario['estado'];?>
                                </td>
                                 <td>   
                                    <button class="btn btn-primary" onclick="verUsuario(<?php echo $usuario['usuario_id']?>)"><a class="fa fa-pencil"></a></button>
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
         <script src="js/usuario.js"></script>
    </body>
</html>