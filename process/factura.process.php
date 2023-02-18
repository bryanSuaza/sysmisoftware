<?php
	
require("../class/db.class.php");
require("../class/facturaDTO.php");
require("../class/facturaDAO.php");

class facturaProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchFactura = $facturaDAO->buscarFactura($busqueda);

            if($serchFactura!= ''){
               echo json_encode($serchFactura);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            
            $getFactura = $facturaDAO->traerDatos($factura_id);
            
            if($getFactura>0){
               echo json_encode($getFactura);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();
       
            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            $fecha =filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            
            $facturaDTO->setCliente_id($cliente_id);
            $facturaDTO->setFecha($fecha);
            $facturaDTO->setEstado($estado);
            $facturaDTO->setUsuario_id($usuario_id);
            
            $saveFactura = $facturaDAO->crearFactura($facturaDTO);

            if($saveFactura>0){
               echo json_encode($saveFactura);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            $fecha =filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);

            $facturaDTO->setFactura_id($factura_id);
            $facturaDTO->setCliente_id($cliente_id);
            $facturaDTO->setFecha($fecha);
            $facturaDTO->setEstado($estado);
            $facturaDTO->setUsuario_id($usuario_id);

            $updateFactura= $facturaDAO->actualizarFactura($facturaDTO);

            if($updateFactura>0){
               echo json_encode($updateFactura);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id=filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
	       
            $facturaDTO->setFactura_id($factura_id);
            
            $deleteFactura = $facturaDAO->eliminarFactura($facturaDTO);

            if($deleteFactura>0){
               echo json_encode($deleteFactura);
            }
    }

    public function serchCliente(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchCliente = $facturaDAO->buscarCliente($busqueda);

            if($serchCliente!= ''){
               echo json_encode($serchCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDateCliente(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            
            $getCliente = $facturaDAO->traerDatosCliente($cliente_id);
            
            if($getCliente>0){
               echo json_encode($getCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }



    public function getServicios(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            
            $getServicio = $facturaDAO->getServicio($cliente_id);
            
            if($getServicio>0){
               echo json_encode($getServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getValorProducto(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            
            $getValor = $facturaDAO->traerValorProducto($producto_id);
            
            if($getValor>0){
               echo json_encode($getValor);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function saveDetalleServ(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            $servicio =filter_input(INPUT_POST, "servicio", FILTER_SANITIZE_STRING);
     
            $facturaDTO->setfactura_id($factura_id);
            
            $saveDetallefacturaServ = $facturaDAO->crearDetallefacturaServ($facturaDTO,$servicio);

            if($saveDetallefacturaServ>0){
               echo json_encode($saveDetallefacturaServ);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function saveDetalle(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            $concepto =filter_input(INPUT_POST, "concepto", FILTER_SANITIZE_STRING);
            $cantidad =filter_input(INPUT_POST, "cantidad", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
     
            $facturaDTO->setFactura_id($factura_id);
            $facturaDTO->setProducto_id($producto_id);
            $facturaDTO->setConcepto($concepto);
            $facturaDTO->setCantidad($cantidad);
            $facturaDTO->setValor($valor);
            
            $saveDetallefactura = $facturaDAO->crearDetallefactura($facturaDTO);

            if($saveDetallefactura>0){
               echo json_encode($saveDetallefactura);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

      public function updateDetalle(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            $detalle_factura_id =filter_input(INPUT_POST, "detalle_factura_id", FILTER_SANITIZE_STRING);
            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            $concepto =filter_input(INPUT_POST, "concepto", FILTER_SANITIZE_STRING);
            $cantidad =filter_input(INPUT_POST, "cantidad", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
            $iva =filter_input(INPUT_POST, "iva", FILTER_SANITIZE_STRING);
            $descuento =filter_input(INPUT_POST, "descuento", FILTER_SANITIZE_STRING);
            
            $facturaDTO->setFactura_id($factura_id);
            $facturaDTO->setProducto_id($producto_id);
            $facturaDTO->setConcepto($concepto);
            $facturaDTO->setCantidad($cantidad);
            $facturaDTO->setValor($valor);
            
            $updateDetallefactura = $facturaDAO->actualizarDetallefactura($facturaDTO);

            if($updateDetallefactura>0){
               echo json_encode($updateDetallefactura);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function updateDetalleServicio(){

	    try{

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $factura_id =filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);
            $detalle_factura_id =filter_input(INPUT_POST, "detalle_factura_id", FILTER_SANITIZE_STRING);
            $iva =filter_input(INPUT_POST, "iva", FILTER_SANITIZE_STRING);
            $descuento =filter_input(INPUT_POST, "descuento", FILTER_SANITIZE_STRING);
            
            $facturaDTO->setfactura_id($factura_id);
            
            $updateDetallefacturaServ = $facturaDAO->actualizarDetallefacturaServi($facturaDTO);

            if($updateDetallefacturaServ>0){
               echo json_encode($updateDetallefacturaServ);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function deleteDetalle(){

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $detalle_factura_id=filter_input(INPUT_POST, "detalle_factura_id", FILTER_SANITIZE_STRING);
            $factura_id=filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);

            $facturaDTO->setfactura_id($factura_id);

            $deleteDetallefactura = $facturaDAO->eliminarDetallefactura($facturaDTO);

            if($deleteDetallefactura>0){
               echo json_encode($deleteDetallefactura);
            }
    }

    public function deleteDetalleServicio(){

            $facturaDTO = new facturaDTO();
            $facturaDAO = new facturaDAO();

            $detalle_factura_id=filter_input(INPUT_POST, "detalle_factura_id", FILTER_SANITIZE_STRING);
            $factura_id=filter_input(INPUT_POST, "factura_id", FILTER_SANITIZE_STRING);

            $facturaDTO->setfactura_id($factura_id);

            $deleteDetallefacturaServi = $facturaDAO->eliminarDetallefacturaServi($facturaDTO);

            if($deleteDetallefacturaServi>0){
               echo json_encode($deleteDetallefacturaServi);
            }
    }

}
$facturaProcess = new facturaProcess(); 