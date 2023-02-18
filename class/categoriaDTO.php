<?php

class categoriaDTO {
   
	var $categoria_id;
    var $nombre;
	 
    function __construct($categoria_id="", $nombre="") {
        
        $this->categoria_id = $categoria_id;
        $this->nombre = $nombre;

    }
    
	
	function getCategoria_id() {
       return $this->categoria_id;
    }

    function getNombre() {
        return $this->nombre;
    }
	

    function setCategoria_id($categoria_id){
        $this->categoria_id = $categoria_id;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

  
    function mapear ($categoria){
        $this->setcategoria_id($categoria->categoria_id);
        $this->setnombre($categoria->nombre);
    }

}

?>