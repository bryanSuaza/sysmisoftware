<?php
	
require("../class/db.class.php");
require("../class/usuarioDTO.php");
require("../class/usuarioDAO.php");
require("../class/terceroDTO.php");

class usuarioProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();
            $terceroDTO = new terceroDTO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchUsuario = $usuarioDAO->buscarUsuario($busqueda);

            if($serchUsuario!= ''){
               echo json_encode($serchUsuario);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();
            $terceroDTO = new terceroDTO();

            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            
            $getUsuario = $usuarioDAO->traerDatos($usuario_id);
            
            if($getUsuario>0){
               echo json_encode($getUsuario);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();
            $terceroDTO = new terceroDTO();
       
            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            $primer_nombre =filter_input(INPUT_POST, "primer_nombre", FILTER_SANITIZE_STRING);
            $segundo_nombre =filter_input(INPUT_POST, "segundo_nombre", FILTER_SANITIZE_STRING);
            $primer_apellido =filter_input(INPUT_POST, "primer_apellido", FILTER_SANITIZE_STRING);
            $segundo_apellido =filter_input(INPUT_POST, "segundo_apellido", FILTER_SANITIZE_STRING);
            $email =filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
            $telefono =filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);
            $tipo_persona_id =filter_input(INPUT_POST, "tipo_persona_id", FILTER_SANITIZE_STRING);
            $username =filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $password =filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            $rol_id =filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $terceroDTO->setNumero_identificacion($numero_identificacion);
            $terceroDTO->setPrimer_nombre($primer_nombre);
            $terceroDTO->setSegundo_nombre($segundo_nombre);
            $terceroDTO->setPrimer_apellido($primer_apellido);
            $terceroDTO->setSegundo_apellido($segundo_apellido);
            $terceroDTO->setEmail($email);
            $terceroDTO->setTelefono($telefono);
            $terceroDTO->setTipo_persona_id($tipo_persona_id);
            $usuarioDTO->setUsername($username);
            $usuarioDTO->setPassword($password);
            $usuarioDTO->setRol_id($rol_id);
            $usuarioDTO->setEstado($estado);
            
            $saveUsuario = $usuarioDAO->crearUsuario($usuarioDTO,$terceroDTO);

            if($saveUsuario>0){
               echo json_encode($saveUsuario);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();
            $terceroDTO = new terceroDTO();

            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            $primer_nombre =filter_input(INPUT_POST, "primer_nombre", FILTER_SANITIZE_STRING);
            $segundo_nombre =filter_input(INPUT_POST, "segundo_nombre", FILTER_SANITIZE_STRING);
            $primer_apellido =filter_input(INPUT_POST, "primer_apellido", FILTER_SANITIZE_STRING);
            $segundo_apellido =filter_input(INPUT_POST, "segundo_apellido", FILTER_SANITIZE_STRING);
            $email =filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
            $telefono =filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);
            $tipo_persona_id =filter_input(INPUT_POST, "tipo_persona_id", FILTER_SANITIZE_STRING);
            $username =filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $password =filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            $rol_id =filter_input(INPUT_POST, "rol_id", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            
            $usuarioDTO->setUsuario_id($usuario_id);
            $terceroDTO->setNumero_identificacion($numero_identificacion);
            $terceroDTO->setPrimer_nombre($primer_nombre);
            $terceroDTO->setSegundo_nombre($segundo_nombre);
            $terceroDTO->setPrimer_apellido($primer_apellido);
            $terceroDTO->setSegundo_apellido($segundo_apellido);
            $terceroDTO->setEmail($email);
            $terceroDTO->setTelefono($telefono);
            $terceroDTO->setTipo_persona_id($tipo_persona_id);
            $usuarioDTO->setUsername($username);
            $usuarioDTO->setPassword($password);
            $usuarioDTO->setRol_id($rol_id);
            $usuarioDTO->setEstado($estado);
            
            $updateUsuario= $usuarioDAO->actualizarUsuario($usuarioDTO, $terceroDTO);

            if($updateUsuario>0){
               echo json_encode($updateUsuario);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();

            $usuario_id=filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
	       
            $usuarioDTO->setUsuario_id($usuario_id);
            
            $deleteUsuario = $usuarioDAO->eliminarUsuario($usuarioDTO);

            if($deleteUsuario>0){
               echo json_encode($deleteUsuario);
            }
    }

    public function getTercero(){

	    try{

            $usuarioDTO = new usuarioDTO();
            $usuarioDAO = new usuarioDAO();
            $terceroDTO = new terceroDTO();

            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            
            $getTercero = $usuarioDAO->traerTercero($numero_identificacion);
            
            if($getTercero>0){
               echo json_encode($getTercero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

}
$usuarioProcess = new usuarioProcess();
       
