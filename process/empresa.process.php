<?php
	
require("../class/db.class.php");
require("../class/empresaDTO.php");
require("../class/empresaDAO.php");
require("../class/terceroDTO.php");

class empresaProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();
            $terceroDTO = new terceroDTO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchEmpresa = $empresaDAO->buscarEmpresa($busqueda);

            if($serchEmpresa!= ''){
               echo json_encode($serchEmpresa);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();
            $terceroDTO = new terceroDTO();

            $empresa_id =filter_input(INPUT_POST, "empresa_id", FILTER_SANITIZE_STRING);
            
            $getEmpresa = $empresaDAO->traerDatos($empresa_id);
            
            if($getEmpresa>0){
               echo json_encode($getEmpresa);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();
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
            $representante =filter_input(INPUT_POST, "representante", FILTER_SANITIZE_STRING);
            $ubicacion =filter_input(INPUT_POST, "ubicacion", FILTER_SANITIZE_STRING);
            $direccion =filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_STRING);
            $pagina =filter_input(INPUT_POST, "pagina", FILTER_SANITIZE_STRING);
            $registro_mercantil =filter_input(INPUT_POST, "registro_mercantil", FILTER_SANITIZE_STRING);
            $camara_comercio =filter_input(INPUT_POST, "camara_comercio", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);

            //logo empresa
            $imagen_error =$_FILES['logo_empresa']['error'];
            
            if(!$imagen_error > 0){

               $nombre_imagen= $_FILES['logo_empresa']['name'];
               $tipo_imagen= $_FILES['logo_empresa']['type'];
               $tamaño_imagen= $_FILES['logo_empresa']['size'];
                
               if($tamaño_imagen<=50000000000){
                 
                  if($tipo_imagen == "image/jpg" || $tipo_imagen == "image/png" || $tipo_imagen == "image/gif" || $tipo_imagen == "image/jpeg"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['logo_empresa']['tmp_name'],$carpeta_destino.$nombre_imagen);

                     $empresaDTO->setLogo_empresa($nombre_imagen);

                  }else{
                     
                     $saveLogo = 3;
                     echo json_encode($saveLogo);
                     exit();
                  }
               }else{
                  echo("es por el tamaño");
                  
                  $saveLogo = 4;
                  echo json_encode($saveLogo);
                  exit();
               }

            }else{
               $empresaDTO->setLogo_empresa('');
            }

            //foto empresa
            $imagen_empresa_error =$_FILES['foto_empresa']['error'];

            if(!$imagen_empresa_error > 0){

               $nombre_imagen_empresa= $_FILES['foto_empresa']['name'];
               $tipo_imagen_empresa= $_FILES['foto_empresa']['type'];
               $tamaño_imagen_empresa= $_FILES['foto_empresa']['size'];

               if($tamaño_imagen_empresa<=5000000){
                  if($tipo_imagen_empresa == "image/jpg" || $tipo_imagen_empresa == "image/png"){

                      $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);

                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['foto_empresa']['tmp_name'],$carpeta_destino.$nombre_imagen_empresa);

                     $empresaDTO->setFoto_empresa($nombre_imagen_empresa);

                  }else{
                     
                     $saveFoto = 3;
                     echo json_encode($saveFoto);
                     exit();
                  }
               }else{
                  
                  $saveFoto = 4;
                  echo json_encode($saveFoto);
                  exit();
               }

            }else{
               $empresaDTO->setFoto_empresa('');
            }

            //archivo registro mercantil
            $doc_registro_error =$_FILES['doc_registro']['error'];

            if(!$doc_registro_error > 0){

               $nombre_doc_registro= $_FILES['doc_registro']['name'];
               $tipo_doc_registro= $_FILES['doc_registro']['type'];
               $tamaño_doc_registro= $_FILES['doc_registro']['size'];
              
               if($tamaño_doc_registro<=30000000){
                  
                  if($tipo_doc_registro == "application/pdf"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);

                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/docs_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['doc_registro']['tmp_name'],$carpeta_destino.$nombre_doc_registro);

                     $empresaDTO->setDoc_registro($nombre_doc_registro);

                  }else{
                     
                     $saveDoc_registro = 5;
                     echo json_encode($saveDoc_registro);
                     exit();
                  }
               }else{
                  
                  $saveDoc_registro = 6;
                  echo json_encode($saveDoc_registro);
                  exit();
               }

            }else{
               $empresaDTO->setDoc_registro('');
            }

             //archivo camara comercio
            $doc_camara_error =$_FILES['doc_camara']['error'];

            if(!$doc_camara_error > 0){

               $nombre_doc_camara= $_FILES['doc_camara']['name'];
               $tipo_doc_camara= $_FILES['doc_camara']['type'];
               $tamaño_doc_camara= $_FILES['doc_camara']['size'];
              
               if($tamaño_doc_camara<=30000000){
                  
                  if($tipo_doc_camara == "application/pdf"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);

                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/docs_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['doc_camara']['tmp_name'],$carpeta_destino.$nombre_doc_camara);

                     $empresaDTO->setDoc_camara($nombre_doc_camara);

                  }else{
                     
                     $saveDoc_camara = 5;
                     echo json_encode($saveDoc_camara);
                     exit();
                  }
               }else{
                  
                  $saveDoc_camara = 6;
                  echo json_encode($saveDoc_camara);
                  exit();
               }

            }else{
               $empresaDTO->setDoc_camara('');
            }
            
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
            $empresaDTO->setRepresentante($representante);
            $empresaDTO->setUbicacion($ubicacion);
            $empresaDTO->setDireccion($direccion);
            $empresaDTO->setPagina($pagina);
            $empresaDTO->setRegistro_mercantil($registro_mercantil);
            $empresaDTO->setCamara_comercio($camara_comercio);
            $empresaDTO->setEstado($estado);
            
            $saveEmpresa = $empresaDAO->crearEmpresa($empresaDTO,$terceroDTO);

            if($saveEmpresa>0){
               echo json_encode($saveEmpresa);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();
            $terceroDTO = new terceroDTO();

            $empresa_id =filter_input(INPUT_POST, "empresa_id", FILTER_SANITIZE_STRING);
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
            $representante =filter_input(INPUT_POST, "representante", FILTER_SANITIZE_STRING);
            $ubicacion =filter_input(INPUT_POST, "ubicacion", FILTER_SANITIZE_STRING);
            $direccion =filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_STRING);
            $pagina =filter_input(INPUT_POST, "pagina", FILTER_SANITIZE_STRING);
            $registro_mercantil =filter_input(INPUT_POST, "registro_mercantil", FILTER_SANITIZE_STRING);
            $camara_comercio =filter_input(INPUT_POST, "camara_comercio", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);

            //logo_empresa
            $imagen_error =$_FILES['logo_empresa']['error'];

            if(!$imagen_error > 0){

               $nombre_imagen= $_FILES['logo_empresa']['name'];
               $tipo_imagen= $_FILES['logo_empresa']['type'];
               $tamaño_imagen= $_FILES['logo_empresa']['size'];

               if($tamaño_imagen<=50000000){
                  if($tipo_imagen == "image/jpg" || $tipo_imagen == "image/png" || $tipo_imagen == "image/gif" || $tipo_imagen == "image/jpeg"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';

      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['logo_empresa']['tmp_name'],$carpeta_destino.$nombre_imagen);

                     $empresaDTO->setLogo_empresa($nombre_imagen);

                  }else{
                     
                     $saveLogo = 3;
                     echo json_encode($saveLogo);
                     exit();
                  }
               }else{
                  
                  $saveLogo = 4;
                  echo json_encode($saveLogo);
                  exit();
               }

            }else{
               $empresaDTO->setLogo_empresa('');
            }

            //foto empresa
            $imagen_empresa_error =$_FILES['foto_empresa']['error'];

            if(!$imagen_empresa_error > 0){

               $nombre_imagen_empresa= $_FILES['foto_empresa']['name'];
               $tipo_imagen_empresa= $_FILES['foto_empresa']['type'];
               $tamaño_imagen_empresa= $_FILES['foto_empresa']['size'];

               if($tamaño_imagen_empresa<=3000000){
                  
                  if($tipo_imagen_empresa == "image/jpeg" || $tipo_imagen_empresa == "image/png" || $tipo_imagen_empresa == "image/jpg"){
                 
                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/img_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['foto_empresa']['tmp_name'],$carpeta_destino.$nombre_imagen_empresa);

                     $empresaDTO->setFoto_empresa($nombre_imagen_empresa);

                  }else{
                     
                     $saveFoto = 4;
                     echo json_encode($saveFoto);
                     exit();
                  }
               }else{
                  
                  $saveFoto = 3;
                  echo json_encode($saveFoto);
                  exit();
               }

            }else{
               $empresaDTO->setFoto_empresa('');
            }

             //archivo registro mercantil
            $doc_registro_error =$_FILES['doc_registro']['error'];

            if(!$doc_registro_error > 0){

               $nombre_doc_registro= $_FILES['doc_registro']['name'];
               $tipo_doc_registro= $_FILES['doc_registro']['type'];
               $tamaño_doc_registro= $_FILES['doc_registro']['size'];
              
               if($tamaño_doc_registro<=3000000){
                 
                  if($tipo_doc_registro == "application/pdf"){

                    $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/docs_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['doc_registro']['tmp_name'],$carpeta_destino.$nombre_doc_registro);

                     $empresaDTO->setDoc_registro($nombre_doc_registro);

                  }else{
                     
                     $saveDoc_registro = 6;
                     echo json_encode($saveDoc_registro);
                     exit();
                  }
               }else{
                  
                  $saveDoc_registro = 5;
                  echo json_encode($saveDoc_registro);
                  exit();
               }

            }else{
               $empresaDTO->setDoc_registro('');
            }

            //archivo camara comercio
            $doc_camara_error =$_FILES['doc_camara']['error'];

            if(!$doc_camara_error > 0){

               $nombre_doc_camara= $_FILES['doc_camara']['name'];
               $tipo_doc_camara= $_FILES['doc_camara']['type'];
               $tamaño_doc_camara= $_FILES['doc_camara']['size'];
              
               if($tamaño_doc_camara<=3000000){
                  
                  if($tipo_doc_camara == "application/pdf"){

                     $url=$_SERVER['PHP_SELF'];
                     $url = explode('/', $url);
   
                     //ruta de la carpeta destino en el servidor
                     $carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/process/docs_uploads/';
      
                     //movemos la imagen del directorio temporal al directorio escogido
                     move_uploaded_file($_FILES['doc_camara']['tmp_name'],$carpeta_destino.$nombre_doc_camara);

                     $empresaDTO->setDoc_camara($nombre_doc_camara);

                  }else{
                     
                     $saveDoc_camara = 5;
                     echo json_encode($saveDoc_camara);
                     exit();
                  }
               }else{
                  
                  $saveDoc_camara = 6;
                  echo json_encode($saveDoc_camara);
                  exit();
               }

            }else{
               $empresaDTO->setDoc_camara('');
            }
            
            $empresaDTO->setEmpresa_id($empresa_id);
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
            $empresaDTO->setRepresentante($representante);
            $empresaDTO->setUbicacion($ubicacion);
            $empresaDTO->setDireccion($direccion);
            $empresaDTO->setPagina($pagina);
            $empresaDTO->setRegistro_mercantil($registro_mercantil);
            $empresaDTO->setCamara_comercio($camara_comercio);
            $empresaDTO->setEstado($estado);
            
            $updateEmpresa= $empresaDAO->actualizarEmpresa($empresaDTO, $terceroDTO);

            if($updateEmpresa>0){
               echo json_encode($updateEmpresa);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();

            $empresa_id=filter_input(INPUT_POST, "empresa_id", FILTER_SANITIZE_STRING);
	       
            $empresaDTO->setEmpresa_id($empresa_id);
            
            $deleteEmpresa = $empresaDAO->eliminarEmpresa($empresaDTO);

            if($deleteEmpresa>0){
               echo json_encode($deleteEmpresa);
            }
    }

    public function getTercero(){

	    try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();
            $terceroDTO = new terceroDTO();

            $numero_identificacion =filter_input(INPUT_POST, "numero_identificacion", FILTER_SANITIZE_STRING);
            
            $getTercero = $empresaDAO->traerTercero($numero_identificacion);
            
            if($getTercero>0){
               echo json_encode($getTercero);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getArchivo(){

	    try{

            $empresaDTO = new empresaDTO();
            $empresaDAO = new empresaDAO();

            $empresa_id =filter_input(INPUT_POST, "empresa_id", FILTER_SANITIZE_STRING);
            
            $getArchivo = $empresaDAO->traerArchivo($empresa_id);
            
            if($getArchivo>0){
               echo json_encode($getArchivo);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

}
$empresaProcess = new empresaProcess();
       
