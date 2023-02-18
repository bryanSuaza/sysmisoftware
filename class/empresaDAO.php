<?php

class empresaDAO extends db{
   
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

     public function buscarEmpresa($busqueda){ 
        $data = array();       
        $sql = "SELECT u.empresa_id,
                       t.primer_nombre,
                       t.primer_apellido,
                       t.razon_social,
                       t.numero_identificacion,
                 (CASE u.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM empresa u,tercero t WHERE u.tercero_id = t.tercero_id  AND t.numero_identificacion LIKE '%$busqueda%'";
   
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['empresa_id']." NOMBRE: ".$array['primer_nombre']." ".$array['primer_apellido'].$array['razon_social']." NUM IDENT: ".$array['numero_identificacion']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando empresa el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($empresa_id){ 
             
        $sql = "SELECT u.empresa_id,
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
                       u.representante,
                       u.ubicacion,
                       u.direccion,
                       u.pagina,
                       u.registro_mercantil,
                       u.camara_comercio,
                       u.estado
                
                 FROM empresa u,tercero t WHERE t.tercero_id = u.tercero_id  AND u.empresa_id = $empresa_id";
            
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando empresa el motivo:".$this->error);        
        } 
    } 


    public function crearEmpresa(empresaDTO $empresa, terceroDTO $tercero){
         
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
        $representante = $empresa->getRepresentante();
        $ubicacion = $empresa->getUbicacion();
        $direccion = $empresa->getDireccion();
        $pagina = $empresa->getPagina();
        $registro_mercantil = $empresa->getRegistro_mercantil();
        $camara_comercio = $empresa->getCamara_comercio();
        $logo_empresa = $empresa->getLogo_empresa();
        $doc_registro = $empresa->getDoc_registro();
        $foto_empresa = $empresa->getFoto_empresa();
        $doc_camara = $empresa->getDoc_camara();
        $estado = $empresa->getEstado();
     
        $tercero_id = $this->getMaxId('tercero','tercero_id');

        $select="SELECT u.empresa_id FROM empresa u, tercero t WHERE t.tercero_id = u.tercero_id AND t.numero_identificacion = '$numero_identificacion'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

            /*$select="SELECT tercero_id FROM tercero WHERE numero_identificacion=$numero_identificacion";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){
              if($row = mysqli_fetch_assoc($result)){
                  $tercero_id=$row['tercero_id'];
              }

              $empresa_id = $this->getMaxId('empresa','empresa_id');

                    $sql="INSERT INTO empresa (empresa_id,representante,ubicacion,direccion,tercero_id,pagina,logo_empresa,doc_registro,foto_empresa,doc_camara,registro_mercantil,camara_comercio,estado) 
                        VALUES ($empresa_id,'$representante','$ubicacion','$direccion',$tercero_id,'$pagina','$logo_empresa','$doc_registro','$foto_empresa','$doc_camara','$registro_mercantil','$camara_comercio','$estado')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar la empresa, el motivo: ".$this->error);
                    }

            }else{}*/

                $sql="INSERT INTO tercero (tercero_id,numero_identificacion,digito_verificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social,email,telefono,tipo_persona_id) 
                      VALUES ($tercero_id,'$numero_identificacion','$digito_verificacion','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$razon_social','$email','$telefono',$tipo_persona_id)";
                $result=$this->query($sql);
                
                if($result>0){

                    $empresa_id = $this->getMaxId('empresa','empresa_id');

                     $sql="INSERT INTO empresa (empresa_id,representante,ubicacion,direccion,tercero_id,pagina,logo_empresa,doc_registro,foto_empresa,doc_camara,registro_mercantil,camara_comercio,estado) 
                        VALUES ($empresa_id,'$representante','$ubicacion','$direccion',$tercero_id,'$pagina','$logo_empresa','$doc_registro','$foto_empresa','$doc_camara','$registro_mercantil','$camara_comercio','$estado')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar la empresa, el motivo: ".$this->error);
                    }
                    
                }else{
                    throw new Exception("No se pudo crear el tercero, el motivo: ".$this->error);
                }
            
        }
    }

    public function actualizarEmpresa(empresaDTO $empresa, terceroDTO $tercero){

        $empresa_id = $empresa->getEmpresa_id();
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
        $representante = $empresa->getRepresentante();
        $ubicacion = $empresa->getUbicacion();
        $direccion = $empresa->getDireccion();
        $pagina = $empresa->getPagina();
        $logo_empresa = $empresa->getLogo_empresa();       
        $doc_registro = $empresa->getDoc_registro();
        $foto_empresa = $empresa->getFoto_empresa();
        $doc_camara = $empresa->getDoc_camara();
        $registro_mercantil = $empresa->getRegistro_mercantil();
        $camara_comercio = $empresa->getCamara_comercio();
        $estado = $empresa->getEstado();

                $update="UPDATE tercero SET numero_identificacion='$numero_identificacion',digito_verificacion='$digito_verificacion',primer_nombre='$primer_nombre',segundo_nombre='$segundo_nombre',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',razon_social='$razon_social',email='$email',telefono='$telefono',tipo_persona_id=$tipo_persona_id
                      WHERE tercero_id=(SELECT u.tercero_id FROM empresa u WHERE u.empresa_id=$empresa_id)";
                $result=$this->query($update);
                
                if($result>0){

                    $select="SELECT logo_empresa, foto_empresa, doc_registro, doc_camara FROM empresa WHERE empresa_id=$empresa_id";
                    $result=$this->query($select);

                    if(mysqli_num_rows($result)>0){

                        while($row = mysqli_fetch_assoc($result)){
                          $logo_empresa_last=$row['logo_empresa'];
                          $foto_empresa_last=$row['foto_empresa'];
                          $doc_registro_last=$row['doc_registro'];
                          $doc_camara_last=$row['doc_camara'];
                        }

                        if($logo_empresa_last!= ''){
                            if($logo_empresa == ''){
                               $logo_empresa=$logo_empresa_last;
                            }else{
                                $logo_empresa=$logo_empresa;
                            }
                        }
                        
                        if($foto_empresa_last!= ''){
                            if($foto_empresa==''){
                                $foto_empresa=$foto_empresa_last;
                            }else{
                                $foto_empresa=$foto_empresa;
                            }
                        }

                       
                        if($doc_registro_last != ''){
                            if($doc_registro==''){
                                $doc_registro=$doc_registro_last;
                            }else{
                                $doc_registro=$doc_registro;
                            }
                        }

                        if($doc_camara_last!=''){
                            if($doc_camara==''){
                                $doc_camara=$doc_camara_last;
                            }else{
                                $doc_camara=$doc_camara;
                            }
                        }

                        $update="UPDATE empresa SET representante='$representante', ubicacion='$ubicacion', direccion='$direccion', pagina='$pagina',logo_empresa='$logo_empresa',doc_registro='$doc_registro',foto_empresa='$foto_empresa',doc_camara='$doc_camara',registro_mercantil='$registro_mercantil',camara_comercio='$camara_comercio',estado='$estado' 
                                 WHERE empresa_id = $empresa_id";
                                 
                        $result=$this->query($update);

                        if($result>0){
                            return 1;
                        }else{
                            throw new Exception("No se pudo actualizar la empresa, el motivo: ".$this->error);
                        }

                    }
                }else{
                    throw new Exception("No se pudo actualizar el tercero, el motivo: ".$this->error);
                }
        
    }


    public function eliminarEmpresa(empresaDTO $empresa){

            $empresa_id = $empresa->getEmpresa_id();

            $select="SELECT empresa_id FROM empresa WHERE empresa_id = $empresa_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM empresa WHERE empresa_id=$empresa_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar la empresa, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar la empresa ya que no existe, el motivo: ".$this->error);
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


    public function traerArchivo($empresa_id){ 
             
        $sql = "SELECT e.logo_empresa,
                       e.foto_empresa,
                       e.doc_registro,
                       e.doc_camara
            
                 FROM empresa e WHERE e.empresa_id = $empresa_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{
            return 1;
        }
    } 

    function getDatosEmpresa(){

        $sql = sprintf("SELECT u.empresa_id,
                        (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id = u.tercero_id)AS razon_social,
                        u.logo_empresa
                        
                        FROM empresa u WHERE  u.estado ='A' ORDER BY u.empresa_id ASC LIMIT 1");
        $result=$this->query($sql);
        
        if($result){
            if(mysqli_num_rows($result)>0){
                    if($data = mysqli_fetch_assoc($result)){
                        return $data;
                    }
           }else{               
               return 0;
           }
        }else{
            throw new Exception("Error consultado getDatosEmpresa",$this->error);
        }
    }

    }