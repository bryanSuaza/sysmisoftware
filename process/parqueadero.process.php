<?php
	
require("../class/db.class.php");
require("../class/parqueaderoDTO.php");
require("../class/parqueaderoDAO.php");

class parqueaderoProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function save(){

	    try{

            $parqueaderoDTO = new parqueaderoDTO();
            $parqueaderoDAO = new parqueaderoDAO();

            $codigo_ticket =filter_input(INPUT_POST, "codigo_ticket", FILTER_SANITIZE_STRING);
            $placa =filter_input(INPUT_POST, "placa", FILTER_SANITIZE_STRING);
            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            $por_horas =filter_input(INPUT_POST, "por_horas", FILTER_SANITIZE_STRING);
            $por_mes =filter_input(INPUT_POST, "por_mes", FILTER_SANITIZE_STRING);
            $por_medio =filter_input(INPUT_POST, "por_medio", FILTER_SANITIZE_STRING);
            $por_dia =filter_input(INPUT_POST, "por_dia", FILTER_SANITIZE_STRING);
           
            date_default_timezone_set('America/Bogota');
            $fecha_hora_ingreso =  date("Y-m-d H:i:s");

            if($por_mes =='true'){
               $descripcion = "Servicio de parqueadero por mensualidad";
               $fecha_hora_salida =  date("Y-m-d H:i:s",strtotime($fecha_hora_ingreso."+ 1 month"));
               $parqueaderoDTO->setFecha_hora_salida($fecha_hora_salida);
            }else if($por_horas == 'true'){
               $descripcion = "Servicio de parqueadero por horas";
            }else if($por_medio == 'true'){
               $descripcion = "Servicio de parqueadero por medio dia";
            }else if($por_dia == 'true'){
               $descripcion = "Servicio de parqueadero por dia";
            }
    
            $parqueaderoDTO->setCodigo_ticket($codigo_ticket);
            $parqueaderoDTO->setPlaca($placa);
            $parqueaderoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            $parqueaderoDTO->setFecha_hora_ingreso($fecha_hora_ingreso);
            $parqueaderoDTO->setDescripcion($descripcion);
          
            $saveParqueadero = $parqueaderoDAO->ingresarParqueadero($parqueaderoDTO);

            if($saveParqueadero>0){
               echo json_encode($saveParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

            $parqueaderoDTO = new parqueaderoDTO();
            $parqueaderoDAO = new parqueaderoDAO();

            $parqueadero_id=filter_input(INPUT_POST, "parqueadero_id", FILTER_SANITIZE_STRING);
            $placa =filter_input(INPUT_POST, "placa", FILTER_SANITIZE_STRING);
            $tipo_vehiculo_id =filter_input(INPUT_POST, "tipo_vehiculo_id", FILTER_SANITIZE_STRING);
            $fecha_hora_ingreso =filter_input(INPUT_POST, "fecha_hora_ingreso", FILTER_SANITIZE_STRING);
            $fecha_hora_salida =filter_input(INPUT_POST, "fecha_hora_salida", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $descripcion =filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
            $valor_servicio =filter_input(INPUT_POST, "valor_servicio", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);

            $por_mes =filter_input(INPUT_POST, "por_mes", FILTER_SANITIZE_STRING);
            $por_dia =filter_input(INPUT_POST, "por_dia", FILTER_SANITIZE_STRING);
            $por_medio =filter_input(INPUT_POST, "por_medio", FILTER_SANITIZE_STRING);
            $por_horas =filter_input(INPUT_POST, "por_horas", FILTER_SANITIZE_STRING);

            
                       
            $parqueaderoDTO->setParqueadero_id($parqueadero_id);
            $parqueaderoDTO->setPlaca($placa);
            $parqueaderoDTO->setTipo_vehiculo_id($tipo_vehiculo_id);
            $parqueaderoDTO->setFecha_hora_ingreso($fecha_hora_ingreso);
            $parqueaderoDTO->setFecha_hora_salida($fecha_hora_salida);
            $parqueaderoDTO->setEstado($estado);
            $parqueaderoDTO->setDescripcion($descripcion);
			   $parqueaderoDTO->setValor_servicio($valor_servicio);
           
            $updateParqueadero= $parqueaderoDAO->actualizarParqueadero($parqueaderoDTO);

            if($updateParqueadero>0){
               echo json_encode($updateParqueadero);
            }

    }

    public function delete(){

            $parqueaderoDTO = new parqueaderoDTO();
            $parqueaderoDAO = new parqueaderoDAO();

            $parqueadero_id=filter_input(INPUT_POST, "parqueadero_id", FILTER_SANITIZE_STRING);
	       
            $parqueaderoDTO->setParqueadero_id($parqueadero_id);
            
            $deleteParqueadero = $parqueaderoDAO->eliminarParqueadero($parqueaderoDTO);

            if($deleteParqueadero>0){
               echo json_encode($deleteParqueadero);
            }
    }

      public function salidaVehiculo(){

	    try{

            $parqueaderoDTO = new parqueaderoDTO();
            $parqueaderoDAO = new parqueaderoDAO();

            $placa =filter_input(INPUT_POST, "placa", FILTER_SANITIZE_STRING);
    
            $parqueaderoDTO->setPlaca($placa);
          
            $salidaParqueadero = $parqueaderoDAO->salidaParqueadero($parqueaderoDTO);

            if($salidaParqueadero>0){
               echo json_encode($salidaParqueadero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function updateServicio(){

            $parqueaderoDTO = new parqueaderoDTO();
            $parqueaderoDAO = new parqueaderoDAO();

            $codigo_ticket=filter_input(INPUT_POST, "codigo_ticket", FILTER_SANITIZE_STRING);
            $fecha_hora_salida =filter_input(INPUT_POST, "fecha_hora_salida", FILTER_SANITIZE_STRING);
            $valor_servicio =filter_input(INPUT_POST, "valor_servicio", FILTER_SANITIZE_STRING);
            $horas=filter_input(INPUT_POST, "horas", FILTER_SANITIZE_STRING);
            $dias =filter_input(INPUT_POST, "dias", FILTER_SANITIZE_STRING);
            $medios_dias =filter_input(INPUT_POST, "medios_dias", FILTER_SANITIZE_STRING);
                       
            $parqueaderoDTO->setCodigo_ticket($codigo_ticket);
            $parqueaderoDTO->setFecha_hora_salida($fecha_hora_salida);
            $parqueaderoDTO->setValor_servicio($valor_servicio);
            $parqueaderoDTO->setHoras($horas);
            $parqueaderoDTO->setDias($dias);
            $parqueaderoDTO->setMediosDias($medios_dias);
           
            $updateParqueadero= $parqueaderoDAO->actualizarServicio($parqueaderoDTO);

            if($updateParqueadero>0){
               echo json_encode($updateParqueadero);
            }

    }

   public function validarMensualidad(){

      $parqueaderoDAO = new parqueaderoDAO();

      $data = $parqueaderoDAO->validarMensual();

      if($data>0){
         echo json_encode($data);
      }

   }

   public function imprimirTicket(){
  	
      include('../forms/ticket.form.php'); 
        
   }

   public function imprimirTicketSalida(){
  	
      include('../forms/ticketSalida.form.php'); 
        
   }

}
$parqueaderoProcess = new parqueaderoProcess();