<?php
class terceroDTO {
    
    var $tercero_id;
    var $numero_identificacion;
    var $digito_verificacion;
    var $primer_nombre;
    var $segundo_nombre;
    var $primer_apellido;
    var $segundo_apellido;
    var $razon_social;
    var $email;
    var $telefono;
    var $tipo_persona_id;
    
    function __construct($tercero_id="",$numero_identificacion="",$digito_verificacion="", $primer_nombre="", $segundo_nombre="", $primer_apellido="", $segundo_apellido="",$razon_social="", $email="", $telefono="", $tipo_persona_id="") {
            
        $this->tercero_id = $tercero_id;
        $this->numero_identificacion =$numero_identificacion; 
        $this->digito_verificacion =$digito_verificacion;
        $this->primer_nombre =$primer_nombre;
        $this->segundo_nombre =$segundo_nombre;
        $this->primer_apellido =$primer_apellido;
        $this->segundo_apellido =$segundo_apellido;
        $this->razon_social =$razon_social;
        $this->email =$email;
        $this->telefono =$telefono;
        $this->tipo_persona_id =$tipo_persona_id;
       
      }
      
     //modificadores
      function getTercero_id() {
          return $this->tercero_id;
      }

      function getNumero_identificacion() {
          return $this->numero_identificacion;
      }

      function getDigito_verificacion() {
          return $this->digito_verificacion;
      }

      function getPrimer_nombre() {
          return $this->primer_nombre;
      }

      function getSegundo_nombre() {
          return $this->segundo_nombre;
      }

      function getPrimer_apellido() {
          return $this->primer_apellido;
      }

     function getSegundo_apellido() {
          return $this->segundo_apellido;
      }

      function getRazon_social() {
          return $this->razon_social;
      }

      function getEmail() {
          return $this->email;
      }

      function getTelefono() {
          return $this->telefono;
      }

      function getTipo_persona_id() {
          return $this->tipo_persona_id;
      }

     //accesores
      function setTercero_id($tercero_id) {
          $this->tercero_id = $tercero_id;
      }

      function setNumero_identificacion($numero_identificacion) {
          $this->numero_identificacion = $numero_identificacion;
      }

      function setDigito_verificacion($digito_verificacion) {
          $this->digito_verificacion = $digito_verificacion;
      }

      function setPrimer_nombre($primer_nombre) {
          $this->primer_nombre = $primer_nombre;
      }

      function setSegundo_nombre($segundo_nombre) {
          $this->segundo_nombre = $segundo_nombre;
      }

      function setPrimer_apellido($primer_apellido) {
          $this->primer_apellido = $primer_apellido;
      }

     function setSegundo_apellido($segundo_apellido) {
          $this->segundo_apellido = $segundo_apellido;
      }

     function setRazon_social($razon_social) {
          $this->razon_social = $razon_social;
      }

     function setEmail($email) {
          $this->email = $email;
      }

     function setTelefono($telefono) {
          $this->telefono = $telefono;
      }

     function setTipo_persona_id($tipo_persona_id) {
          $this->tipo_persona_id = $tipo_persona_id;
      }

                    
    //mapeador
      
    function mapear ($tercero){ 

		$this ->setTercero_id($tercero->tercero_id);
        $this ->setNumero_identificacion($tercero->numero_identificacion);
        $this ->setDigito_verificacion($tercero->digito_verificacion);
        $this ->setPrimer_nombre($tercero->primer_nombre);
        $this ->setSegundo_nombre($tercero->segundo_nombre);
        $this ->setPrimer_apellido($tercero->primer_apellido);
        $this ->setSegundo_apellido($tercero->segundo_apellido);
        $this ->setRazon_social($tercero->razon_social);
        $this ->setEmail($tercero->email);
        $this ->setTelefono($tercero->telefono);
        $this ->setTipo_persona_id($tercero->tipo_persona_id);    
	}	


    
}