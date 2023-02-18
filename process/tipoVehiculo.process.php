<?php
	
require("../class/db.class.php");
require("../class/tipoVehiculoDTO.php");
require("../class/tipoVehiculoDAO.php");


class tipoVehiculoProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $tipoVehiculoDTO = new tipoVehiculoDTO();
            $tipoVehiculoDAO = new tipoVehiculoDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchtipoVehiculo = $tipoVehiculoDAO->buscartipoVehiculo($busqueda);

            if($serchtipoVehiculo!= ''){
               echo json_encode($serchtipoVehiculo);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $tipoVehiculoDTO = new tipoVehiculoDTO();
            $tipoVehiculoDAO = new tipoVehiculoDAO();
          
            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            
            $gettipoVehiculo = $tipoVehiculoDAO->traerDatos($tipo_vehiculo_id);
            
            if($gettipoVehiculo>0){
               echo json_encode($gettipoVehiculo);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $tipoVehiculoDTO = new tipoVehiculoDTO();
            $tipoVehiculoDAO = new tipoVehiculoDAO();
       
            $tipo =filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $tipoVehiculoDTO->setTipo($tipo);
            $tipoVehiculoDTO->setEstado($estado);
            
            $savetipoVehiculo = $tipoVehiculoDAO->creartipoVehiculo($tipoVehiculoDTO);

            if($savetipoVehiculo>0){
               echo json_encode($savetipoVehiculo);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $tipoVehiculoDTO = new tipoVehiculoDTO();
            $tipoVehiculoDAO = new tipoVehiculoDAO();

            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            $tipo =filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $tipoVehiculoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            $tipoVehiculoDTO->setTipo($tipo);
            $tipoVehiculoDTO->setEstado($estado);
            
            $updatetipoVehiculo= $tipoVehiculoDAO->actualizartipoVehiculo($tipoVehiculoDTO);

            if($updatetipoVehiculo>0){
               echo json_encode($updatetipoVehiculo);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $tipoVehiculoDTO = new tipoVehiculoDTO();
            $tipoVehiculoDAO = new tipoVehiculoDAO();

            $tipo_vehiculo_id=filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
	       
            $tipoVehiculoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            
            $deletetipoVehiculo = $tipoVehiculoDAO->eliminartipoVehiculo($tipoVehiculoDTO);

            if($deletetipoVehiculo>0){
               echo json_encode($deletetipoVehiculo);
            }
    }


}
$tipoVehiculoProcess = new tipoVehiculoProcess();
       
