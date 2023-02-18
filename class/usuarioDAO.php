<?php

class usuarioDAO extends db{
   
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

     public function buscarUsuario($busqueda){ 
        $data = array();       
        $sql = "SELECT u.usuario_id,
                       t.primer_nombre,
                       t.primer_apellido,
                       t.numero_identificacion,
                 (CASE u.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                 FROM usuario u,tercero t WHERE t.tercero_id = u.tercero_id AND t.numero_identificacion LIKE '%$busqueda%'";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
            while($array = mysqli_fetch_assoc($result)){
                array_push($data, $array['usuario_id']." NOMBRE: ".$array['primer_nombre']." ".$array['primer_apellido']." NUM IDENT: ".$array['numero_identificacion']." ESTADO: ".$array['estado']);           
            } 
            return $data;
        }else{            
            throw new Exception("Error consultando usuario el motivo:".$this->error);        
        } 
    } 


     public function traerDatos($usuario_id){ 
             
        $sql = "SELECT u.usuario_id,
                       t.tipo_persona_id,
                       t.numero_identificacion,
                       t.primer_nombre,
                       t.segundo_nombre,
                       t.primer_apellido,
                       t.segundo_apellido,
                       t.email,
                       t.telefono,
                       u.rol_id,
                       u.username,
                       u.password,
                       u.estado
                
                 FROM usuario u,tercero t WHERE t.tercero_id = u.tercero_id AND u.usuario_id = $usuario_id";
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 

            if($array= mysqli_fetch_assoc($result)){
               return $array;
            }  
            
        }else{            
            throw new Exception("Error consultando usuario el motivo:".$this->error);        
        } 
    } 



    public function crearUsuario(usuarioDTO $usuario, terceroDTO $tercero){
         
        $numero_identificacion = $tercero->getNumero_identificacion();
        $primer_nombre = $tercero->getPrimer_nombre();
        $segundo_nombre =$tercero->getSegundo_nombre();
        $primer_apellido = $tercero->getPrimer_apellido();
        $segundo_apellido = $tercero->getSegundo_apellido();
        $email = $tercero->getEmail();
        $telefono = $tercero->getTelefono();
        $tipo_persona_id = $tercero->getTipo_persona_id();
        $username = $usuario->getUsername();
        $password = $usuario->getPassword();
        $rol_id = $usuario->getRol_id();
        $estado = $usuario->getEstado();
     
        $tercero_id = $this->getMaxId('tercero','tercero_id');

        $select="SELECT u.usuario_id FROM usuario u, tercero t WHERE t.tercero_id = u.tercero_id AND t.numero_identificacion = '$numero_identificacion'";
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

              $usuario_id = $this->getMaxId('usuario','usuario_id');

                    $sql="INSERT INTO usuario (usuario_id,username,password,rol_id,tercero_id,estado) 
                        VALUES ($usuario_id,'$username','$password',$rol_id,$tercero_id,'$estado')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar el usuario, el motivo: ".$this->error);
                    }
            }else{

                $sql="INSERT INTO tercero (tercero_id,numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,email,telefono,tipo_persona_id) 
                      VALUES ($tercero_id,'$numero_identificacion','$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$email','$telefono',$tipo_persona_id)";
                $result=$this->query($sql);
                
                if($result>0){

                    $usuario_id = $this->getMaxId('usuario','usuario_id');

                    $sql="INSERT INTO usuario (usuario_id,username,password,rol_id,tercero_id,estado) 
                        VALUES ($usuario_id,'$username','$password',$rol_id,$tercero_id,'$estado')";
                    $result=$this->query($sql);
                        
                    if($result>0){
                       return 1;
                    }else{
                       throw new Exception("No se pudo guardar el usuario, el motivo: ".$this->error);
                    }
                    
                }else{
                    throw new Exception("No se pudo crear el tercero, el motivo: ".$this->error);
                }
            }
        }
    }

    public function ActualizarUsuario(usuarioDTO $usuario, terceroDTO $tercero){

        $usuario_id = $usuario->getUsuario_id();
        $numero_identificacion = $tercero->getNumero_identificacion();
        $primer_nombre = $tercero->getPrimer_nombre();
        $segundo_nombre =$tercero->getSegundo_nombre();
        $primer_apellido = $tercero->getPrimer_apellido();
        $segundo_apellido = $tercero->getSegundo_apellido();
        $email = $tercero->getEmail();
        $telefono = $tercero->getTelefono();
        $tipo_persona_id = $tercero->getTipo_persona_id();
        $username = $usuario->getUsername();
        $password = $usuario->getPassword();
        $rol_id = $usuario->getRol_id();
        $estado = $usuario->getEstado();

                $update="UPDATE tercero SET numero_identificacion='$numero_identificacion',primer_nombre='$primer_nombre',segundo_nombre='$segundo_nombre',primer_apellido='$primer_apellido',segundo_apellido='$segundo_apellido',email='$email',telefono='$telefono',tipo_persona_id=$tipo_persona_id
                      WHERE tercero_id=(SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=$usuario_id)";
                $result=$this->query($update);
                
                if($result>0){

                    $update="UPDATE usuario SET username='$username', password='$password', rol_id=$rol_id, estado='$estado' WHERE usuario_id = $usuario_id";
                    $result=$this->query($update);

                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo actualizar el usuario, el motivo: ".$this->error);
                    }

                }else{
                    throw new Exception("No se pudo actualizar el tercero, el motivo: ".$this->error);
                }
        
    }


    public function eliminarUsuario(usuarioDTO $usuario){

            $usuario_id = $usuario->getUsuario_id();

            $select="SELECT usuario_id FROM usuario WHERE usuario_id = $usuario_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM usuario WHERE usuario_id=$usuario_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar el usuario, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el usuario ya que no existe, el motivo: ".$this->error);
            }
            
        }

        public function getRol(){  
                 
            $sql = "SELECT rol_id, rol FROM rol";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los roles el motivo:".$this->error);        
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

        public function listarUsuarios(){  
                 
            $sql = "SELECT u.usuario_id,
                           CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS nombre,
                           t.numero_identificacion,
                           t.telefono,
                           (SELECT r.rol FROM rol r WHERE r.rol_id=u.rol_id)AS rol,
                           u.username,
                           u.password,
                           (CASE u.estado WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END)AS estado
                   FROM usuario u, tercero t WHERE t.tercero_id = u.tercero_id";
                 
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los usuarios el motivo:".$this->error);        
            } 
        } 
    
    function getUsuarioAdminLogin($usuario, $password){

        $Usuario=filter_var($usuario,FILTER_SANITIZE_STRING);
        $Password=filter_var($password,FILTER_SANITIZE_STRING);

        $sql = sprintf("SELECT u.usuario_id,
                               u.rol_id,
                        (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id = u.tercero_id)AS nombre
                        
                        FROM usuario u WHERE  u.username ='$Usuario' AND u.password = '$Password'");
        $result=$this->query($sql);
        
        if($result){
            if(mysqli_num_rows($result)>0){

                $select="SELECT p.permiso_id,
                                p.permiso 
                         FROM permiso p, detalle_rol_permiso d, usuario u 
                         WHERE p.permiso_id=d.permiso_id AND d.rol_id=u.rol_id AND u.username ='$Usuario' AND u.password = '$Password'";
                $result_permisos=$this->query($select);

                if(mysqli_num_rows($result_permisos)>0){

                    if($row = mysqli_fetch_assoc($result)){
                      $data[0]['usuario']=$row;        
                    }

                    for($i=0; $row_permisos = mysqli_fetch_assoc($result_permisos); $i++){
                      $data[$i]['permisos']=$row_permisos;        
                    }
                }else{
                    if($row = mysqli_fetch_assoc($result)){
                      $data[0]['usuario']=$row;        
                    }
                }

                return $data;
               

           }else{               
               return 0;
           }
        }else{
            throw new Exception("Error consultado getUsuarioLogin",$this->error);
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


    public function contarUsuarios(){
                 
            $sql = "SELECT COUNT(*) AS usuarios FROM usuario WHERE estado='A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los usuarios el motivo:".$this->error);        
            } 
    } 
    


        
    

    
    
    /*function recuperarClave (usuarioDTO $usuario){
        
        $sql = sprintf("UPDATE usuario SET password='%s' where email='%s'", $usuario->getPassword(), $usuario->getEmail());
        $result = $this->query($sql);

        if($result){
            return true;
        }else{
            throw new Exception("no se pudo editar la clave");
        }
    }
   
    function getCorreoPorCorreo($email){
        
        $sql = "SELECT email FROM usuario WHERE email = '$email'";
        $result = $this->query($sql);
        if($result){
		   
           if($result->num_rows>0){
            $obj=$result->fetch_object();
            return $obj;
           }else{
              echo  "<script language='JavaScript'>"; 
              echo "alert('Error. Vuelve a identificarte el correo no coincide en la base de datos.');"; 
              echo "</script>";

             exit();

           }
        }else{
            throw new Exception("Error consultando getEmail()");
        }
    }
	
	function crearToken(){
		
		$token=md5(rand(1000000,9999999));
		
		$sql=("INSERT INTO tokens (token) VALUES ('$token')");
		$result=$this->query($sql);
		
		if($result){
			return $token;
		}else{
			throw new Exception("Hubo un error al crear el token ".$this->db->error);
		}
	}
	
	
	
	function validarToken($token){
		
		$sql="SELECT token FROM tokens WHERE token = '$token'";
		$result=$this->query($sql);
		
		if($result->num_rows>0){
			
			return 1;
			
		}else{
			return 0;
		}
		
	}
	
	function elimToken($token){
        
        $sql = sprintf("UPDATE tokens SET token = NULL WHERE token='$token'");
        $result = $this->query($sql);

    }*/
	
	
    
    
}

?>