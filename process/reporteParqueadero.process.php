<?php
	
require("../class/db.class.php");
require("../class/reporteParqueaderoDAO.php");

class reporteParqueaderoProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function generar(){

	    try{

            $reporteParqueaderoDAO = new reporteParqueaderoDAO();

            $fecha_desde =filter_input(INPUT_POST, "fecha_desde", FILTER_SANITIZE_STRING);
            $fecha_hasta =filter_input(INPUT_POST, "fecha_hasta", FILTER_SANITIZE_STRING);
            $placa =filter_input(INPUT_POST, "placa", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);

            if($placa != ''){
                $consulta = "AND p.placa = '$placa'";
            }else{
                $consulta="";
            }
          
            $reporteParqueadero = $reporteParqueaderoDAO->generarReporte($fecha_desde,$fecha_hasta,$consulta,$estado);

            if($reporteParqueadero>0){
               echo json_encode($reporteParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

}
$reporteParqueaderoProcess = new reporteParqueaderoProcess();