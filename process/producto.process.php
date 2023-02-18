<?php
	
require("../class/db.class.php");
require("../class/productoDTO.php");
require("../class/productoDAO.php");

class productoProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $productoDTO = new productoDTO();
            $productoDAO = new productoDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchProducto = $productoDAO->buscarProducto($busqueda);

            if($serchProducto!= ''){
               echo json_encode($serchProducto);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $productoDTO = new productoDTO();
            $productoDAO = new productoDAO();

            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            
            $getProducto = $productoDAO->traerDatos($producto_id);
            
            if($getProducto>0){
               echo json_encode($getProducto);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $productoDTO = new productoDTO();
            $productoDAO = new productoDAO();

            $nombre =filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
            $categoria_id =filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_STRING);
            $valor_costo =filter_input(INPUT_POST, "valor_costo", FILTER_SANITIZE_STRING);
            $valor_venta =filter_input(INPUT_POST, "valor_venta", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
         
            $productoDTO->setNombre($nombre);
            $productoDTO->setCategoria_id($categoria_id);
            $productoDTO->setValor_costo($valor_costo);
            $productoDTO->setValor_venta($valor_venta);
            $productoDTO->setEstado($estado);
            
            $saveProducto = $productoDAO->crearProducto($productoDTO);

            if($saveProducto>0){
               echo json_encode($saveProducto);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

            $productoDTO = new productoDTO();
            $productoDAO = new productoDAO();

            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            $nombre =filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
            $categoria_id =filter_input(INPUT_POST, "categoria_id", FILTER_SANITIZE_STRING);
            $valor_costo =filter_input(INPUT_POST, "valor_costo", FILTER_SANITIZE_STRING);
            $valor_venta =filter_input(INPUT_POST, "valor_venta", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
         
            $productoDTO->setProducto_id($producto_id);
            $productoDTO->setNombre($nombre);
            $productoDTO->setCategoria_id($categoria_id);
            $productoDTO->setValor_costo($valor_costo);
            $productoDTO->setValor_venta($valor_venta);
            $productoDTO->setEstado($estado);
            
            $updateProducto= $productoDAO->actualizarProducto($productoDTO);

            if($updateProducto>0){
               echo json_encode($updateProducto);
            }

    }

    public function delete(){

            $productoDTO = new productoDTO();
            $productoDAO = new productoDAO();

            $producto_id=filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
	       
            $productoDTO->setProducto_id($producto_id);
            
            $deleteProducto = $productoDAO->eliminarProducto($productoDTO);

            if($deleteProducto>0){
               echo json_encode($deleteProducto);
            }
    }

}
$productoProcess = new productoProcess();