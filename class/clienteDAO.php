<?php

class clienteDAO extends db{
   
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

     public function buscarCliente($busqueda){ 
        $data = array();       
        $sql = "SELECT u.cliente_id,
                       t.primer_nombre,
                       t.primer_apellido,
                       t.razon_social,
                       t.numero_identificacion,
                 (CASE u.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM cliente u,tercero t WHERE u.tercero_id = t.tercero_id  AND t.numero_identificacion LIKE '%$busqueda%'";
   
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['cliente_id']." NOMBRE: ".$array['primer_nombre']." ".$array['primer_apellido'].$array['razon_social']." NUM IDENT: ".$array['numero_identificacion']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando cliente el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($cliente_id){ 
             
        $sql = "SELECT u.cliente_id,
                       t.tipo_persona_id,
                       t.numero_identificacion,
                       t.digito_verificacion,
                       t.primer_nombre,
                       t.segundo_nombre,
                       t.primer_apellido,
                       t.segundo_apellido,
                       t.razon_social,
                       t.email,
                       t.telefono,
                       u.banco,
                       u.numero_cuenta,
                       u.estado
                
                 FROM cliente u,tercero t WHERE t.tercero_id = u.tercero_id  AND u.cliente_id = $cliente_id";
            
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando cliente el motivo:".$this->error);        
        } 
    } 


    public function crearCliente(clienteDTO $cliente, terceroDTO $tercero){
         
        $numero_identificacion = $tercero->getNumero_identificacion();
        $digito_verificacion = $tercero->getDigito_verificacion();
        $primer_nombre = $tercero->getPrimer_nombre();
        $segundo_nombre =$tercero->getSegundo_nombre();
        $primer_apellido = $tercero->getPrimer_apellido();
        $segundo_apellido = $tercero->getSegundo_apellido();
        $razon_social = $tercero->getRazon_social();
        $email = $tercero->getEmail();
        $telefono = $tercero->getTelefono();
        $tipo_persona_id = $tercero->getTipo_persona_id();
        $banco = $cliente->getBanco();
        $numero_cuenta = $cliente->getNumero_cuenta();
        $usuario_id = $cliente->getUsuario_id();
        $estado = $cliente->getEstado();

        $fecha_registro = date("Y-m-d H:i:s");
     
        $tercero_id = $this->getMaxId('tercero','tercero_id');

        $select="SELECT u.cliente_id FROM cliente u, tercero t WHERE t.tercero_id = u.tercero_id AND t.numero_identificacion = '$numero_identificacion'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

            $select="SELECT tercero_id FROM tercero WHERE numero_identificacion=$numero_identificacion";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){
              if($row = mysqli_fetch_assoc($result)){
                  $tercero_id=$row['tercero_id'];
              }

              $cliente_id = $this->getMaxId('cliente','cliente_id');

                    $sql="INSERT INTO cliente (cliente_id,banco,numero_cuenta,usuario_id,tercero_id,estado,fecha_registro) 
                        VALUES ($cliente_id,'$banco','$numero_cuenta',$usuario_id,$tercero_id,'$estado','$fecha_registro')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar el cliente, el motivo: ".$this->error);
                    }

            }else{

                $sql="INSERT INTO tercero (tercero_id,numero_identificacion,digito_verificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social,email,telefono,tipo_persona_id) 
                      VALUES ($tercero_id,'$numero_identificacion','$digito_verificacion','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$razon_social','$email','$telefono',$tipo_persona_id)";
                $result=$this->query($sql);
                
                if($result>0){

                    $cliente_id = $this->getMaxId('cliente','cliente_id');

                    $sql="INSERT INTO cliente (cliente_id,banco,numero_cuenta,usuario_id,tercero_id,estado,fecha_registro) 
                        VALUES ($cliente_id,'$banco','$numero_cuenta',$usuario_id,$tercero_id,'$estado','$fecha_registro')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar el cliente, el motivo: ".$this->error);
                    }
                    
                }else{
                    throw new Exception("No se pudo crear el tercero, el motivo: ".$this->error);
                }
            }
        }
    }

    public function ActualizarCliente(clienteDTO $cliente, terceroDTO $tercero){

        $cliente_id = $cliente->getcliente_id();
        $numero_identificacion = $tercero->getNumero_identificacion();
        $digito_verificacion = $tercero->getDigito_verificacion();
        $primer_nombre = $tercero->getPrimer_nombre();
        $segundo_nombre =$tercero->getSegundo_nombre();
        $primer_apellido = $tercero->getPrimer_apellido();
        $segundo_apellido = $tercero->getSegundo_apellido();
        $razon_social = $tercero->getRazon_social();
        $email = $tercero->getEmail();
        $telefono = $tercero->getTelefono();
        $tipo_persona_id = $tercero->getTipo_persona_id();
        $banco = $cliente->getBanco();
        $numero_cuenta = $cliente->getNumero_cuenta();
        $usuario_id = $cliente->getUsuario_id();
        $estado = $cliente->getEstado();

        $fecha_actualiza = date("Y-m-d H:i:s");

                $update="UPDATE tercero SET numero_identificacion='$numero_identificacion',digito_verificacion='$digito_verificacion',primer_nombre='$primer_nombre',segundo_nombre='$segundo_nombre',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',razon_social='$razon_social',email='$email',telefono='$telefono',tipo_persona_id=$tipo_persona_id
                      WHERE tercero_id=(SELECT u.tercero_id FROM cliente u WHERE u.cliente_id=$cliente_id)";
                $result=$this->query($update);
                
                if($result>0){

                    $update="UPDATE cliente SET banco='$banco', numero_cuenta='$numero_cuenta', usuario_actualiza_id=$usuario_id, estado='$estado', fecha_actualiza='$fecha_actualiza' 
                             WHERE cliente_id = $cliente_id";
                    $result=$this->query($update);

                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo actualizar el cliente, el motivo: ".$this->error);
                    }

                }else{
                    throw new Exception("No se pudo actualizar el tercero, el motivo: ".$this->error);
                }
        
    }


    public function eliminarCliente(clienteDTO $cliente){

            $cliente_id = $cliente->getcliente_id();

            $select="SELECT cliente_id FROM cliente WHERE cliente_id = $cliente_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM cliente WHERE cliente_id=$cliente_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar el cliente, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el cliente ya que no existe, el motivo: ".$this->error);
            }
            
        }

        public function getTipo_persona(){  
                 
            $sql = "SELECT tipo_persona_id, nombre FROM tipo_persona";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los tipos de persona el motivo:".$this->error);        
            } 
        } 

        public function listarClientes(){ 
             
        $sql = "SELECT c.cliente_id,
                       (SELECT p.nombre FROM tipo_persona p, tercero t WHERE p.tipo_persona_id=t.tipo_persona_id AND t.tercero_id = c.tercero_id)AS tipo_persona,
                       (SELECT t.numero_identificacion FROM  tercero t WHERE  t.tercero_id = c.tercero_id)AS numero_identificacion,
                       (SELECT t.digito_verificacion FROM tercero t WHERE  t.tercero_id = c.tercero_id)AS digito_verificacion,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM  tercero t WHERE  t.tercero_id = c.tercero_id)AS nombre,
                       (SELECT t.email FROM tercero t WHERE  t.tercero_id = c.tercero_id)AS email,
                       (SELECT t.telefono FROM tercero t WHERE  t.tercero_id = c.tercero_id)AS telefono,
                       c.banco,
                       c.numero_cuenta,
                       (CASE c.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                
                 FROM cliente c";
                 
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
               return $result;
        }
    } 

    public function traerTercero($numero_identificacion){ 
             
        $sql = "SELECT t.tipo_persona_id,
                       t.numero_identificacion,
                       t.primer_nombre,
                       t.segundo_nombre,
                       t.primer_apellido,
                       t.segundo_apellido,
                       t.razon_social,
                       t.email,
                       t.telefono
                
                 FROM tercero t WHERE t.numero_identificacion = $numero_identificacion";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{
            return 1;
        }
    }
    
    
     public function contarClientes(){
                 
            $sql = "SELECT COUNT(*) AS clientes FROM cliente WHERE estado='A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los usuarios el motivo:".$this->error);        
            } 
    } 

    }