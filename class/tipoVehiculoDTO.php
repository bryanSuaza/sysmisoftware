<?php

class tipoVehiculoDTO {
   
	var $tipo_vehiculo_id;
    var $tipo;
    var $estado;
	 
    function __construct($tipo_vehiculo_id="", $tipo="", $estado="") {
        
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
        $this->tipo = $tipo;
        $this->estado = $estado;
        
    }
    
	
	function getTipo_vehiculo_id() {
       return $this->tipo_vehiculo_id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEstado() {
        return $this->estado;
    }

	

    function setTipo_vehiculo_id($tipo_vehiculo_id){
        $this->tipo_vehiculo_id = $tipo_vehiculo_id;
    }

    function setTipo($tipo){
        $this->tipo = $tipo;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

  
    function mapear ($tipoVehiculo){
        $this->setTipo_vehiculo_id($tipoVehiculo->tipoVehiculo_id);
        $this->setTipo($tipoVehiculo->tipo);
        $this->setEstado($tipoVehiculo->estado);
    }

}

?>