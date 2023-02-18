<?php

class categoriaDAO extends db{
   
    function __construct() {
        parent::__construct();
    }

    public function getMaxId($Table,$Column){
    
    $increment = 1;
    
	  $select = "SELECT MAX($Column) AS max_consecutive FROM $Table";
      $Max    = $this -> query($select);	  
      if(mysqli_num_rows($Max)>0){
          if($row = mysqli_fetch_assoc($Max)){
             $max_consecutive =  $row['max_consecutive'];
          }
      }else{
          $max_consecutive = 0;
      }
	  
      return $max_consecutive += $increment;
	  	  
	}

    
    public function crearCategoria(categoriaDTO $categoria){
         
        $nombre = $categoria->getNombre();
        $categoria_id = $this->getMaxId('categoria','categoria_id');

        $select="SELECT categoria_id FROM categoria WHERE nombre = '$nombre'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

                $sql="INSERT INTO categoria (categoria_id,nombre) VALUES ($categoria_id,'$nombre')";
                
                $result=$this->query($sql);
                
                if($result>0){
                       return 1;
                }else{
                    throw new Exception("No se pudo crear la categoria, el motivo: ".$this->error);
                }
        }
    }

    public function ActualizarCategoria(categoriaDTO $categoria){

        $categoria_id = $categoria->getCategoria_id();
        $nombre = $categoria->getNombre();

                $update="UPDATE categoria SET nombre='$nombre' WHERE categoria_id=$categoria_id";
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar la categoria, el motivo: ".$this->error);
                }
        
    }


    public function eliminarCategoria(categoriaDTO $categoria){

            $categoria_id = $categoria->getCategoria_id();

            $select="SELECT categoria_id FROM categoria WHERE categoria_id = $categoria_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM categoria WHERE categoria_id=$categoria_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar la categoria, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar la categoria ya que no existe, el motivo: ".$this->error);
            }
            
        }

        public function getCategoria(){  
                 
            $sql = "SELECT categoria_id, nombre FROM categoria";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                return 0;        
            } 
        } 

        
    }