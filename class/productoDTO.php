<?php
class productoDTO {
    
    var $producto_id;
    var $nombre;
    var $categoria_id;
    var $valor_costo;
    var $valor_venta;
    var $estado;
    
    function __construct($producto_id="",$nombre="",$categoria_id="",$valor_costo="",$valor_venta="",$estado="") {
            
        $this->producto_id  =$producto_id;
        $this->nombre =$nombre; 
        $this->categoria_id =$categoria_id;
        $this->valor_costo  =$valor_costo;
        $this->valor_venta =$valor_venta; 
        $this->estado =$estado;
       
      }
      
     
      function getProducto_id() {
          return $this->producto_id;
      }

      function getNombre() {
          return $this->nombre;
      }

      function getCategoria_id() {
          return $this->categoria_id;
      }

      function getValor_costo() {
          return $this->valor_costo;
      }

      function getValor_venta() {
          return $this->valor_venta;
      }

      function getEstado() {
          return $this->estado;
      }



      function setProducto_id($producto_id) {
          $this->producto_id = $producto_id;
      }

      function setNombre($nombre) {
          $this->nombre = $nombre;
      }

      function setCategoria_id($categoria_id) {
          $this->categoria_id = $categoria_id;
      }

      function setValor_costo($valor_costo) {
          $this->valor_costo = $valor_costo;
      }

      function setValor_venta($valor_venta) {
          $this->valor_venta = $valor_venta;
      }

      function setEstado($estado) {
          $this->estado = $estado;
      }

                    
    //mapeador
      
    function mapear ($producto){ 

		$this ->setProducto_id($producto->producto_id);
        $this ->setNombre($producto->nombre);
        $this ->setCategoria_id($producto->categoria_id);
        $this ->setValor_costo($producto->valor_costo);
        $this ->setValor_venta($producto->valor_venta);
		$this ->setEstado($producto->estado);
    
	}	


    
}