<?php

class usuarioDTO {
   
	var $usuario_id;
    var $tercero_id;
    var $username;
    var $password;
    var $estado;
    var $rol_id;
	 
    function __construct($usuario_id="", $tercero_id="", $username="", $password="", $estado="", $rol_id="") {
        
        $this->usuario_id = $usuario_id;
        $this->tercero_id = $tercero_id;
		$this->username = $username;
        $this->password = $password;
        $this->estado = $estado;
        $this->rol_id = $rol_id;
    }
    
	
	function getUsuario_id() {
       return $this->usuario_id;
    }

    function getTercero_id() {
        return $this->tercero_id;
    }
	
	function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEstado() {
        return $this->estado;
    }

    function getRol_id() {
        return $this->rol_id;
    }
	
	function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setTercero_id($tercero_id) {
        $this->tercero_id = $tercero_id;
    }
	
	function setUsername($username){
		$this->username = $username;
	}

    function setPassword($password){
        $this->password = $password;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    function setRol_id($rol_id){
        $this->rol_id = $rol_id;
    }


    
    function mapear ($usuario){
        $this->setUsuario_id($usuario->usuario_id);
        $this->setTercero_id($usuario->tercero_id);
		$this->setUsername($usuario->username);
        $this->setPassword($usuario->password);
        $this->setEstado($usuario->estado);
        $this->setRol_id($usuario->rol_id);   
    }

}

?>
