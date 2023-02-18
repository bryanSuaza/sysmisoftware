<?php

class servicioDAO extends db{
   
    function __construct() {
        parent::__construct();
    }

    public function getMaxId($Table,$Column){
    
    $increment = 1;
    
	  $select = "SELECT MAX($Column) AS max_consecutive FROM $Table";
      $Max    = $this -> query($select);	  
      if(mysqli_num_rows($Max)>0){
          if($row = mysqli_fetch_assoc($Max)){
             $max_consecutive =  $row['max_consecutive'];
          }
      }else{
          $max_consecutive = 0;
      }
	  
      return $max_consecutive += $increment;
	  	  
	}

     public function buscarServicio($busqueda){ 
        $data = array();       
        $sql = "SELECT s.servicio_id,
                       CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente,
                       s.fecha,
                 (CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'F' THEN 'FACTURADO' ELSE 'ANULADO' END)AS estado
                 FROM servicio s, cliente c, tercero t WHERE s.cliente_id=c.cliente_id AND c.tercero_id = t.tercero_id AND t.numero_identificacion LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['servicio_id']." CLIENTE: ".$array['cliente']." ".$array['fecha']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando servicio el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($servicio_id){ 
             
        $sql = "SELECT s.servicio_id,
                       s.cliente_id,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS cliente,
                       (SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS numero_identificacion,
                       s.fecha,
                       s.hora,
                       s.estado,
                       s.usuario_id,
                       (SELECT SUM(d.valor) FROM detalle_servicio d WHERE d.servicio_id = s.servicio_id)AS valor_total
                 FROM servicio s WHERE s.servicio_id = $servicio_id";
                 
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               $data[0]['servicio']=$array;
            }  

            $select="SELECT d.detalle_servicio_id, 
                            d.habitacion_id,
                            (SELECT CONCAT_WS(' ','HABITACION - ',h.numero) FROM habitacion h WHERE h.habitacion_id=d.habitacion_id)AS habitacion, 
                            d.producto_id, 
                            (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                            d.concepto,
                            d.cantidad, 
                            d.valor 
                    FROM detalle_servicio d, servicio s WHERE d.servicio_id = s.servicio_id AND s.servicio_id=$servicio_id";
            $result_detalles = $this->query($select);
            if (mysqli_num_rows($result_detalles)>0){
                for($i=0; $array_detalles= mysqli_fetch_assoc($result_detalles); $i++){
                    $data[$i]['detalles']=$array_detalles;
                }   
            }

            return $data;
            
        }else{            
            throw new Exception("Error consultando servicio el motivo:".$this->error);        
        } 
    } 



    public function crearServicio(servicioDTO $servicio){
        
       
        $cliente_id = $servicio->getCliente_id();
        $fecha = $servicio->getFecha();
        $hora = $servicio->getHora();
        $estado = $servicio->getEstado();
        $usuario_id =$servicio->getUsuario_id();

        $fecha_registro = date("Y-m-d H:i:s");
     
        $servicio_id = $this->getMaxId('servicio','servicio_id');


                $sql="INSERT INTO servicio (servicio_id,cliente_id,fecha,hora,estado,fecha_registro,usuario_id) 
                      VALUES ($servicio_id,$cliente_id,'$fecha','$hora','$estado','$fecha_registro',$usuario_id)";
              
                $result=$this->query($sql);
                
                if($result>0){
                       return $servicio_id;
                }else{
                    throw new Exception("No se pudo crear el servicio, el motivo: ".$this->error);
                }
        
    }

    public function actualizarServicio(servicioDTO $servicio){

        $servicio_id = $servicio->getServicio_id();
        $cliente_id = $servicio->getCliente_id();
        $fecha = $servicio->getFecha();
        $hora = $servicio->getHora();
        $estado = $servicio->getEstado();
        $usuario_id =$servicio->getUsuario_id();

        $fecha_actualiza = date("Y-m-d H:i:s");

                $update="UPDATE servicio SET cliente_id=$cliente_id,fecha='$fecha',hora='$hora',estado='$estado',fecha_actualiza='$fecha_actualiza',usuario_actualiza_id=$usuario_id
                      WHERE servicio_id=$servicio_id";
                  
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar el servicio, el motivo: ".$this->error);
                }
        
    }


    public function eliminarServicio(servicioDTO $servicio){

            $servicio_id = $servicio->getServicio_id();

            $select="SELECT servicio_id FROM detalle_servicio WHERE servicio_id = $servicio_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_servicio WHERE servicio_id=$servicio_id";
                $result=$this->query($sql);
                
                if($result>0){

                        $sql="DELETE FROM servicio WHERE servicio_id=$servicio_id";
                        $result=$this->query($sql);
                        
                        if($result>0){

                          return 1;

                        }
                }else{
                    throw new Exception("No se pudo eliminar la servicio, el motivo: ".$this->error);
                }

            }else{

                $sql="DELETE FROM servicio WHERE servicio_id=$servicio_id";
                $result=$this->query($sql);
                        
                if($result>0){

                     return 1;

                }else{

                    throw new Exception("No se pudo eliminar el servicio, el motivo: ".$this->error);
                }
                
            }
            
        }

        public function buscarCliente($busqueda){ 
        $data = array();       
        $sql = "SELECT c.cliente_id,
                       CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente
                 FROM  cliente c, tercero t WHERE c.estado = 'A' AND  c.tercero_id = t.tercero_id AND t.numero_identificacion LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['cliente_id']." CLIENTE: ".$array['cliente']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando cliente el motivo:".$this->error);        
        } 
    } 


     public function traerDatosCliente($cliente_id){ 
             
        $sql = "SELECT cliente_id,
                (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = c.tercero_id)AS numero_identificacion
                FROM  cliente c WHERE c.cliente_id = $cliente_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando datos cliente el motivo:".$this->error);        
        } 
    } 

    public function traerValorHabitacion($habitacion_id){ 
             
        $sql = "SELECT valor FROM habitacion WHERE habitacion_id = $habitacion_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando datos habitacion el motivo:".$this->error);        
        } 
    } 


    public function getHabitaciones(){  
                 
            $sql = "SELECT habitacion_id, numero, descripcion FROM habitacion WHERE estado = 'D'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }
    } 

    public function traerValorProducto($producto_id){ 
             
        $sql = "SELECT valor_venta FROM producto WHERE producto_id = $producto_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando datos producto el motivo:".$this->error);        
        } 
    } 

    public function getProductos(){  
                 
            $sql = "SELECT producto_id, nombre FROM producto WHERE estado = 'A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }
    } 

    public function crearDetalleServicio(servicioDTO $servicio){
       
        $servicio_id = $servicio->getServicio_id();
        $habitacion_id = $servicio->getHabitacion_id();
        $producto_id = $servicio->getProducto_id();
        $concepto = $servicio->getConcepto();
        $cantidad = $servicio->getCantidad();
        $valor = $servicio->getValor();
     
        $detalle_servicio_id = $this->getMaxId('detalle_servicio','detalle_servicio_id');

        if($habitacion_id>0){
             $sql="INSERT INTO detalle_servicio (detalle_servicio_id,servicio_id,habitacion_id,concepto,cantidad,valor) 
                      VALUES ($detalle_servicio_id,$servicio_id,$habitacion_id,'$concepto','$cantidad','$valor')";
        }else if($producto_id>0){
             $sql="INSERT INTO detalle_servicio (detalle_servicio_id,servicio_id,producto_id,concepto,cantidad,valor) 
                      VALUES ($detalle_servicio_id,$servicio_id,$producto_id,'$concepto','$cantidad','$valor')";     
        }
        $result=$this->query($sql);
                
                
                if($result>0){

                    $select="SELECT d.detalle_servicio_id, 
                                    d.servicio_id,
                                    d.habitacion_id,
                                    (SELECT CONCAT_WS(' ','HABITACION - ',h.numero) FROM habitacion h WHERE h.habitacion_id=d.habitacion_id)AS habitacion,
                                    d.producto_id,
                                    (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor
                            FROM detalle_servicio d WHERE detalle_servicio_id = $detalle_servicio_id";
                            
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                        if($row= mysqli_fetch_assoc($result)){
                            $data[0]['detalle_servicio']=$row;
                        }   
                    }


                    $select="SELECT SUM(d.valor) AS total
                             FROM detalle_servicio d, servicio s WHERE d.servicio_id = s.servicio_id AND s.servicio_id=$servicio_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($total= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['total']=$total;
                        }   
                    }
                   
                   return $data;

                       
                }else{
                    throw new Exception("No se pudo crear el detalle del servicio, el motivo: ".$this->error);
                }
        
    }

    public function actualizarDetalleServicio(servicioDTO $servicio){

        $detalle_servicio_id = $_REQUEST['detalle_servicio_id'];
       
        $servicio_id = $servicio->getServicio_id();
        $habitacion_id = $servicio->getHabitacion_id();
        $producto_id = $servicio->getProducto_id();
        $concepto = $servicio->getConcepto();
        $cantidad = $servicio->getCantidad();
        $valor = $servicio->getValor();

        if($habitacion_id>0){
            $update="UPDATE detalle_servicio SET servicio_id=$servicio_id,habitacion_id=$habitacion_id,concepto='$concepto',cantidad='$cantidad',valor='$valor' 
                    WHERE detalle_servicio_id = $detalle_servicio_id";
        }else if($producto_id>0){
            $update="UPDATE detalle_servicio SET servicio_id=$servicio_id,producto_id=$producto_id,concepto='$concepto',cantidad='$cantidad',valor='$valor' 
                    WHERE detalle_servicio_id = $detalle_servicio_id";
        }     
        $result=$this->query($update);
                
                if($result>0){
                           $select="SELECT d.detalle_servicio_id, 
                                    d.servicio_id,
                                    d.habitacion_id,
                                    (SELECT CONCAT_WS(' ','HABITACION - ',h.numero) FROM habitacion h WHERE h.habitacion_id=d.habitacion_id)AS habitacion,
                                    d.producto_id,
                                    (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor
                            FROM detalle_servicio d , servicio s WHERE d.servicio_id = s.servicio_id AND s.servicio_id=$servicio_id";
                            
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                        for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['detalle_servicio']=$row;
                        }   
                    }


                    $select="SELECT SUM(d.valor) AS total
                             FROM detalle_servicio d, servicio s WHERE d.servicio_id = s.servicio_id AND s.servicio_id=$servicio_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($total= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['total']=$total;
                        }   
                    }
                   
                   return $data;
                }else{
                    throw new Exception("No se pudo actualizar el detalle del servicio, el motivo: ".$this->error);
                }
        
    }

    public function eliminarDetalleServicio(servicioDTO $servicio){

           $detalle_servicio_id = $_REQUEST['detalle_servicio_id'];
           $servicio_id = $servicio->getServicio_id();

            $select="SELECT servicio_id FROM servicio WHERE servicio_id = $servicio_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_servicio WHERE detalle_servicio_id=$detalle_servicio_id";
                $result=$this->query($sql);
                
                if($result>0){

                    $select="SELECT SUM(d.valor) AS total
                             FROM detalle_servicio d, servicio s WHERE d.servicio_id = s.servicio_id AND s.servicio_id=$servicio_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($data= mysqli_fetch_assoc($result_detalles)){
                           return $data;
                        }   
                    }

                }else{
                    throw new Exception("No se pudo eliminar el detalle, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el detalle ya que no existe el servicio, el motivo: ".$this->error);
            }
            
        }

        public function listarServicios(){
                    $sql = "SELECT s.servicio_id,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS cliente,
                       (SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS numero_identificacion,
                       s.fecha,
                       s.hora,
                        (CASE s.estado WHEN 'A' THEN 'ACTIVO' ELSE 'ANULADO' END)AS estado,
                       (SELECT GROUP_CONCAT(DISTINCT h.numero ORDER BY h.numero ASC SEPARATOR ' - ')
                        FROM habitacion h,detalle_servicio d WHERE h.habitacion_id = d.habitacion_id AND d.servicio_id = s.servicio_id GROUP BY s.servicio_id)AS habitacion,
                        (SELECT GROUP_CONCAT(DISTINCT p.nombre ORDER BY p.nombre ASC SEPARATOR ', ')
                        FROM producto p,detalle_servicio d WHERE p.producto_id = d.producto_id AND d.servicio_id = s.servicio_id GROUP BY s.servicio_id)AS producto,
                       (SELECT d.concepto FROM detalle_servicio d WHERE d.servicio_id = s.servicio_id GROUP BY s.servicio_id)AS concepto,
                       (SELECT d.cantidad FROM detalle_servicio d WHERE  d.servicio_id = s.servicio_id GROUP BY s.servicio_id)AS cantidad,
                       (SELECT SUM(d.valor) FROM detalle_servicio d WHERE d.servicio_id = s.servicio_id)AS valor
                 FROM servicio s";
                 
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
           
              return $result;
             
        }
    }

         public function contarServicios(){
                 
            $sql = "SELECT COUNT(*) AS servicios FROM servicio WHERE estado='A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los usuarios el motivo:".$this->error);        
            } 
    } 
}