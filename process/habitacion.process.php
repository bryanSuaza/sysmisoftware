<?php
	
require("../class/db.class.php");
require("../class/habitacionDTO.php");
require("../class/habitacionDAO.php");

class habitacionProcess {


    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $habitacionDTO = new habitacionDTO();
            $habitacionDAO = new habitacionDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchHabitacion = $habitacionDAO->buscarHabitacion($busqueda);

            if($serchHabitacion!= ''){
               echo json_encode($serchHabitacion);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $habitacionDTO = new habitacionDTO();
            $habitacionDAO = new habitacionDAO();

            $habitacion_id =filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
            
            $getHabitacion = $habitacionDAO->traerDatos($habitacion_id);
            
            if($getHabitacion>0){
               echo json_encode($getHabitacion);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $habitacionDTO = new habitacionDTO();
            $habitacionDAO = new habitacionDAO();
       
            $numero =filter_input(INPUT_POST, "numero", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
            $descripcion =filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $tipo_habitacion_id =filter_input(INPUT_POST, "tipo_habitacion_id", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            
            $imagen_error =$_FILES['foto']['error'];

            if(!$imagen_error > 0){

               $nombre_imagen= $_FILES['foto']['name'];
               $tipo_imagen= $_FILES['foto']['type'];
               $tamaño_imagen= $_FILES['foto']['size'];

               if($tamaño_imagen<=4000000){
                  if($tipo_imagen == "image/jpg" || $tipo_imagen == "image/png"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['foto']['tmp_name'],$carpeta_destino.$nombre_imagen);

                     $habitacionDTO->setImagen($nombre_imagen);

                  }else{
                     
                     $saveHabitacion = 3;
                     echo json_encode($saveHabitacion);
                     exit();
                  }
               }else{
                  
                  $saveHabitacion = 4;
                  echo json_encode($saveHabitacion);
                  exit();
               }

            }else{
               $habitacionDTO->setImagen('');
            }

            
            $habitacionDTO->setNumero($numero);
            $habitacionDTO->setValor($valor);
            $habitacionDTO->setDescripcion($descripcion);
            $habitacionDTO->setEstado($estado);
            $habitacionDTO->setTipo_habitacion_id($tipo_habitacion_id);
            
            $habitacionDTO->setUsuario_id($usuario_id);
          
            $saveHabitacion = $habitacionDAO->crearHabitacion($habitacionDTO);

            if($saveHabitacion>0){
               echo json_encode($saveHabitacion);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $habitacionDTO = new habitacionDTO();
            $habitacionDAO = new habitacionDAO();
            

            $habitacion_id =filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
            $numero =filter_input(INPUT_POST, "numero", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
            $descripcion =filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $tipo_habitacion_id =filter_input(INPUT_POST, "tipo_habitacion_id", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);

            $imagen_error =$_FILES['foto']['error'];

            if(!$imagen_error > 0){
            
               $nombre_imagen= $_FILES['foto']['name'];
               $tipo_imagen= $_FILES['foto']['type'];
               $tamaño_imagen= $_FILES['foto']['size'];

               if($tamaño_imagen<=2000000){
                  if($tipo_imagen == "image/jpg" || $tipo_imagen == "image/png"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['foto']['tmp_name'],$carpeta_destino.$nombre_imagen);

                     $habitacionDTO->setImagen($nombre_imagen);

                  }else{
                     $updateHabitacion = 4;
                     echo json_encode($updateHabitacion);
                     exit();
                  }
               }else{
                  $updateHabitacion = 3;
                  echo json_encode($updateHabitacion);
                  exit();
               }

            }else{
               $habitacionDTO->setImagen('');
            }

            
            $habitacionDTO->setHabitacion_id($habitacion_id);
            $habitacionDTO->setNumero($numero);
            $habitacionDTO->setValor($valor);
            $habitacionDTO->setDescripcion($descripcion);
            $habitacionDTO->setEstado($estado);
            $habitacionDTO->setTipo_habitacion_id($tipo_habitacion_id);
            $habitacionDTO->setUsuario_id($usuario_id);
            
            $updateHabitacion= $habitacionDAO->actualizarHabitacion($habitacionDTO);

            if($updateHabitacion>0){
               echo json_encode($updateHabitacion);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $habitacionDTO = new habitacionDTO();
            $habitacionDAO = new habitacionDAO();

            $habitacion_id=filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
	       
            $habitacionDTO->setHabitacion_id($habitacion_id);
            
            $deleteHabitacion = $habitacionDAO->eliminarHabitacion($habitacionDTO);

            if($deleteHabitacion>0){
               echo json_encode($deleteHabitacion);
            }
    }

}
$habitacionProcess = new habitacionProcess(); 