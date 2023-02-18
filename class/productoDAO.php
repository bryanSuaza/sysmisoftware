<?php

class productoDAO extends db{
   
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

     public function buscarProducto($busqueda){ 
        $data = array();       
        $sql = "SELECT h.producto_id,
                       h.nombre,
                 (CASE h.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM producto h WHERE h.nombre LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['producto_id']." NOMBRE ".$array['nombre']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando producto el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($producto_id){ 
             
        $sql = "SELECT h.producto_id,
                       h.nombre,
                       h.categoria_id,
                       h.valor_costo,
                       h.valor_venta,
                       h.estado
                 FROM producto h WHERE h.producto_id = $producto_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando producto el motivo:".$this->error);        
        } 
    } 



    public function crearProducto(productoDTO $producto){
         
        $nombre = $producto->getNombre();
        $categoria_id = $producto->getCategoria_id();
        $valor_costo = $producto->getValor_costo();
        $valor_venta =$producto->getValor_venta();
        $estado =$producto->getEstado();
     
        $producto_id = $this->getMaxId('producto','producto_id');

        $select="SELECT h.producto_id FROM producto h WHERE  h.nombre = '$nombre'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

                $sql="INSERT INTO producto (producto_id,categoria_id,nombre,valor_costo,valor_venta,estado) 
                      VALUES ($producto_id,$categoria_id,'$nombre','$valor_costo','$valor_venta','$estado')";
               
                $result=$this->query($sql);
                
                if($result>0){
                       return 1;
                }else{
                    throw new Exception("No se pudo crear el producto, el motivo: ".$this->error);
                }
        }
    }

    public function ActualizarProducto(productoDTO $producto){

        $producto_id = $producto->getProducto_id();
        $nombre = $producto->getNombre();
        $categoria_id = $producto->getCategoria_id();
        $valor_costo = $producto->getValor_costo();
        $valor_venta =$producto->getValor_venta();
        $estado =$producto->getEstado();

                $update="UPDATE producto SET categoria_id=$categoria_id,nombre='$nombre',valor_costo='$valor_costo',valor_venta='$valor_venta',estado='$estado'
                         WHERE producto_id=$producto_id";
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar el producto, el motivo: ".$this->error);
                }
        
    }


    public function eliminarProducto(productoDTO $producto){

            $producto_id = $producto->getProducto_id();

            $select="SELECT producto_id FROM producto WHERE producto_id = $producto_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM producto WHERE producto_id=$producto_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar el producto, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el producto ya que no existe, el motivo: ".$this->error);
            }
            
        }

        public function getCategoria(){  
                 
            $sql = "SELECT categoria_id, nombre FROM categoria";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }
        } 

        
    }