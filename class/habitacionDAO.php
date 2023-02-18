<?php

class habitacionDAO extends db{
   
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

     public function buscarHabitacion($busqueda){ 
        $data = array();       
        $sql = "SELECT h.habitacion_id,
                       h.numero,
                       h.descripcion,
                 (CASE h.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM habitacion h WHERE h.numero LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['habitacion_id']." NUMERO: ".$array['numero']." ".$array['descripcion']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando habitacion el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($habitacion_id){ 
             
        $sql = "SELECT h.habitacion_id,
                       h.valor,
                       h.tipo_habitacion_id,
                       h.numero,
                       h.descripcion,
                       h.imagen,
                       h.estado
                 FROM habitacion h WHERE h.habitacion_id = $habitacion_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando habitacion el motivo:".$this->error);        
        } 
    } 



    public function crearHabitacion(habitacionDTO $habitacion){
         
        $numero = $habitacion->getNumero();
        $valor = $habitacion->getValor();
        $descripcion = $habitacion->getDescripcion();
        $estado =$habitacion->getEstado();
        $tipo_habitacion_id = $habitacion->getTipo_habitacion_id();
        $imagen = $habitacion->getImagen();
        $usuario_id = $habitacion->getUsuario_id();

        $fecha_registra = date("Y-m-d H:i:s");
     
        $habitacion_id = $this->getMaxId('habitacion','habitacion_id');

        $select="SELECT h.habitacion_id FROM habitacion h WHERE  h.numero = '$numero'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

                $sql="INSERT INTO habitacion (habitacion_id,numero,valor,descripcion,estado,tipo_habitacion_id,imagen,fecha_registra,usuario_id) 
                      VALUES ($habitacion_id,'$numero',$valor,'$descripcion','$estado',$tipo_habitacion_id,'$imagen','$fecha_registra',$usuario_id)";
                
                $result=$this->query($sql);
                
                if($result>0){
                       return 1;
                }else{
                    throw new Exception("No se pudo crear la habitacion, el motivo: ".$this->error);
                }
        }
    }

    public function ActualizarHabitacion(habitacionDTO $habitacion){

        $habitacion_id = $habitacion->gethabitacion_id();
        $numero = $habitacion->getNumero();
        $valor = $habitacion->getValor();
        $descripcion = $habitacion->getDescripcion();
        $estado =$habitacion->getEstado();
        $tipo_habitacion_id = $habitacion->getTipo_habitacion_id();
        $imagen = $habitacion->getImagen();
        $usuario_id = $habitacion->getUsuario_id();

        $fecha_actualiza = date("Y-m-d H:i:s");

                $update="UPDATE habitacion SET numero='$numero',valor=$valor,descripcion='$descripcion',estado='$estado',tipo_habitacion_id=$tipo_habitacion_id,imagen='$imagen',fecha_actualiza='$fecha_actualiza',usuario_actualiza_id=$usuario_id
                      WHERE habitacion_id=$habitacion_id";
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar la habitacion, el motivo: ".$this->error);
                }
        
    }


    public function eliminarHabitacion(habitacionDTO $habitacion){

            $habitacion_id = $habitacion->gethabitacion_id();

            $select="SELECT habitacion_id FROM habitacion WHERE habitacion_id = $habitacion_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM habitacion WHERE habitacion_id=$habitacion_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar la habitacion, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar la habitacion ya que no existe, el motivo: ".$this->error);
            }
            
        }

        public function getTipo_habitacion(){  
                 
            $sql = "SELECT tipo_habitacion_id, tipo FROM tipo_habitacion";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los tipo de habitacion el motivo:".$this->error);        
            } 
        } 

        
    }