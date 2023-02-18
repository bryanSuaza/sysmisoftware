<?php

class servicioDTO {
   
    var $servicio_id;
    var $cliente_id;
    var $fecha;
    var $hora;
    var $estado;
    var $usuario_id;
    var $habitacion_id;
    var $producto_id;
    var $concepto;
    var $cantidad;
    var $valor;
	 
    function __construct($servicio_id="", $cliente_id="", $fecha="", $hora="", $estado="",  $usuario_id="", $habitacion_id="", $producto_id="", $concepto="", $cantidad="",  $valor="") {
        
        $this->servicio_id = $servicio_id;
        $this->cliente_id = $cliente_id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->estado = $estado;
        $this->usuario_id = $usuario_id;
        $this->habitacion_id = $habitacion_id;
        $this->producto_id = $producto_id;
		$this->concepto = $concepto;
        $this->cantidad = $cantidad;
        $this->valor = $valor;

    }
    
	
	function getServicio_id() {
       return $this->servicio_id;
    }

    function getCliente_id() {
        return $this->cliente_id;
    }
	
	function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function getEstado() {
        return $this->estado;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

     function getValor() {
        return $this->valor;
    }
	
	function getHabitacion_id() {
        return $this->habitacion_id;
    }

    function getProducto_id() {
        return $this->producto_id;
    }

    function getConcepto() {
        return $this->concepto;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setServicio_id($servicio_id){
        $this->servicio_id = $servicio_id;
    }

    function setCliente_id($cliente_id){
        $this->cliente_id = $cliente_id;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function setHora($hora){
        $this->hora = $hora;
    }
	
	function setEstado($estado) {
        $this->estado = $estado;
    }

    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    function setHabitacion_id($habitacion_id){
        $this->habitacion_id = $habitacion_id;
    }

    function setProducto_id($producto_id){
        $this->producto_id = $producto_id;
    }

    function setConcepto($concepto){
        $this->concepto = $concepto;
    }
	
	function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setValor($valor){
        $this->valor = $valor;
    }

    
    function mapear ($servicio){
        $this->setServicio_id($servicio->servicio_id);
        $this->setCliente_id($servicio->cliente_id);
        $this->setFecha($servicio->fecha);
        $this->setHora($servicio->hora);
        $this->setEstado($servicio->estado);
        $this->setUsuario_id($servicio->usuario_id); 
        $this->setHabitacion_id($servicio->habitacion_id);
        $this->setProducto_id($servicio->producto_id);
		$this->setConcepto($servicio->concepto);
        $this->setCantidad($servicio->cantidad);
        $this->setValor($servicio->valor);   
    }

}

?>