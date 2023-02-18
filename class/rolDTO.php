<?php
class rolDTO {
    
    var $rol_id;
    var $rol;
    var $estado;
    
    function __construct($rol_id="",$rol="",$estado="") {
            
        $this->rol_id  =$rol_id;
        $this->rol =$rol; 
        $this->estado =$estado;
       
      }
      
     
      function getRol_id() {
          return $this->rol_id;
      }

      function getRol() {
          return $this->rol;
      }

      function getEstado() {
          return $this->estado;
      }


      function setRol_id($rol_id) {
          $this->rol_id = $rol_id;
      }

      function setRol($rol) {
          $this->rol = $rol;
      }

      function setEstado($estado) {
          $this->estado = $estado;
      }

                    
    	//mapeador
      
    function mapear ($roles){ 

		$this ->setRol_id($roles->rol_id);
        $this ->setRol($roles->rol);
		$this ->setEstado($roles->estado);
    
	}	


    
}