<?php
	
require("../class/db.class.php");
require("../class/servicioDTO.php");
require("../class/servicioDAO.php");

class servicioProcess {

    function __construct() {
       $funcion = $_REQUEST['FUNCION'];
       $this -> $funcion();
    }

    public function serch(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchServicio = $servicioDAO->buscarServicio($busqueda);

            if($serchServicio!= ''){
               echo json_encode($serchServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDate(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $servicio_id =filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);
            
            $getServicio = $servicioDAO->traerDatos($servicio_id);
            
            if($getServicio>0){
               echo json_encode($getServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function save(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();
       
            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            $fecha =filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $hora =filter_input(INPUT_POST, "hora", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);
            
            $servicioDTO->setCliente_id($cliente_id);
            $servicioDTO->setFecha($fecha);
            $servicioDTO->setHora($hora);
            $servicioDTO->setEstado($estado);
            $servicioDTO->setUsuario_id($usuario_id);
            
            $saveServicio = $servicioDAO->crearServicio($servicioDTO);

            if($saveServicio>0){
               echo json_encode($saveServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function update(){

       try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $servicio_id =filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);
            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            $fecha =filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
            $hora =filter_input(INPUT_POST, "hora", FILTER_SANITIZE_STRING);
            $estado =filter_input(INPUT_POST, "estado", FILTER_SANITIZE_STRING);
            $usuario_id =filter_input(INPUT_POST, "usuario_id", FILTER_SANITIZE_STRING);

            $servicioDTO->setServicio_id($servicio_id);
            $servicioDTO->setCliente_id($cliente_id);
            $servicioDTO->setFecha($fecha);
            $servicioDTO->setHora($hora);
            $servicioDTO->setEstado($estado);
            $servicioDTO->setUsuario_id($usuario_id);

            $updateServicio= $servicioDAO->actualizarServicio($servicioDTO);

            if($updateServicio>0){
               echo json_encode($updateServicio);
            }
      }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}
    }

    public function delete(){

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $servicio_id=filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);
	       
            $servicioDTO->setServicio_id($servicio_id);
            
            $deleteServicio = $servicioDAO->eliminarServicio($servicioDTO);

            if($deleteServicio>0){
               echo json_encode($deleteServicio);
            }
    }

    public function serchCliente(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $busqueda =filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);
            
            $serchCliente = $servicioDAO->buscarCliente($busqueda);

            if($serchCliente!= ''){
               echo json_encode($serchCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getDateCliente(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $cliente_id =filter_input(INPUT_POST, "cliente_id", FILTER_SANITIZE_STRING);
            
            $getCliente = $servicioDAO->traerDatosCliente($cliente_id);
            
            if($getCliente>0){
               echo json_encode($getCliente);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getValorHabitacion(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $habitacion_id =filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
            
            $getValor = $servicioDAO->traerValorHabitacion($habitacion_id);
            
            if($getValor>0){
               echo json_encode($getValor);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function getValorProducto(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            
            $getValor = $servicioDAO->traerValorProducto($producto_id);
            
            if($getValor>0){
               echo json_encode($getValor);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function saveDetalle(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $servicio_id =filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);
            $habitacion_id =filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            $concepto =filter_input(INPUT_POST, "concepto", FILTER_SANITIZE_STRING);
            $cantidad =filter_input(INPUT_POST, "cantidad", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
            
            $servicioDTO->setServicio_id($servicio_id);
            $servicioDTO->setHabitacion_id($habitacion_id);
            $servicioDTO->setProducto_id($producto_id);
            $servicioDTO->setConcepto($concepto);
            $servicioDTO->setCantidad($cantidad);
            $servicioDTO->setValor($valor);
            
            $saveDetalleServicio = $servicioDAO->crearDetalleServicio($servicioDTO);

            if($saveDetalleServicio>0){
               echo json_encode($saveDetalleServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

      public function updateDetalle(){

	    try{

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $servicio_id =filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);
            $detalle_servicio_id =filter_input(INPUT_POST, "detalle_servicio_id", FILTER_SANITIZE_STRING);
            $habitacion_id =filter_input(INPUT_POST, "habitacion_id", FILTER_SANITIZE_STRING);
            $producto_id =filter_input(INPUT_POST, "producto_id", FILTER_SANITIZE_STRING);
            $concepto =filter_input(INPUT_POST, "concepto", FILTER_SANITIZE_STRING);
            $cantidad =filter_input(INPUT_POST, "cantidad", FILTER_SANITIZE_STRING);
            $valor =filter_input(INPUT_POST, "valor", FILTER_SANITIZE_STRING);
            
            $servicioDTO->setServicio_id($servicio_id);
            $servicioDTO->setHabitacion_id($habitacion_id);
            $servicioDTO->setProducto_id($producto_id);
            $servicioDTO->setConcepto($concepto);
            $servicioDTO->setCantidad($cantidad);
            $servicioDTO->setValor($valor);
            
            $updateDetalleServicio = $servicioDAO->actualizarDetalleServicio($servicioDTO);

            if($updateDetalleServicio>0){
               echo json_encode($updateDetalleServicio);
            }

        }catch(Exception $ex){
			echo "Ha sucedido el siguiente error: ".$ex->getMessage();
		}

    }

    public function deleteDetalle(){

            $servicioDTO = new servicioDTO();
            $servicioDAO = new servicioDAO();

            $detalle_servicio_id=filter_input(INPUT_POST, "detalle_servicio_id", FILTER_SANITIZE_STRING);
            $servicio_id=filter_input(INPUT_POST, "servicio_id", FILTER_SANITIZE_STRING);

            $servicioDTO->setServicio_id($servicio_id);

            $deleteDetalleServicio = $servicioDAO->eliminarDetalleServicio($servicioDTO);

            if($deleteDetalleServicio>0){
               echo json_encode($deleteDetalleServicio);
            }
    }

}
$servicioProcess = new servicioProcess(); 