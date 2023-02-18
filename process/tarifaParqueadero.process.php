<?php
	
require("../class/db.class.php");
require("../class/tarifaParqueaderoDTO.php");
require("../class/tarifaParqueaderoDAO.php");


class tarifaParqueaderoProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $tarifaParqueaderoDTO = new tarifaParqueaderoDTO();
            $tarifaParqueaderoDAO = new tarifaParqueaderoDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchTarifaParqueadero = $tarifaParqueaderoDAO->buscarTarifaParqueadero($busqueda);

            if($serchTarifaParqueadero!= ''){
               echo json_encode($serchTarifaParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $tarifaParqueaderoDTO = new tarifaParqueaderoDTO();
            $tarifaParqueaderoDAO = new tarifaParqueaderoDAO();
          
            $tarifas_parqueadero_id =filter_input(INPUT_POST, "tarifas_parqueadero_id", FILTER_SANITIZE_STRING);
            
            $getTarifaParqueadero = $tarifaParqueaderoDAO->traerDatos($tarifas_parqueadero_id);
            
            if($getTarifaParqueadero>0){
               echo json_encode($getTarifaParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $tarifaParqueaderoDTO = new tarifaParqueaderoDTO();
            $tarifaParqueaderoDAO = new tarifaParqueaderoDAO();
       
            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            $valor_hora_diurna =filter_input(INPUT_POST, "valor_hora_diurna", FILTER_SANITIZE_STRING);
            $valor_hora_nocturna =filter_input(INPUT_POST, "valor_hora_nocturna", FILTER_SANITIZE_STRING);
            $valor_dia =filter_input(INPUT_POST, "valor_dia", FILTER_SANITIZE_STRING);
            $valor_medio_dia =filter_input(INPUT_POST, "valor_medio_dia", FILTER_SANITIZE_STRING);
            $valor_mes =filter_input(INPUT_POST, "valor_mes", FILTER_SANITIZE_STRING);
            $tiempo_cobro =filter_input(INPUT_POST, "tiempo_cobro", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $tarifaParqueaderoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            $tarifaParqueaderoDTO->setValor_hora_diurna($valor_hora_diurna);
            $tarifaParqueaderoDTO->setValor_hora_nocturna($valor_hora_nocturna);
            $tarifaParqueaderoDTO->setValor_medio_dia($valor_medio_dia);
            $tarifaParqueaderoDTO->setValor_dia($valor_dia);
            $tarifaParqueaderoDTO->setValor_mes($valor_mes);
            $tarifaParqueaderoDTO->setTiempo_cobro($tiempo_cobro);
            $tarifaParqueaderoDTO->setEstado($estado);
            
            $saveTarifaParqueadero = $tarifaParqueaderoDAO->crearTarifaParqueadero($tarifaParqueaderoDTO);

            if($saveTarifaParqueadero>0){
               echo json_encode($saveTarifaParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $tarifaParqueaderoDTO = new tarifaParqueaderoDTO();
            $tarifaParqueaderoDAO = new tarifaParqueaderoDAO();

            $tarifas_parqueadero_id =filter_input(INPUT_POST, "tarifas_parqueadero_id", FILTER_SANITIZE_STRING);
            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            $valor_hora_diurna =filter_input(INPUT_POST, "valor_hora_diurna", FILTER_SANITIZE_STRING);
            $valor_hora_nocturna =filter_input(INPUT_POST, "valor_hora_nocturna", FILTER_SANITIZE_STRING);
            $valor_dia =filter_input(INPUT_POST, "valor_dia", FILTER_SANITIZE_STRING);
            $valor_medio_dia =filter_input(INPUT_POST, "valor_medio_dia", FILTER_SANITIZE_STRING);
            $valor_mes =filter_input(INPUT_POST, "valor_mes", FILTER_SANITIZE_STRING);
            $tiempo_cobro =filter_input(INPUT_POST, "tiempo_cobro", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $tarifaParqueaderoDTO->setTarifas_parqueadero_id($tarifas_parqueadero_id);
            $tarifaParqueaderoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            $tarifaParqueaderoDTO->setValor_hora_diurna($valor_hora_diurna);
            $tarifaParqueaderoDTO->setValor_hora_nocturna($valor_hora_nocturna);
            $tarifaParqueaderoDTO->setValor_dia($valor_dia);
            $tarifaParqueaderoDTO->setValor_medio_dia($valor_medio_dia);
            $tarifaParqueaderoDTO->setValor_mes($valor_mes);
            $tarifaParqueaderoDTO->setTiempo_cobro($tiempo_cobro);
            $tarifaParqueaderoDTO->setEstado($estado);
            
            $updateTarifaParqueadero= $tarifaParqueaderoDAO->actualizarTarifaParqueadero($tarifaParqueaderoDTO);

            if($updateTarifaParqueadero>0){
               echo json_encode($updateTarifaParqueadero);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $tarifaParqueaderoDTO = new tarifaParqueaderoDTO();
            $tarifaParqueaderoDAO = new tarifaParqueaderoDAO();

            $tarifas_parqueadero_id=filter_input(INPUT_POST, "tarifas_parqueadero_id", FILTER_SANITIZE_STRING);
	       
            $tarifaParqueaderoDTO->setTarifaParqueadero_id($tarifas_parqueadero_id);
            
            $deleteTarifaParqueadero = $tarifaParqueaderoDAO->eliminarTarifaParqueadero($tarifaParqueaderoDTO);

            if($deleteTarifaParqueadero>0){
               echo json_encode($deleteTarifaParqueadero);
            }
    }


}
$tarifaParqueaderoProcess = new tarifaParqueaderoProcess();
       
