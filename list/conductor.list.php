<?php

require ("./class/db.class.php");
require ("./class/conductorDTO.php");
require ("./class/conductorDAO.php");
require ("./class/terceroDTO.php");
require ("./class/terceroDAO.php");


$terceroDTO = new terceroDTO();
$conductorDTO = new conductorDTO();
$conductorDAO = new conductorDAO();

$terceros = $conductorDAO->listarTercero();
$conductores = $conductorDAO->listarConductor();
?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Conductor</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../styles/css/styles.css">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	</head>
	<body>
	<div class="container">
<div class="row">
        <div class="table-responsive">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-striped table-hover table-sm">
                <h2>Lista de conductores</h2>
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center" scope="col">Id</th>
                        <th style="text-align: center" scope="col">Nombres</th>
                        <th style="text-align: center" scope="col">Apellidos</th>
                        <th style="text-align: center" scope="col">Tipo identificación</th>
                        <th style="text-align: center" scope="col">Num identificación</th>
                        <th style="text-align: center" scope="col">Email</th>
                        <th style="text-align: center" scope="col">Num licencia</th>
                        <th style="text-align: center" scope="col">Categoria lic</th>
                        <th style="text-align: center" scope="col">Tipo sangre</th>
                        <th style="text-align: center" colspan="2">Opciones</th>
                        
                       
                    </tr>
                </thead>
                <tbody>
                  <?php
                    if ($terceros->num_rows and $conductores->num_rows) {
                        while ($tercero = $terceros->fetch_object() and $conductor = $conductores->fetch_object()) {
                               $terceroDTO->mapear($tercero);
                               $conductorDTO->mapear($conductor);
                                ?>
                            <tr>
                                <td>
                                    <?php echo $conductorDTO->getConductor_id();?>
                                </td>
                                <td>
                                    <?php echo $terceroDTO->getPrimer_nombre()." ".$terceroDTO->getSegundo_nombre();?>
                                </td>
                                 <td>
                                    <?php echo $terceroDTO->getPrimer_apellido()." ".$terceroDTO->getSegundo_apellido();?>
                                </td>
                                 <td>
                                    <?php echo $tercero->nombre;?>
                                </td>
                                 <td>
                                    <?php echo $terceroDTO->getNumero_identificacion();?>
                                </td>
                                 <td>
                                    <?php echo $terceroDTO->getEmail();?>
                                </td>
                                <td>
                                    <?php echo $conductorDTO->getNumero_licencia_cond();?>
                                </td>
                                <td>
                                    <?php echo $conductor->categoria;?>
                                </td>
                                <td>
                                    <?php echo $conductor->tipo_sangre;?>
                                </td>
                                 <td>
                                     <form action="./process/conductor.process.php" method="post" target="iframe_process">
                                        <input type="hidden" name="modo" value="eliminar">
                                        <input type="hidden" name="conductor_id" value="<?php echo $conductorDTO->getConductor_id(); ?>">
                                        <a>
                                            <button type="submit" class="btn btn-primary" >Borrar</button>
                                        </a>
                                    </form>
                                </td>
                                 <td>
                                     <a href ="javascript:abrirPagina('./forms/conductor.form.php?conductor_id=<?php echo $conductorDTO->conductor_id;?>','contenedor','');">
                                        <button  class="btn btn-primary">Editar</button> 
                                    </a>
                                </td>
                            </tr>
                                <?php  
                        }
                    } 
                    ?>
        </tbody>
        <tr>
                    <td>
                        <a>
                            <button onclick="location.href='?page=crearConductor'" class="btn btn-primary">Crear Conductor</button>
                        </a>
                    </td>
        </tr>
        </table>
        </div>
        </div>
        </div>
        </div>
</html>
