<?php

class parqueaderoDTO {
   
	var $parqueadero_id;
    var $codigo_ticket;
    var $placa;
    var $tipo_vehiculo_id;
    var $tipo_servicio_id;
    var $fecha_hora_ingreso;
    var $fecha_hora_salida;
    var $valor_servicio;
    var $descripcion;
    var $estado;
    var $horas;
    var $dias;
    var $medios_dias;
	 
    function __construct($parqueadero_id="", $codigo_ticket="", $placa="", $tipo_vehiculo_id="", $tipo_servicio_id="", $fecha_hora_ingreso="", $fecha_hora_salida="", $valor_servicio="", $descripcion="", $estado="",$horas="",$dias="",$medios_dias="") {
        
        $this->parqueadero_id = $parqueadero_id;
        $this->codigo_ticket = $codigo_ticket;
        $this->placa = $placa;
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
        $this->tipo_servicio_id = $tipo_servicio_id;
        $this->fecha_hora_ingreso = $fecha_hora_ingreso;
        $this->fecha_hora_salida = $fecha_hora_salida;
        $this->valor_servicio = $valor_servicio;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->horas = $horas;
        $this->dias = $dias;
        $this->medios_dias = $medios_dias;
        
    }
    
	
	function getParqueadero_id() {
       return $this->parqueadero_id;
    }

    function getCodigo_ticket() {
        return $this->codigo_ticket;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getTipo_vehiculo_id() {
        return $this->tipo_vehiculo_id;
    }

    function getTipo_servicio_id() {
        return $this->tipo_servicio_id;
    }

    function getFecha_hora_ingreso() {
        return $this->fecha_hora_ingreso;
    }

    function getFecha_hora_salida() {
        return $this->fecha_hora_salida;
    }

    function getValor_servicio() {
        return $this->valor_servicio;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEstado() {
        return $this->estado;
    }

    function getHoras() {
        return $this->horas;
    }

    function getDias() {
        return $this->dias;
    }

    function getMediosDias() {
        return $this->medios_dias;
    }
	

    function setParqueadero_id($parqueadero_id){
        $this->parqueadero_id = $parqueadero_id;
    }

    function setCodigo_ticket($codigo_ticket){
        $this->codigo_ticket = $codigo_ticket;
    }

    function setPlaca($placa){
        $this->placa = $placa;
    }

    function setTipo_vehiculo_id($tipo_vehiculo_id){
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
    }

    function setTipo_servicio_id($tipo_servicio_id){
        $this->tipo_servicio_id = $tipo_servicio_id;
    }

    function setFecha_hora_ingreso($fecha_hora_ingreso){
        $this->fecha_hora_ingreso = $fecha_hora_ingreso;
    }

    function setFecha_hora_salida($fecha_hora_salida){
        $this->fecha_hora_salida = $fecha_hora_salida;
    }

    function setValor_servicio($valor_servicio){
        $this->valor_servicio = $valor_servicio;
    }

    function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    function setHoras($horas){
        $this->horas = $horas;
    }

    function setDias($dias){
        $this->dias = $dias;
    }

    function setMediosDias($medios_dias){
        $this->medios_dias = $medios_dias;
    }

  
    function mapear ($parqueadero){
        $this->setParqueadero_id($parqueadero->parqueadero_id);
        $this->setCodigo_ticket($parqueadero->codigo_ticket);
        $this->setPlaca($parqueadero->placa);
        $this->setFecha_hora_ingreso($parqueadero->fecha_hora_ingreso);
        $this->setFecha_hora_salida($parqueadero->fecha_hora_salida);
        $this->setValor_servicio($parqueadero->valor_servicio);
        $this->setDescripcion($parqueadero->descripcion);
        $this->setEstado($parqueadero->estado);
        $this->setHoras($parqueadero->horas);
        $this->setDias($parqueadero->dias);
        $this->setMediosDias($parqueadero->medios_dias);
    }

}

?>