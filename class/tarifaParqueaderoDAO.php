<?php

class tarifaParqueaderoDAO extends db{
   
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

     public function buscarTarifaParqueadero($busqueda){ 
        $data = array();       
        $sql = "SELECT t.tarifas_parqueadero_id,
                       t.tipo_vehiculo_id,
                       (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=t.tipo_vehiculo_id)AS tipo_vehiculo,
                       t.valor_hora_diurna,
                       t.valor_hora_nocturna,
                       t.valor_dia,
                       t.valor_medio_dia,
                       t.valor_mes,
                       t.tiempo_cobro,
                 (CASE t.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM tarifas_parqueadero t WHERE (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=t.tipo_vehiculo_id) LIKE '%$busqueda%'";
   
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['tarifas_parqueadero_id']." TIPO: ".$array['tipo_vehiculo']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando tarifa parqueadero el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($tarifas_parqueadero_id){ 
             
        $sql = "SELECT t.tarifas_parqueadero_id,
                       t.tipo_vehiculo_id,
                       (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=t.tipo_vehiculo_id)AS tipo_vehiculo,
                       t.valor_hora_diurna,
                       t.valor_hora_nocturna,
                       t.valor_dia,
                       t.valor_medio_dia,
                       t.valor_mes,
                       t.tiempo_cobro,
                       t.estado
                
                 FROM tarifas_parqueadero t WHERE t.tarifas_parqueadero_id = $tarifas_parqueadero_id";
            
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando tarifa parqueadero el motivo:".$this->error);        
        } 
    } 


    public function crearTarifaParqueadero(tarifaParqueaderoDTO $tarifaParqueadero){
         
            
            $tipo_vehiculo_id = $tarifaParqueadero->getTipo_vehiculo_id();
            $valor_hora_diurna= $tarifaParqueadero->getValor_hora_diurna();
            $valor_hora_nocturna = $tarifaParqueadero ->getValor_hora_nocturna();
            $valor_dia = $tarifaParqueadero ->getValor_dia();
            $valor_medio_dia = $tarifaParqueadero ->getValor_medio_dia();
            $valor_mes = $tarifaParqueadero ->getValor_mes();
            $tiempo_cobro = $tarifaParqueadero ->getTiempo_cobro();
            $estado = $tarifaParqueadero ->getEstado();

            $select="SELECT tarifas_parqueadero_id FROM tarifas_parqueadero WHERE tipo_vehiculo_id = $tipo_vehiculo_id AND estado = 'A' ";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){
                return 2;
            }else{
                $tarifas_parqueadero_id = $this->getMaxId('tarifas_parqueadero','tarifas_parqueadero_id');
    
                 $sql="INSERT INTO tarifas_parqueadero (tarifas_parqueadero_id,tipo_vehiculo_id,valor_hora_diurna,valor_hora_nocturna,valor_medio_dia,valor_dia,valor_mes,tiempo_cobro,estado) 
                     VALUES ($tarifas_parqueadero_id,$tipo_vehiculo_id,'$valor_hora_diurna','$valor_hora_nocturna','$valor_medio_dia','$valor_dia','$valor_mes',$tiempo_cobro,'$estado')";
                 $result=$this->query($sql);
                     
                 if($result>0){
                    return 1;
                 }else{
                    throw new Exception("No se pudo guardar la tarifa, el motivo: ".$this->error);
                 }
            }

    }

    public function ActualizartarifaParqueadero(tarifaParqueaderoDTO $tarifaParqueadero){

            $tarifas_parqueadero_id = $tarifaParqueadero->getTarifas_parqueadero_id();
            $tipo_vehiculo_id = $tarifaParqueadero->getTipo_vehiculo_id();
            $valor_hora_diurna= $tarifaParqueadero->getValor_hora_diurna();
            $valor_hora_nocturna = $tarifaParqueadero ->getValor_hora_nocturna();
            $valor_medio_dia = $tarifaParqueadero ->getValor_medio_dia();
            $valor_dia = $tarifaParqueadero ->getValor_dia();
            $valor_mes = $tarifaParqueadero ->getValor_mes();
            $tiempo_cobro = $tarifaParqueadero ->getTiempo_cobro();
            $estado = $tarifaParqueadero ->getEstado();


                    $update="UPDATE tarifas_parqueadero SET tipo_vehiculo_id=$tipo_vehiculo_id, valor_hora_diurna='$valor_hora_diurna', valor_hora_nocturna='$valor_hora_nocturna', valor_medio_dia='$valor_medio_dia', valor_dia='$valor_dia', valor_mes='$valor_mes',tiempo_cobro=$tiempo_cobro,estado='$estado' 
                             WHERE tarifas_parqueadero_id = $tarifas_parqueadero_id";
                    $result=$this->query($update);

                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo actualizar la tarifa, el motivo: ".$this->error);
                    }  
        
    }


    public function eliminartarifaParqueadero(tarifaParqueaderoDTO $tarifaParqueadero){

            $tarifas_parqueadero_id = $tarifaParqueadero->getTarifas_parqueadero_id();

            $select="SELECT tarifas_parqueadero_id FROM tarifas_parqueadero WHERE tarifas_parqueadero_id = $tarifas_parqueadero_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM tarifas_parqueadero WHERE tarifas_parqueadero_id=$tarifas_parqueadero_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar la tarifa, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar la tarifa ya que no existe, el motivo: ".$this->error);
            }
            
        }

    }