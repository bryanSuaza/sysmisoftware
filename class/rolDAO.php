<?php

class rolDAO extends db {
    
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
    
    
    public function buscarRol($busqueda){ 
        $data = array();       
        $sql = "SELECT r.rol_id,
                       r.rol,
                 (CASE r.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM rol r WHERE r.rol LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['rol_id']." NOMBRE ROL: ".$array['rol']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando rol el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($rol_id){ 
             
        $sql = "SELECT r.rol_id,
                       r.rol,
                       r.estado
                 FROM rol r WHERE r.rol_id = $rol_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               $data[0]['roles']=$array;
            }  
           
             $sql = "SELECT p.permiso_id,
                            p.permiso
                     FROM permiso p, detalle_rol_permiso d WHERE p.permiso_id=d.permiso_id AND d.rol_id = $rol_id";
             $result_permisos = $this->query($sql);

             if(mysqli_num_rows($result_permisos)>0){ 
                 for($i=0; $array_permisos= mysqli_fetch_assoc($result_permisos); $i++){
                    $data[$i]['permisos']=$array_permisos;
                 }   
             }
             
            return $data;
            
        }else{            
            throw new Exception("Error consultando rol el motivo:".$this->error);        
        } 
    } 



    public function crearRol(rolDTO $roles){
         
        $permiso_id = $_REQUEST['permiso_id'];
        $permiso = explode(',',$permiso_id);

        $rol = $roles->getRol();
        $estado = $roles->getEstado();
     
        $rol_id = $this->getMaxId('rol','rol_id');

        $select="SELECT rol_id FROM rol WHERE rol = '$rol'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

                $sql="INSERT INTO rol (rol_id,rol,estado) VALUES ($rol_id,'$rol','$estado')";
                $result=$this->query($sql);
                
                if($result>0){

                    for($i=0; $i<count($permiso); $i++){

                        $detalle_rol_permiso_id = $this->getMaxId('detalle_rol_permiso','detalle_rol_permiso_id');
                        $sql="INSERT INTO detalle_rol_permiso (detalle_rol_permiso_id,rol_id,permiso_id) 
                            VALUES ($detalle_rol_permiso_id,$rol_id,$permiso[$i])";
                        $result=$this->query($sql);
                        
                    }  
                        if($result>0){
                            return 1;
                        }else{
                            throw new Exception("No se pudo asiganr los permisos, el motivo: ".$this->error);
                        }
                    
                }else{
                    throw new Exception("No se pudo crear el rol, el motivo: ".$this->error);
                }
        }
    }

    public function ActualizarRol(rolDTO $roles){

        $permiso_id = $_REQUEST['permiso_id'];
        $permiso = explode(',',$permiso_id);

        $rol_id = $roles->getRol_id();
        $rol = $roles->getRol();
        $estado = $roles->getEstado();

                $sql="UPDATE rol SET rol='$rol',estado='$estado' WHERE rol_id=$rol_id";
                $result=$this->query($sql);
                
                if($result>0){

                    $select="SELECT rol_id FROM detalle_rol_permiso WHERE rol_id = $rol_id";
                    $result=$this->query($select);

                    if(mysqli_num_rows($result)>0){

                        $sql="DELETE FROM detalle_rol_permiso WHERE rol_id=$rol_id";
                        $result=$this->query($sql);
                
                        if($result>0){
                          for($i=0; $i<count($permiso); $i++){

                              $detalle_rol_permiso_id = $this->getMaxId('detalle_rol_permiso','detalle_rol_permiso_id');
                              $sql="INSERT INTO detalle_rol_permiso (detalle_rol_permiso_id,rol_id,permiso_id) 
                                    VALUES ($detalle_rol_permiso_id,$rol_id,$permiso[$i])";
                              $result=$this->query($sql);
                        
                            }  
                            if($result>0){
                                return 1;
                            }else{
                                throw new Exception("No se pudo asiganar los permisos, el motivo: ".$this->error);
                            }
                        }else{
                           throw new Exception("No se pudo eliminar los permisos, el motivo: ".$this->error);
                        }
                    }else{
                        for($i=0; $i<count($permiso); $i++){

                              $detalle_rol_permiso_id = $this->getMaxId('detalle_rol_permiso','detalle_rol_permiso_id');
                              $sql="INSERT INTO detalle_rol_permiso (detalle_rol_permiso_id,rol_id,permiso_id) 
                                    VALUES ($detalle_rol_permiso_id,$rol_id,$permiso[$i])";
                              $result=$this->query($sql);
                        
                            }  
                            if($result>0){
                                return 1;
                            }else{
                                throw new Exception("No se pudo asiganar los permisos, el motivo: ".$this->error);
                            }
                    } 
                    
                }else{
                    throw new Exception("No se pudo actualizar el rol, el motivo: ".$this->error);
                }
        
    }


    public function eliminarRol(rolDTO $roles){

            $rol_id = $roles->getRol_id();

            $select="SELECT rol_id FROM detalle_rol_permiso WHERE rol_id = $rol_id";
                    $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM detalle_rol_permiso WHERE rol_id=$rol_id";
                $result=$this->query($sql);
                
                if($result>0){
                    $sql="DELETE FROM rol WHERE rol_id=$rol_id";
                    $result=$this->query($sql);
                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo eliminar el rol, el motivo: ".$this->error);
                    }
                }else{
                    throw new Exception("No se pudo eliminar los permisos, el motivo: ".$this->error);
                }

            }else{

                $sql="DELETE FROM rol WHERE rol_id=$rol_id";
                    $result=$this->query($sql);
                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo eliminar el rol, el motivo: ".$this->error);
                    }
            }
            
        }

        public function getPermisos(){  
                 
            $sql = "SELECT permiso_id, permiso FROM permiso";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los permisos el motivo:".$this->error);        
            } 
        } 


    /* public function listarSeguimiento(){
            
            $sql="SELECT * FROM rol  ORDER BY  rol_id";   
            $result=$this->query($sql);
            if($result != "NULL"){
                return $result;
            }else{
                exit("Error consultando todos los conductores el motivo:");
            }
        }

    public function listaSeguimientosPorId($rol_id){
        
        $sql=sprintf("SELECT rol_id, fecha_informe, numero_informe,fecha_inicio,fecha_final,dias_total, tiempo_transcurrido,presupuesto_total_obra,presupuesto_actualizado,costo_mano_obra  FROM rol WHERE rol_id='%d'",$rol_id); 
       
        $result=$this->query($sql); 
        
        if($result){
            if($result->num_rows>0){
                $obj=$result->fetch_object();
                return $obj;
            }else{
                return 0;
            }   
        }else{
            throw new Exception("Error consultando vehiculo el motivo".$this->error);
        }
        
    } */
    

}

    

