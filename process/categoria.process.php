<?php
	
require("../class/db.class.php");
require("../class/categoriaDTO.php");
require("../class/categoriaDAO.php");

class categoriaProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function save(){

	    try{

            $categoriaDTO = new categoriaDTO();
            $categoriaDAO = new categoriaDAO();

            $nombre =filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    
            $categoriaDTO->setNombre($nombre);
          
            $saveCategoria = $categoriaDAO->crearCategoria($categoriaDTO);

            if($saveCategoria>0){
               echo json_encode($saveCategoria);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

            $categoriaDTO = new categoriaDTO();
            $categoriaDAO = new categoriaDAO();

            $categoria_id=filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_STRING);
            $nombre =filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
                       
            $categoriaDTO->setCategoria_id($categoria_id);
			   $categoriaDTO->setNombre($nombre);
           
            $updateCategoria= $categoriaDAO->actualizarCategoria($categoriaDTO);

            if($updateCategoria>0){
               echo json_encode($updateCategoria);
            }

    }

    public function delete(){

            $categoriaDTO = new categoriaDTO();
            $categoriaDAO = new categoriaDAO();

            $categoria_id=filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_STRING);
	       
            $categoriaDTO->setCategoria_id($categoria_id);
            
            $deleteCategoria = $categoriaDAO->eliminarCategoria($categoriaDTO);

            if($deleteCategoria>0){
               echo json_encode($deleteCategoria);
            }
    }

}
$categoriaProcess = new categoriaProcess();