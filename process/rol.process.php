<?php
	
require("../class/db.class.php");
require("../class/rolDTO.php");
require("../class/rolDAO.php");

class rolProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $rolDTO = new rolDTO();
            $rolDAO = new rolDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchRol = $rolDAO->buscarRol($busqueda);

            if($serchRol!= ''){
               echo json_encode($serchRol);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $rolDTO = new rolDTO();
            $rolDAO = new rolDAO();

            $rol_id =filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
            
            $getRol = $rolDAO->traerDatos($rol_id);
            
            if($getRol>0){
               echo json_encode($getRol);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $rolDTO = new rolDTO();
            $rolDAO = new rolDAO();

            $rol =filter_input(INPUT_POST, "rol", FILTER_SANITIZE_STRING);
            $permiso_id =filter_input(INPUT_POST, "permiso_id", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $rolDTO->setRol($rol);
            $rolDTO->setEstado($estado);
            
            $saveRol = $rolDAO->crearRol($rolDTO);

            if($saveRol>0){
               echo json_encode($saveRol);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

            $rolDTO = new rolDTO();
            $rolDAO = new rolDAO();

            $rol_id=filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
            $rol =filter_input(INPUT_POST, "rol", FILTER_SANITIZE_STRING);
            $permiso_id =filter_input(INPUT_POST, "permiso_id", FILTER_SANITIZE_STRING);
			$estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $rolDTO->setRol_id($rol_id);
			$rolDTO->setRol($rol);
            $rolDTO->setEstado($estado);
            
            $updateRol= $rolDAO->actualizarRol($rolDTO);

            if($updateRol>0){
               echo json_encode($updateRol);
            }

    }

    public function delete(){

            $rolDTO = new rolDTO();
            $rolDAO = new rolDAO();

            $rol_id=filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
	       
            $rolDTO->setRol_id($rol_id);
            
            $deleteRol = $rolDAO->eliminarRol($rolDTO);

            if($deleteRol>0){
               echo json_encode($deleteRol);
            }
    }

}
$rolProcess = new rolProcess();



/* $modo= filter_input(INPUT_POST, "modo", FILTER_SANITIZE_STRING);

switch($modo){
	case 'crear':
    
		try{
			$rolDTO = new rolDTO();
			$rolDAO = new rolDAO();
			
			
	        //variables que recibe del formulario de seguimiento de obra 
	        $rol_id=filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
	        $fecha_informe =filter_input(INPUT_POST, "fecha_informe", FILTER_SANITIZE_STRING);
			    $numero_informe =filter_input(INPUT_POST, "numero_informe", FILTER_SANITIZE_STRING);
          $fecha_inicio =filter_input(INPUT_POST, "fecha_inicio", FILTER_SANITIZE_STRING);
	        $fecha_final =filter_input(INPUT_POST, "fecha_final", FILTER_SANITIZE_STRING);
	        $dias_total =filter_input(INPUT_POST, "dias_total", FILTER_SANITIZE_STRING);
	        $tiempo_transcurrido=filter_input(INPUT_POST, "tiempo_transcurrido", FILTER_SANITIZE_STRING);
	        $presupuesto_total_obra=filter_input(INPUT_POST, "presupuesto_total_obra", FILTER_SANITIZE_STRING);
	        $presupuesto_actualizado=filter_input(INPUT_POST, "presupuesto_actualizado", FILTER_SANITIZE_STRING);
	        $costo_mano_obra=filter_input(INPUT_POST, "costo_mano_obra", FILTER_SANITIZE_STRING);

			
			//tranferencia de variables a la clase seguimiento_de_obraDTO

			$rolDTO->setrol_id($rol_id);
			$rolDTO->setFecha_informe($fecha_informe);
			$rolDTO->setNumero_informe($numero_informe);
			$rolDTO->setFecha_inicio($fecha_inicio);
		  $rolDTO->setFecha_final($fecha_final);
			$rolDTO->setDias_total($dias_total);
			$rolDTO->setTiempo_transcurrido($tiempo_transcurrido);
			$rolDTO->setPresupuesto_total_obra($presupuesto_total_obra);
			$rolDTO->setPresupuesto_actualizado($presupuesto_actualizado);
			$rolDTO->setCosto_mano_obra($costo_mano_obra);
		
			
			
			if($rolDAO->crearrol($rolDTO)){
         echo '<!DOCTYPE html>

                            <html lang="es">
                                <head>
                                    <title>Mensaje Exitoso</title>
                                    <meta charset="UTF-8"> 
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
                                    <link rel="stylesheet" href="../styles/css/styles.css">
                                </head>
                                <body class="imagenMsj"> 
                                <div class="mensaje">
                                      Se creo el seguimiento de obra exitosamente clic en volver para retornar a la pagina.!
                                      <br>
                                 <a>
                                         <button onclick=location.href="../inicio.php" class="btn btn-primary">Volver</button>
                                         <br>
                                 </a>
                                 </div>
                              
                                </body>
                                </html>';

            }
			
		}catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
                
                break;
        case 'editar':
            
        try {
			$rolDTO = new rolDTO();
			$rolDAO = new rolDAO();
			
			
			//variables que recibe del formulario para rolDTO

       	$rol_id=filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
        $fecha_informe =filter_input(INPUT_POST, "fecha_informe", FILTER_SANITIZE_STRING);
		    $numero_informe =filter_input(INPUT_POST, "numero_informe", FILTER_SANITIZE_STRING);
        $fecha_inicio =filter_input(INPUT_POST, "fecha_inicio", FILTER_SANITIZE_STRING);
        $fecha_final =filter_input(INPUT_POST, "fecha_final", FILTER_SANITIZE_STRING);
        $dias_total =filter_input(INPUT_POST, "dias_total", FILTER_SANITIZE_STRING);
        $tiempo_transcurrido=filter_input(INPUT_POST, "tiempo_transcurrido", FILTER_SANITIZE_STRING);
        $presupuesto_total_obra=filter_input(INPUT_POST, "presupuesto_total_obra", FILTER_SANITIZE_STRING);
        $presupuesto_actualizado=filter_input(INPUT_POST, "presupuesto_actualizado", FILTER_SANITIZE_STRING);
        $costo_mano_obra=filter_input(INPUT_POST, "costo_mano_obra", FILTER_SANITIZE_STRING);


			
			

			//tranferencia de variables a la clase rolDTO

			$rolDTO->setrol_id($rol_id);
      $rolDTO->setFecha_informe($fecha_informe);
			$rolDTO->setNumero_informe($numero_informe);
			$rolDTO->setFecha_inicio($fecha_inicio);
		  $rolDTO->setFecha_final($fecha_final);
			$rolDTO->setDias_total($dias_total);
			$rolDTO->setTiempo_transcurrido($tiempo_transcurrido);
			$rolDTO->setPresupuesto_total_obra($presupuesto_total_obra);
			$rolDTO->setPresupuesto_actualizado($presupuesto_actualizado);
			$rolDTO->setCosto_mano_obra($costo_mano_obra);
			
			if($rolDAO->editarrol($rolDTO)){
				
                echo '<!DOCTYPE html>

                            <html lang="es">
                                <head>
                                    <title>Mensaje Exitoso</title>
                                    <meta charset="UTF-8"> 
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
                                    <link rel="stylesheet" href="../styles/css/styles.css">
                                </head>
                                <body class="imagenMsj"> 
                                <div class="mensaje">
                                      Se creo el seguimiento de obra exitosamente clic en volver para retornar a la pagina.!
                                      <br>
                                 <a>
                                         <button onclick=location.href="../inicio.php" class="btn btn-primary">Volver</button>
                                         <br>
                                 </a>
                                 </div>
                              
                                </body>
                                </html>';
            
        }
     } catch (Exception $ex) {
            
            echo "Ha sucedido el siguiente error: ".$ex->getMessage();
            
            }
            
            break;
            
    case 'eliminar':
        try {
            $rol_id = filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_NUMBER_INT);
            $rolDAO = new rolDAO();
            $rolDTO = new rolDTO();

            $rol = $rolDAO->listaSeguimientosPorId($rol_id);

            if ($rol) { 
                $rolDTO->mapear($rol);
                if ($rolDAO->eliminarSeguimiento($rolDTO)) {
                   
                echo '<!DOCTYPE html>

                            <html lang="es">
                                <head>
                                    <title>Mensaje Exitoso</title>
                                    <meta charset="UTF-8"> 
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
                                    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
                                    <link rel="stylesheet" href="../styles/css/styles.css">
                                </head>
                                <body class="imagenMsj"> 
                                <div class="mensaje">
                                      Se creo el seguimiento de obra exitosamente clic en volver para retornar a la pagina.!
                                      <br>
                                 <a>
                                         <button onclick=location.href="../inicio.php" class="btn btn-primary">Volver</button>
                                         <br>
                                 </a>
                                 </div>
                              
                                </body>
                                </html>';

                }
            } else {
                throw new Exception(javascript::alert("El seguimiento no existe"));
            }
        } catch (Exception $ex) {
            javascript::alert("Ha sucedido el siguiente11 error :  ".$ex->getMessage());
        }



        
            
}              */

  
?>
