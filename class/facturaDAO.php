<?php

class facturaDAO extends db{
   
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

     public function buscarFactura($busqueda){ 
        $data = array();       
        $sql = "SELECT s.factura_id,
                       CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente,
                       s.fecha,
                 (CASE s.estado WHEN 'A' THEN 'ACTIVO' WHEN 'F' THEN 'FACTURADO' ELSE 'ANULADO' END)AS estado
                 FROM factura s, cliente c, tercero t WHERE s.cliente_id=c.cliente_id AND c.tercero_id = t.tercero_id AND t.numero_identificacion LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['factura_id']." CLIENTE: ".$array['cliente']." ".$array['fecha']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando factura el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($factura_id){ 
             
        $sql = "SELECT s.factura_id,
                       s.cliente_id,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS cliente,
                       (SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS numero_identificacion,
                       s.fecha,
                       s.estado,
                       s.usuario_id,
                       s.valor_total,
                       SUM(d.valor_descuento)AS descuento,
                       SUM(d.valor_iva)AS impuesto,
                       s.base
                       
                 FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id = $factura_id";
                 
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               $data[0]['factura']=$array;
            }  

            $select="SELECT d.detalle_factura_id, 
                            d.servicio_id,
                            d.producto_id, 
                            d.concepto,
                            d.cantidad, 
                            d.valor_unitario,
                            d.descuento,
                            d.iva,
                            d.subtotal 

                    FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
            $result_detalles = $this->query($select);
            
            if (mysqli_num_rows($result_detalles)>0){
                for($i=0; $array_detalles= mysqli_fetch_assoc($result_detalles); $i++){
                    $data[$i]['detalles']=$array_detalles;
                }   
            }

            return $data;
            
        }else{            
            throw new Exception("Error consultando factura el motivo:".$this->error);        
        } 
    } 



    public function crearFactura(facturaDTO $factura){
        
       
        $cliente_id = $factura->getCliente_id();
        $fecha = $factura->getFecha();
        $estado = $factura->getEstado();
        $usuario_id =$factura->getUsuario_id();

        $fecha_registro = date("Y-m-d H:i:s");
     
        $factura_id = $this->getMaxId('factura','factura_id');


                $sql="INSERT INTO factura (factura_id,cliente_id,fecha,estado,fecha_registro,usuario_id) 
                      VALUES ($factura_id,$cliente_id,'$fecha','$estado','$fecha_registro',$usuario_id)";
             
                $result=$this->query($sql);
                
                if($result>0){
                       return $factura_id;
                }else{
                    throw new Exception("No se pudo crear la factura, el motivo: ".$this->error);
                }
        
    }

    public function actualizarFactura(facturaDTO $factura){

        $factura_id = $factura->getFactura_id();
        $cliente_id = $factura->getCliente_id();
        $fecha = $factura->getFecha();
        $estado = $factura->getEstado();
        $usuario_id =$factura->getUsuario_id();

        $fecha_actualiza = date("Y-m-d H:i:s");

                $update="UPDATE factura SET cliente_id=$cliente_id,fecha='$fecha',estado='$estado',fecha_actualiza='$fecha_actualiza',usuario_actualiza_id=$usuario_id
                      WHERE factura_id=$factura_id";
                  
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar la factura, el motivo: ".$this->error);
                }
        
    }


    public function eliminarFactura(facturaDTO $factura){

            $factura_id = $factura->getFactura_id();

            $select="SELECT factura_id FROM detalle_factura WHERE factura_id = $factura_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_factura WHERE factura_id=$factura_id";
                $result=$this->query($sql);
                
                if($result>0){

                        $sql="DELETE FROM factura WHERE factura_id=$factura_id";
                        $result=$this->query($sql);
                        
                        if($result>0){

                          return 1;

                        }
                }else{
                    throw new Exception("No se pudo eliminar la factura, el motivo: ".$this->error);
                }

            }else{

                $sql="DELETE FROM factura WHERE factura_id=$factura_id";
                $result=$this->query($sql);
                        
                if($result>0){

                     return 1;

                }else{

                    throw new Exception("No se pudo eliminar la factura, el motivo: ".$this->error);
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


    public function getServicio($cliente_id){  
                 
            $sql = "SELECT s.servicio_id,
                    (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=s.cliente_id)AS cliente,
                    (SELECT CONCAT_WS(' ',s.fecha,s.hora))AS fecha,
                    (SELECT SUM(d.valor) FROM detalle_servicio d WHERE d.servicio_id = s.servicio_id)AS valor
                    FROM servicio s WHERE s.cliente_id = $cliente_id AND estado = 'A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                 for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['servicio']=$row;
                 }  
                 return $data; 
            }else{            
                throw new Exception("Error consultando servicios el motivo:".$this->error);        
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

    public function crearDetallefacturaServ(facturaDTO $factura, $servicio){
       
        $factura_id = $factura->getFactura_id();

        $select="SELECT d.*, 
                IF(d.habitacion_id>0,CONCAT_WS('-','HABITACION N°',(SELECT numero FROM habitacion WHERE habitacion_id = d.habitacion_id)),CONCAT_WS('-','PRODUCTO',(SELECT nombre FROM producto WHERE producto_id=d.producto_id)))AS conceptos
                FROM detalle_servicio d WHERE d.servicio_id IN($servicio)";
        $result=$this->query($select);

        if (mysqli_num_rows($result)>0){
            
            for($i = 0; $row = mysqli_fetch_assoc($result); $i++){				
                $data[$i] = $row;
            }
	 
	        for($i = 0; $i<count($data); $i++){

                   $detalle_factura_id = $this->getMaxId('detalle_factura','detalle_factura_id');
                   
                   $servicio_id = $data[$i]['servicio_id'];
                   $concepto = $data[$i]['conceptos'];
                   $cantidad = $data[$i]['cantidad'];
                   $valor = $data[$i]['valor'];
                   $valor_unitario = ($valor/$cantidad);
     
                   $insert="INSERT INTO detalle_factura (detalle_factura_id,factura_id,servicio_id,concepto,cantidad,valor_unitario,subtotal)
                            VALUES ($detalle_factura_id,$factura_id,$servicio_id,'$concepto','$cantidad',$valor_unitario,$valor)";
                   
                   $result=$this->query($insert);
            } 


            if($result>0){

                    $select="SELECT d.detalle_factura_id, 
                                    d.factura_id,
                                    d.servicio_id,
                                    d.producto_id,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor_unitario,
                                    d.descuento,
                                    d.iva,
                                    d.subtotal

                            FROM detalle_factura d WHERE d.factura_id = $factura_id";
                    
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                       for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['detalle_factura']=$row;
                       } 
                    }


                    $select="SELECT SUM(d.subtotal)AS total, 
                                    SUM(d.valor_unitario*d.cantidad)AS base
                        
                    FROM detalle_factura d, factura f WHERE d.factura_id=f.factura_id AND f.factura_id=$factura_id AND f.estado != 'I'";
           
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                            if($row= mysqli_fetch_assoc($result)){
                                $total =  $row['total'];
                                $base =  $row['base'];
                            } 
                    }

                    $update="UPDATE factura f SET f.base=$base, f.valor_total=$total WHERE f.factura_id = $factura_id";
                    $result=$this->query($update);


                     $select="SELECT f.valor_total AS total,
                                    f.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS iva

                            FROM detalle_factura d, factura f WHERE d.factura_id=f.factura_id AND f.factura_id=$factura_id AND f.estado != 'I'";
                    $result_detalles = $this->query($select);

                    if (mysqli_num_rows($result_detalles)>0){
                        if($row= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['desc_total']=$row;
                        }   
                    }
                   
                   return $data;

                       
                }else{
                    throw new Exception("No se pudo actualizar la factura, el motivo: ".$this->error);
                }         
        }             
    }

    public function crearDetalleFactura(facturaDTO $factura){
       
        $factura_id = $factura->getFactura_id();
        $producto_id = $factura->getProducto_id();
        $concepto = $factura->getConcepto();
        $cantidad = $factura->getCantidad();
        $valor = $factura->getValor();
     
        $detalle_factura_id = $this->getMaxId('detalle_factura','detalle_factura_id');
        $valor_unitario = ($valor/$cantidad);

        $sql="INSERT INTO detalle_factura (detalle_factura_id,factura_id,producto_id,concepto,cantidad,valor_unitario,subtotal) 
              VALUES ($detalle_factura_id,$factura_id,$producto_id,'$concepto','$cantidad','$valor_unitario','$valor')";     
        
        $result=$this->query($sql);
    
        if($result>0){

                    $select="SELECT d.detalle_factura_id, 
                                    d.factura_id,
                                    d.servicio_id,
                                    d.producto_id,
                                    (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor_unitario,
                                    d.descuento,
                                    d.iva,
                                    d.valor_descuento,
                                    d.valor_iva,
                                    d.subtotal

                            FROM detalle_factura d WHERE d.factura_id=$factura_id";
                            
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                        for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['detalle_factura']=$row;
                        } 
                    }


                    $select="SELECT SUM(d.subtotal)AS total, 
                                    SUM(d.valor_unitario*d.cantidad)AS base
                        
                    FROM detalle_factura d, factura f WHERE d.factura_id=f.factura_id AND f.factura_id=$factura_id AND f.estado != 'I'";
           
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                            if($row= mysqli_fetch_assoc($result)){
                                $total =  $row['total'];
                                $base =  $row['base'];
                            } 
                    }

                    $update="UPDATE factura f SET f.base=$base, f.valor_total=$total WHERE f.factura_id = $factura_id";
                    $result=$this->query($update);

                    $select="SELECT f.valor_total AS total,
                                    f.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS iva

                            FROM detalle_factura d, factura f WHERE d.factura_id=f.factura_id AND f.factura_id=$factura_id AND f.estado != 'I'";
                    $result_detalles = $this->query($select);

                    if (mysqli_num_rows($result_detalles)>0){
                        if($row= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['desc_total']=$row;
                        }   
                    }
                   
                   return $data;

                       
                }else{
                    throw new Exception("No se pudo agregar el producto, el motivo: ".$this->error);
                }
        
    }


    public function actualizarDetallefactura(facturaDTO $factura){

        $detalle_factura_id = $_REQUEST['detalle_factura_id'];
        $iva = $_REQUEST['iva'];
        $descuento = $_REQUEST['descuento'];
        $valor_descuento=0;
        $valor_impuesto=0;
       
        $factura_id = $factura->getFactura_id();
        $producto_id = $factura->getProducto_id();
        $concepto = $factura->getConcepto();
        $cantidad = $factura->getCantidad();
        $valor = $factura->getValor();

        $valor_unitario = ($valor/$cantidad);

        $subtotal = $valor;
        
        if($descuento>0){
           $valor_descuento=(($subtotal*$descuento)/100);
           $subtotal=$subtotal-$valor_descuento;
        }else{
            $valor_descuento=0;
        }
        
        if($iva>0){
            $valor_iva=(($subtotal*$iva)/100);
            $subtotal=$subtotal+$valor_iva;
        }else{
            $valor_iva=0;
        }

            $update="UPDATE detalle_factura SET factura_id=$factura_id,producto_id=$producto_id,concepto='$concepto',cantidad='$cantidad',valor_unitario=$valor_unitario,descuento='$descuento', iva='$iva', valor_descuento=$valor_descuento, valor_iva=$valor_iva, subtotal=$subtotal 
                    WHERE detalle_factura_id = $detalle_factura_id";
            $result=$this->query($update);     
            
            if($result>0){
                $select="SELECT d.detalle_factura_id, 
                                    d.factura_id,
                                    d.servicio_id,
                                    d.producto_id,
                                    (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor_unitario,
                                    d.descuento,
                                    d.iva,
                                    d.valor_descuento,
                                    d.valor_iva,
                                    d.subtotal

                            FROM detalle_factura d WHERE d.factura_id=$factura_id";
                            
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                        for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['detalle_factura']=$row;
                        } 
                    }
                            
                   $select="SELECT  s.valor_total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";        
                    $result = $this->query($select);

                    if (mysqli_num_rows($result)>0){
                        if($row= mysqli_fetch_assoc($result)){
                             $total = $row['valor_total'];
                             $base = $row['base'];
                            $valor_descuento = $row['descuento'];
                            $valor_impuesto = $row['impuesto'];
                        }   
                    } 
                    
                    $total = $base-$valor_descuento;
                    $total = $total+$valor_impuesto;
                    

                    $update="UPDATE factura SET valor_total=$total WHERE factura_id = $factura_id";       
                    $result=$this->query($update);


                    $select="SELECT s.valor_total AS total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($row= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['desc_total']=$row;
                        }   
                    } 
                   
                   return $data;

                       
                }else{
                    throw new Exception("No se pudo actualizar el producto, el motivo: ".$this->error);
                }
        
    }

        public function actualizarDetallefacturaServi(facturaDTO $factura){

        $detalle_factura_id = $_REQUEST['detalle_factura_id'];
        $iva = $_REQUEST['iva'];
        $descuento = $_REQUEST['descuento'];
        $valor_descuento=0;
        $valor_impuesto=0;
        
        $select="SELECT valor_unitario, cantidad FROM detalle_factura WHERE detalle_factura_id = $detalle_factura_id";
        $result=$this->query($select);

         if (mysqli_num_rows($result)>0){
            if($row= mysqli_fetch_assoc($result)){
                $valor_unitario = $row['valor_unitario'];
                $cantidad = $row['cantidad'];
            }   
         }

        $subtotal = $valor_unitario*$cantidad;
        
        if($descuento>0){
           $valor_descuento=(($subtotal*$descuento)/100);
           $subtotal=$subtotal-$valor_descuento;
        }else{
            $valor_descuento=0;
        }
        
        if($iva>0){
            $valor_iva=(($subtotal*$iva)/100);
            $subtotal=$subtotal+$valor_iva;
        }else{
            $valor_iva=0;
        }
        
        $factura_id = $factura->getfactura_id();

        $update="UPDATE detalle_factura SET factura_id=$factura_id,descuento='$descuento', iva='$iva', valor_descuento=$valor_descuento, valor_iva=$valor_iva, subtotal='$subtotal' 
                WHERE detalle_factura_id = $detalle_factura_id";       
        $result=$this->query($update);
                
                if($result>0){

                           $select="SELECT d.detalle_factura_id, 
                                    d.factura_id,
                                    d.servicio_id,
                                    d.producto_id,
                                    (SELECT CONCAT_WS(' ','PRODUCTO - ',p.nombre) FROM producto p WHERE p.producto_id=d.producto_id)AS producto,
                                    d.concepto,
                                    d.cantidad,
                                    d.valor_unitario,
                                    d.descuento,
                                    d.iva,
                                    d.subtotal
                            FROM detalle_factura d , factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
                            
                    $result=$this->query($select);

                    if (mysqli_num_rows($result)>0){
                        for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                            $data[$i]['detalle_factura']=$row;
                        }   
                    }

                   $select="SELECT  s.valor_total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";        
                    $result = $this->query($select);

                    if (mysqli_num_rows($result)>0){
                        if($row= mysqli_fetch_assoc($result)){
                             $total = $row['valor_total'];
                             $base = $row['base'];
                            $valor_descuento = $row['descuento'];
                            $valor_impuesto = $row['impuesto'];
                        }   
                    } 
                    
                    $total = $base-$valor_descuento;
                    $total = $total+$valor_impuesto;
                    

                    $update="UPDATE factura SET valor_total=$total WHERE factura_id = $factura_id";       
                    $result=$this->query($update);


                    $select="SELECT s.valor_total AS total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($row= mysqli_fetch_assoc($result_detalles)){
                            $data[0]['desc_total']=$row;
                        }   
                    } 
                   
                   return $data;
                }else{
                    throw new Exception("No se pudo actualizar el detalle de la factura, el motivo: ".$this->error);
                }
        
    }

    public function eliminarDetallefactura(facturaDTO $factura){

           $detalle_factura_id = $_REQUEST['detalle_factura_id'];
           $factura_id = $factura->getfactura_id();

            $select="SELECT factura_id FROM factura WHERE factura_id = $factura_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_factura WHERE detalle_factura_id=$detalle_factura_id";
                $result=$this->query($sql);
                
                if($result>0){

                    $select="SELECT SUM(d.subtotal)AS valor_total, 
                                    SUM(d.valor_unitario*d.cantidad)AS base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";        
                    $result = $this->query($select);

                    if (mysqli_num_rows($result)>0){
                        if($row= mysqli_fetch_assoc($result)){
                             $total = $row['valor_total'];
                             $base = $row['base'];
                            $valor_descuento = $row['descuento'];
                            $valor_impuesto = $row['impuesto'];
                        }   
                    } 
                    
                    $total = $base-$valor_descuento;
                    $total = $total+$valor_impuesto;
                    

                    $update="UPDATE factura SET valor_total=$total, base=$base WHERE factura_id = $factura_id";       
                    $result=$this->query($update);


                    $select="SELECT s.valor_total AS total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
                    $result_detalles = $this->query($select);
                    if (mysqli_num_rows($result_detalles)>0){
                        if($row= mysqli_fetch_assoc($result_detalles)){
                            $data['desc_total']=$row;
                        }   
                    } 
                   
                    return $data;
                }else{
                    throw new Exception("No se pudo eliminar el detalle, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el detalle ya que no existe el factura, el motivo: ".$this->error);
            }
            
        }

        public function eliminarDetallefacturaServi(facturaDTO $factura){

           $detalle_factura_id = $_REQUEST['detalle_factura_id'];
           $factura_id = $factura->getfactura_id();

            $select="SELECT factura_id FROM factura WHERE factura_id = $factura_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_factura WHERE detalle_factura_id IN($detalle_factura_id)";
                $result=$this->query($sql);
                
                if($result>0){

                    $select="SELECT SUM(d.valor_unitario*d.cantidad)AS base,
                                    SUM(d.subtotal) AS valor_total
                             FROM detalle_factura d WHERE d.factura_id = $factura_id";
            
                    $result = $this->query($select);

                    if (mysqli_num_rows($result)>0){
                        if($row= mysqli_fetch_assoc($result)){
                            $valor_total = $row['valor_total'];
                            $base = $row['base'];

                            if(!$valor_total>0){
                                $valor_total=0;
                            }

                            if(!$base>0){
                                $base=0;
                            }
                        }   
                    }

                    $update="UPDATE factura SET base=$base, valor_total=$valor_total WHERE factura_id=$factura_id";
                    $result = $this->query($update);

                    $select="SELECT s.valor_total AS total,
                                    s.base,
                                    SUM(d.valor_descuento)AS descuento,
                                    SUM(d.valor_iva)AS impuesto
                             FROM detalle_factura d, factura s WHERE d.factura_id = s.factura_id AND s.factura_id=$factura_id";
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
                    throw new Exception("No se pudo eliminar el detalle ya que no existe el factura, el motivo: ".$this->error);
            }
            
        }

        public function listarfacturas(){
                    $sql = "SELECT s.factura_id,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS cliente,
                       (SELECT t.numero_identificacion FROM tercero t, cliente c WHERE t.tercero_id = c.tercero_id AND c.cliente_id=s.cliente_id)AS numero_identificacion,
                       s.fecha,
                       s.hora,
                        (CASE s.estado WHEN 'A' THEN 'ACTIVO' ELSE 'ANULADO' END)AS estado,
                       (SELECT GROUP_CONCAT(DISTINCT h.numero ORDER BY h.numero ASC SEPARATOR ' - ')
                        FROM habitacion h,detalle_factura d WHERE h.habitacion_id = d.habitacion_id AND d.factura_id = s.factura_id GROUP BY s.factura_id)AS habitacion,
                        (SELECT GROUP_CONCAT(DISTINCT p.nombre ORDER BY p.nombre ASC SEPARATOR ', ')
                        FROM producto p,detalle_factura d WHERE p.producto_id = d.producto_id AND d.factura_id = s.factura_id GROUP BY s.factura_id)AS producto,
                       (SELECT d.concepto FROM detalle_factura d WHERE d.factura_id = s.factura_id GROUP BY s.factura_id)AS concepto,
                       (SELECT d.cantidad FROM detalle_factura d WHERE  d.factura_id = s.factura_id GROUP BY s.factura_id)AS cantidad,
                       (SELECT SUM(d.valor) FROM detalle_factura d WHERE d.factura_id = s.factura_id)AS valor
                 FROM factura s";
                 
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
           
              return $result;
             
        }
    }
}