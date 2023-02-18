<?php

class empresaDTO {
   
	var $empresa_id;
    var $tercero_id;
    var $representante;
    var $ubicacion;
    var $direccion;
    var $pagina;
    var $registro_mercantil;
    var $camara_comercio;
    var $logo_empresa;
    var $doc_registro;
    var $foto_empresa;
    var $doc_camara;
    var $estado;
    
	 
    function __construct($empresa_id="", $tercero_id="", $representante="", $ubicacion="", $direccion="", $pagina="", $registro_mercantil="", $camara_comercio="",$logo_empresa="", $doc_registro="", $foto_empresa="", $doc_camara="", $estado="") {
        
        $this->empresa_id = $empresa_id;
        $this->tercero_id = $tercero_id;
		$this->representante = $representante;
        $this->ubicacion = $ubicacion;
        $this->direccion = $direccion;
        $this->pagina = $pagina;
        $this->registro_mercantil = $registro_mercantil;
        $this->camara_comercio = $camara_comercio;
        $this->logo_empresa = $logo_empresa;
        $this->doc_registro = $doc_registro;
        $this->foto_empresa = $foto_empresa;
        $this->doc_camara = $doc_camara;
        $this->estado = $estado;
       
    }
    
	
	function getEmpresa_id() {
       return $this->empresa_id;
    }

    function getTercero_id() {
        return $this->tercero_id;
    }
	
	function getRepresentante() {
        return $this->representante;
    }

    function getUbicacion() {
        return $this->ubicacion;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getPagina() {
        return $this->pagina;
    }

    function getRegistro_mercantil() {
        return $this->registro_mercantil;
    }

    function getCamara_comercio() {
        return $this->camara_comercio;
    }

    function getLogo_empresa() {
        return $this->logo_empresa;
    }

    function getDoc_registro() {
        return $this->doc_registro;
    }

     function getFoto_empresa() {
        return $this->foto_empresa;
    }

    function getDoc_camara() {
        return $this->doc_camara;
    }

    function getEstado() {
        return $this->estado;
    }

	
	function setEmpresa_id($empresa_id) {
        $this->empresa_id = $empresa_id;
    }

    function setTercero_id($tercero_id) {
        $this->tercero_id = $tercero_id;
    }
	
	function setRepresentante($representante){
		$this->representante = $representante;
	}

    function setUbicacion($ubicacion){
        $this->ubicacion = $ubicacion;
    }

    function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    function setPagina($pagina){
        $this->pagina = $pagina;
    }

    function setRegistro_mercantil($registro_mercantil){
        $this->registro_mercantil = $registro_mercantil;
    }

    function setCamara_comercio($camara_comercio){
        $this->camara_comercio = $camara_comercio;
    }

    function setLogo_empresa($logo_empresa){
        $this->logo_empresa = $logo_empresa;
    }

    function setDoc_registro($doc_registro){
        $this->doc_registro = $doc_registro;
    }

    function setFoto_empresa($foto_empresa){
        $this->foto_empresa = $foto_empresa;
    }

    function setDoc_camara($doc_camara){
        $this->doc_camara = $doc_camara;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    
    function mapear ($empresa){
        $this->setempresa_id($empresa->empresa_id);
        $this->setTercero_id($empresa->tercero_id);
		$this->setRepresentante($empresa->representante);
        $this->setUbicacion($empresa->ubicacion);
        $this->setDireccion($empresa->direccion);
        $this->setPagina($empresa->pagina);
        $this->setRegistro_mercantil($empresa->registro_mercantil);
        $this->setCamara_comercio($empresa->camara_comercio);
        $this->setLogo_empresa($empresa->logo_empresa);
        $this->setDoc_registro($empresa->doc_registro);
        $this->setFoto_empresa($empresa->foto_empresa);
        $this->setDoc_camara($empresa->doc_camara);
        $this->setEstado($empresa->estado);
    }

}

?>
