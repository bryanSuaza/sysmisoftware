<?php

class facturaDTO {
   
    var $factura_id;
    var $cliente_id;
    var $fecha;
    var $valor_total;
    var $estado;
    var $usuario_id;
    var $servicio_id;
    var $producto_id;
    var $concepto;
    var $cantidad;
    var $valor;
	 
    function __construct($factura_id="", $cliente_id="", $fecha="", $valor_total="", $estado="",  $usuario_id="", $servicio_id="", $producto_id="", $concepto="", $cantidad="",  $valor="") {
        
        $this->factura_id = $factura_id;
        $this->cliente_id = $cliente_id;
        $this->fecha = $fecha;
        $this->valor_total = $valor_total;
        $this->estado = $estado;
        $this->usuario_id = $usuario_id;
        $this->servicio_id = $servicio_id;
        $this->producto_id = $producto_id;
		$this->concepto = $concepto;
        $this->cantidad = $cantidad;
        $this->valor = $valor;

    }
    
	
	function getFactura_id() {
       return $this->factura_id;
    }

    function getCliente_id() {
        return $this->cliente_id;
    }
	
	function getFecha() {
        return $this->fecha;
    }

    function getValor_total() {
        return $this->valor_total;
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
	
	function getServicio_id() {
        return $this->servicio_id;
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

    function setFactura_id($factura_id){
        $this->factura_id = $factura_id;
    }

    function setCliente_id($cliente_id){
        $this->cliente_id = $cliente_id;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function setValor_total($valor_total){
        $this->valor_total = $valor_total;
    }
	
	function setEstado($estado) {
        $this->estado = $estado;
    }

    function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    function setServicio_id($servicio_id){
        $this->servicio_id = $servicio_id;
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

    
    function mapear ($factura){
        $this->setfactura_id($factura->factura_id);
        $this->setCliente_id($factura->cliente_id);
        $this->setFecha($factura->fecha);
        $this->setValor_total($factura->valor_total);
        $this->setEstado($factura->estado);
        $this->setUsuario_id($factura->usuario_id); 
        $this->setServicio_id($factura->servicio_id);
        $this->setProducto_id($factura->producto_id);
		$this->setConcepto($factura->concepto);
        $this->setCantidad($factura->cantidad);
        $this->setValor($factura->valor);   
    }

}

?>