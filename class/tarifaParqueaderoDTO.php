<?php

class tarifaParqueaderoDTO {
   
	var $tarifas_parqueadero_id;
    var $tipo_vehiculo_id;
    var $valor_hora_diurna;
    var $valor_hora_nocturna;
    var $valor_medio_dia;
    var $valor_dia;
    var $valor_mes;
    var $tiempo_cobro;
    var $estado;
	 
    function __construct($tarifas_parqueadero_id="", $tipo_vehiculo_id="", $valor_hora_diurna="", $valor_hora_nocturna="", $valor_medio_dia="", $valor_dia="", $valor_mes="", $tiempo_cobro="",  $estado="") {
        
        $this->tarifas_parqueadero_id = $tarifas_parqueadero_id;
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
        $this->valor_hora_diurna = $valor_hora_diurna;
        $this->valor_hora_nocturna = $valor_hora_nocturna;
        $this->valor_dia = $valor_dia;
        $this->valor_medio_dia = $valor_medio_dia;
        $this->valor_mes = $valor_mes;
        $this->tiempo_cobro = $tiempo_cobro;
        $this->estado = $estado;
        
    }
    
	
	function getTarifas_parqueadero_id() {
       return $this->tarifas_parqueadero_id;
    }

    function getTipo_vehiculo_id() {
        return $this->tipo_vehiculo_id;
    }

    function getValor_hora_diurna() {
        return $this->valor_hora_diurna;
    }

    function getValor_hora_nocturna() {
        return $this->valor_hora_nocturna;
    }

    function getValor_medio_dia() {
        return $this->valor_medio_dia;
    }

     function getValor_dia() {
        return $this->valor_dia;
    }

    function getValor_mes() {
        return $this->valor_mes;
    }

    function getEstado() {
        return $this->estado;
    }

    function getTiempo_cobro() {
        return $this->tiempo_cobro;
    }
	

    function setTarifas_parqueadero_id($tarifas_parqueadero_id){
        $this->tarifas_parqueadero_id = $tarifas_parqueadero_id;
    }

    function setTipo_vehiculo_id($tipo_vehiculo_id){
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
    }

    function setValor_hora_diurna($valor_hora_diurna){
        $this->valor_hora_diurna = $valor_hora_diurna;
    }

    function setValor_hora_nocturna($valor_hora_nocturna){
        $this->valor_hora_nocturna = $valor_hora_nocturna;
    }

    function setValor_dia($valor_dia){
        $this->valor_dia = $valor_dia;
    }

    function setValor_medio_dia($valor_medio_dia){
        $this->valor_medio_dia = $valor_medio_dia;
    }

    function setValor_mes($valor_mes){
        $this->valor_mes = $valor_mes;
    }

    function setTiempo_cobro($tiempo_cobro){
        $this->tiempo_cobro = $tiempo_cobro;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

  
    function mapear ($tarifaParqueadero){
        $this->setTarifas_parqueadero_id($tarifaParqueadero->tarifaParqueadero_id);
        $this->setTipo_vehiculo_id($tarifaParqueadero->tipo_vehiculo_id);
        $this->setValor_hora_diurna($tarifaParqueadero->valor_hora_diurna);
        $this->setValor_hora_nocturna($tarifaParqueadero->valor_hora_nocturna);
        $this->setValor_dia($tarifaParqueadero->valor_dia);
        $this->setValor_medio_dia($tarifaParqueadero->valor_medio_dia);
        $this->setValor_mes($tarifaParqueadero->valor_mes);
        $this->setTiempo_cobro($tarifaParqueadero->tiempo_cobro);
        $this->setEstado($tarifaParqueadero->estado);
    }

}

?>