<?php
	
require("../class/db.class.php");
require("../class/clienteDTO.php");
require("../class/clienteDAO.php");
require("../class/terceroDTO.php");

class clienteProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();
            $terceroDTO = new terceroDTO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchCliente = $clienteDAO->buscarCliente($busqueda);

            if($serchCliente!= ''){
               echo json_encode($serchCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();
            $terceroDTO = new terceroDTO();

            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            
            $getCliente = $clienteDAO->traerDatos($cliente_id);
            
            if($getCliente>0){
               echo json_encode($getCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();
            $terceroDTO = new terceroDTO();
       
            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            $digito_verificacion =filter_input(INPUT_POST, "digito_verificacion", FILTER_SANITIZE_STRING);
            $primer_nombre =filter_input(INPUT_POST, "primer_nombre", FILTER_SANITIZE_STRING);
            $segundo_nombre =filter_input(INPUT_POST, "segundo_nombre", FILTER_SANITIZE_STRING);
            $primer_apellido =filter_input(INPUT_POST, "primer_apellido", FILTER_SANITIZE_STRING);
            $segundo_apellido =filter_input(INPUT_POST, "segundo_apellido", FILTER_SANITIZE_STRING);
            $razon_social =filter_input(INPUT_POST, "razon_social", FILTER_SANITIZE_STRING);
            $email =filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
            $telefono =filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);
            $tipo_persona_id =filter_input(INPUT_POST, "tipo_persona_id", FILTER_SANITIZE_STRING);
            $banco =filter_input(INPUT_POST, "banco", FILTER_SANITIZE_STRING);
            $numero_cuenta =filter_input(INPUT_POST, "numero_cuenta", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $terceroDTO->setNumero_identificacion($numero_identificacion);
            $terceroDTO->setDigito_verificacion($digito_verificacion);
            $terceroDTO->setPrimer_nombre($primer_nombre);
            $terceroDTO->setSegundo_nombre($segundo_nombre);
            $terceroDTO->setPrimer_apellido($primer_apellido);
            $terceroDTO->setSegundo_apellido($segundo_apellido);
            $terceroDTO->setRazon_social($razon_social);
            $terceroDTO->setEmail($email);
            $terceroDTO->setTelefono($telefono);
            $terceroDTO->setTipo_persona_id($tipo_persona_id);
            $clienteDTO->setBanco($banco);
            $clienteDTO->setNumero_cuenta($numero_cuenta);
            $clienteDTO->setUsuario_id($usuario_id);
            $clienteDTO->setEstado($estado);
            
            $saveCliente = $clienteDAO->crearCliente($clienteDTO,$terceroDTO);

            if($saveCliente>0){
               echo json_encode($saveCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();
            $terceroDTO = new terceroDTO();

            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            $digito_verificacion =filter_input(INPUT_POST, "digito_verificacion", FILTER_SANITIZE_STRING);
            $primer_nombre =filter_input(INPUT_POST, "primer_nombre", FILTER_SANITIZE_STRING);
            $segundo_nombre =filter_input(INPUT_POST, "segundo_nombre", FILTER_SANITIZE_STRING);
            $primer_apellido =filter_input(INPUT_POST, "primer_apellido", FILTER_SANITIZE_STRING);
            $segundo_apellido =filter_input(INPUT_POST, "segundo_apellido", FILTER_SANITIZE_STRING);
            $razon_social =filter_input(INPUT_POST, "razon_social", FILTER_SANITIZE_STRING);
            $email =filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
            $telefono =filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);
            $tipo_persona_id =filter_input(INPUT_POST, "tipo_persona_id", FILTER_SANITIZE_STRING);
            $banco =filter_input(INPUT_POST, "banco", FILTER_SANITIZE_STRING);
            $numero_cuenta =filter_input(INPUT_POST, "numero_cuenta", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $clienteDTO->setCliente_id($cliente_id);
            $terceroDTO->setNumero_identificacion($numero_identificacion);
            $terceroDTO->setDigito_verificacion($digito_verificacion);
            $terceroDTO->setPrimer_nombre($primer_nombre);
            $terceroDTO->setSegundo_nombre($segundo_nombre);
            $terceroDTO->setPrimer_apellido($primer_apellido);
            $terceroDTO->setSegundo_apellido($segundo_apellido);
            $terceroDTO->setRazon_social($razon_social);
            $terceroDTO->setEmail($email);
            $terceroDTO->setTelefono($telefono);
            $terceroDTO->setTipo_persona_id($tipo_persona_id);
            $clienteDTO->setBanco($banco);
            $clienteDTO->setNumero_cuenta($numero_cuenta);
            $clienteDTO->setUsuario_id($usuario_id);
            $clienteDTO->setEstado($estado);
            
            $updateCliente= $clienteDAO->actualizarCliente($clienteDTO, $terceroDTO);

            if($updateCliente>0){
               echo json_encode($updateCliente);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();

            $cliente_id=filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
	       
            $clienteDTO->setCliente_id($cliente_id);
            
            $deleteCliente = $clienteDAO->eliminarCliente($clienteDTO);

            if($deleteCliente>0){
               echo json_encode($deleteCliente);
            }
    }

    public function getTercero(){

	    try{

            $clienteDTO = new clienteDTO();
            $clienteDAO = new clienteDAO();
            $terceroDTO = new terceroDTO();

            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            
            $getTercero = $clienteDAO->traerTercero($numero_identificacion);
            
            if($getTercero>0){
               echo json_encode($getTercero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

}
$clienteProcess = new clienteProcess();
       
