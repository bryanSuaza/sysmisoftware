<?php

class tipoVehiculoDAO extends db{
   
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

     public function buscartipoVehiculo($busqueda){ 
        $data = array();       
        $sql = "SELECT t.tipo_vehiculo_id,
                       t.tipo,
                 (CASE t.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM tipo_vehiculo t WHERE  tipo  LIKE '%$busqueda%'";
   
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['tipo_vehiculo_id']." TIPO: ".$array['tipo']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando tipo_vehiculo parqueadero el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($tipo_vehiculo_id){ 
             
        $sql = "SELECT t.tipo_vehiculo_id,
                       t.tipo,
                       t.estado
                
                 FROM tipo_vehiculo t WHERE t.tipo_vehiculo_id = $tipo_vehiculo_id";
            
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando tipo_vehiculo parqueadero el motivo:".$this->error);        
        } 
    } 


    public function creartipoVehiculo(tipoVehiculoDTO $tipoVehiculo){
         
            
            $tipo= $tipoVehiculo->getTipo();
            $estado = $tipoVehiculo ->getEstado();

            $select="SELECT tipo_vehiculo_id FROM tipo_vehiculo WHERE tipo = '$tipo' AND estado = 'A' ";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){
                return 2;
            }else{
                $tipo_vehiculo_id = $this->getMaxId('tipo_vehiculo','tipo_vehiculo_id');
    
                 $sql="INSERT INTO tipo_vehiculo (tipo_vehiculo_id,tipo,estado) 
                     VALUES ($tipo_vehiculo_id,'$tipo','$estado')";
                 $result=$this->query($sql);
                     
                 if($result>0){
                    return 1;
                 }else{
                    throw new Exception("No se pudo guardar el tipo_vehiculo, el motivo: ".$this->error);
                 }
            }

    }

    public function ActualizartipoVehiculo(tipoVehiculoDTO $tipoVehiculo){

            $tipo_vehiculo_id = $tipoVehiculo->getTipo_vehiculo_id();
            $tipo = $tipoVehiculo->getTipo();
            $estado = $tipoVehiculo ->getEstado();


                    $update="UPDATE tipo_vehiculo SET tipo_vehiculo_id=$tipo_vehiculo_id, tipo='$tipo',estado='$estado' 
                             WHERE tipo_vehiculo_id = $tipo_vehiculo_id";
                    $result=$this->query($update);

                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo actualizar el tipo_vehiculo, el motivo: ".$this->error);
                    }  
        
    }


    public function eliminartipoVehiculo(tipoVehiculoDTO $tipoVehiculo){

            $tipo_vehiculo_id = $tipoVehiculo->getTipo_vehiculo_id();

            $select="SELECT tipo_vehiculo_id FROM tipo_vehiculo WHERE tipo_vehiculo_id = $tipo_vehiculo_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM tipo_vehiculo WHERE tipo_vehiculo_id=$tipo_vehiculo_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar el tipo_vehiculo, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el tipo_vehiculo ya que no existe, el motivo: ".$this->error);
            }
            
        }

    }