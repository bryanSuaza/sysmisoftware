<?php
require ("./class/db.class.php");
require ("./class/seguimiento_obraDTO.php");
require ("./class/seguimiento_obraDAO.php");


$seguimiento_obraDTO = new seguimiento_obraDTO();
$seguimiento_obraDAO = new seguimiento_obraDAO();

$seguimientos = $seguimiento_obraDAO->listarSeguimiento();


?>
<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Seguimiento Obra</title>
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
                <h2>Lista Seguimientos</h2>
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center" scope="col">Id</th>
                        <th style="text-align: center" scope="col">Fecha Informe</th>
                        <th style="text-align: center" scope="col">Numero Informe</th>
                        <th style="text-align: center" scope="col">Fecha Inicio</th>
                        <th style="text-align: center" scope="col">Fecha Final</th>
                        <th style="text-align: center" scope="col">Dias Total</th>
                        <th style="text-align: center" scope="col">Tiempo Transcurrido</th>
                        <th style="text-align: center" scope="col">Presupuesto Total</th>
                        <th style="text-align: center" scope="col">Presupuesto Actualizado</th>
                        <th style="text-align: center" scope="col">Costo Mano Obra</th>
                        <th style="text-align: center" colspan="4">Opciones</th>
                       
                    </tr>
                </thead>
                <tbody>
                  <?php
                    if ($seguimientos != "") {
                        while ($seguimiento = $seguimientos->fetch_object()) {
                               $seguimiento_obraDTO->mapear($seguimiento);
                                ?>
                            <tr>
                                <td>
                                    <?php echo $seguimiento_obraDTO->getSeguimiento_obra_id();?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_obraDTO->getFecha_informe();?>
                                </td>
                                 <td>
                                    <?php echo $seguimiento_obraDTO->getNumero_informe();?>
                                </td>
                                 <td>
                                    <?php echo $seguimiento_obraDTO->getFecha_inicio();?>
                                </td>
                                 <td>
                                    <?php echo $seguimiento_obraDTO->getFecha_final();?>
                                </td>
                                <td>
                                    <?php echo $seguimiento_obraDTO->getDias_total();?> 
                                </td>
                                <td>
                                   <?php echo $seguimiento_obraDTO->getTiempo_transcurrido();?>
                                </td>
                                <td>
                                   <?php echo $seguimiento_obraDTO->getPresupuesto_total_obra();?>
                                </td>
                                <td>
                                   <?php echo $seguimiento_obraDTO->getPresupuesto_actualizado();?>
                                </td>
                                <td>
                                   <?php echo $seguimiento_obraDTO->getCosto_mano_obra();?>
                                </td>
                                 <td>
                                     <form action="./process/seguimiento_obra.process.php" method="post" target="iframe_process">
                                        <input type="hidden" name="modo" value="eliminar">
                                        <input type="hidden" name="seguimiento_obra_id" value="<?php echo $seguimiento_obraDTO->getSeguimiento_obra_id(); ?>">
                                        <a>
                                            <button type="submit" class="btn btn-primary" >Borrar</button>
                                        </a>
                                    </form>
                                </td>
                                 <td> 
                                     <a href ="javascript:abrirPagina('./forms/seguimiento.form.php?seguimiento_obra_id=<?php echo $seguimiento_obraDTO->seguimiento_obra_id;?>','contenedor','');">
                                        <button  class="btn btn-primary">Editar</button> 
                                    </a>
                                </td>
                                 <td> 
                                     <a href ="./forms/obras_programadas.form.php?seguimiento_obra_id=<?php echo $seguimiento_obraDTO->seguimiento_obra_id;?>" target="framename" class="btn btn-primary">Programar obra</a>
                                </td>
                                <td> 
                                     <a href ="./list/obra_programada.list.php?seguimiento_obra_id=<?php echo $seguimiento_obraDTO->seguimiento_obra_id;?>" target="framename" class="btn btn-primary">Ver obra</a>
                                </td>
                            </tr>
                                <?php  
                        }
                    } 
                    ?>
         </div>           
        </tbody>     
        <tr>
                    <td>
                        <a>
                            <button onclick="location.href='?page=crearSeguimiento'" class="btn btn-primary">Crear Seguimiento</button>
                        </a>
                    </td>
        </tr>
        </table>
        <div align="center">
            <iframe  width="1100" height="400" name="framename" id="frameid" style="border: 0;padding-top:10px"></iframe> 
        </div> 
            </div>
         </div>
    </div>
 </div>   
 </body>  
</html>
