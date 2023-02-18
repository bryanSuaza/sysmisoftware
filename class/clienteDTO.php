<?php

class clienteDTO {
   
	var $cliente_id;
    var $tercero_id;
    var $banco;
    var $numero_cuenta;
    var $estado;
    var $usuario_id;
    
	 
    function __construct($cliente_id="", $tercero_id="", $banco="", $numero_cuenta="", $estado="", $usuario_id="") {
        
        $this->cliente_id = $cliente_id;
        $this->tercero_id = $tercero_id;
		$this->banco = $banco;
        $this->numero_cuenta = $numero_cuenta;
        $this->estado = $estado;
        $this->usuario_id = $usuario_id;
       
    }
    
	
	function getCliente_id() {
       return $this->cliente_id;
    }

    function getTercero_id() {
        return $this->tercero_id;
    }
	
	function getBanco() {
        return $this->banco;
    }

    function getNumero_cuenta() {
        return $this->numero_cuenta;
    }

    function getEstado() {
        return $this->estado;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

	
	function setCliente_id($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    function setTercero_id($tercero_id) {
        $this->tercero_id = $tercero_id;
    }
	
	function setBanco($banco){
		$this->banco = $banco;
	}

    function setNumero_cuenta($numero_cuenta){
        $this->numero_cuenta = $numero_cuenta;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    
    function mapear ($cliente){
        $this->setcliente_id($cliente->cliente_id);
        $this->setTercero_id($cliente->tercero_id);
		$this->setBanco($cliente->banco);
        $this->setNumero_cuenta($cliente->numero_cuenta);
        $this->setEstado($cliente->estado);
        $this->setUsuario_id($cliente->usuario_id);
    }

}

?>
