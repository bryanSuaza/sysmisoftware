<?php

class habitacionDTO {
   
	var $habitacion_id;
    var $numero;
    var $valor;
    var $descripcion;
    var $estado;
    var $tipo_habitacion_id;
    var $imagen;
    var $usuario_id;
	 
    function __construct($habitacion_id="", $numero="", $valor="", $descripcion="", $estado="", $tipo_habitacion_id="", $imagen="", $usuario_id="") {
        
        $this->habitacion_id = $habitacion_id;
        $this->numero = $numero;
		$this->valor = $valor;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->tipo_habitacion_id = $tipo_habitacion_id;
        $this->imagen = $imagen;
        $this->usuario_id = $usuario_id;

    }
    
	
	function getHabitacion_id() {
       return $this->habitacion_id;
    }

    function getNumero() {
        return $this->numero;
    }
	
	function getValor() {
        return $this->valor;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function getTipo_habitacion_id() {
        return $this->tipo_habitacion_id;
    }

    function getImagen() {
        return $this->imagen;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function setHabitacion_id($habitacion_id){
        $this->habitacion_id = $habitacion_id;
    }

    function setNumero($numero){
        $this->numero = $numero;
    }

    function setValor($valor){
        $this->valor = $valor;
    }
	
	function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    function setTipo_habitacion_id($tipo_habitacion_id) {
        $this->tipo_habitacion_id = $tipo_habitacion_id;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }


    
    function mapear ($habitacion){
        $this->setHabitacion_id($habitacion->habitacion_id);
        $this->setNumero($habitacion->numero);
		$this->setValor($habitacion->valor);
        $this->setDescripcion($habitacion->descripcion);
        $this->setEstado($habitacion->estado);
        $this->setTipo_habitacion_id($habitacion->tipo_habitacion_id); 
        $this->setImagen($habitacion->imagen); 
        $this->setUsuario_id($habitacion->usuario_id);   
    }

}

?>