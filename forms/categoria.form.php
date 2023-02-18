<?php

require("./class/db.class.php");
require("./class/categoriaDTO.php");
require("./class/categoriaDAO.php");

$categoria_id = filter_input(INPUT_GET, "categoria_id", FILTER_SANITIZE_NUMBER_INT);
 
$categoriaDTO = new categoriaDTO();
$categoriaDAO = new categoriaDAO(); 

$categorias = $categoriaDAO->getCategoria();

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear Categoria</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container">
              <div style="text-align: center;">
                <h2><i class="fa fa-level-up"></i> CATEGORIAS</h2>
              </div>
              <br>
              <div class="row">
              <div class="col-sm-6">
               
                   <form id="form">
                   <table class="table table-striped table-responsive" style="padding-left:120px">
                   <thead class="table-primary">
                                        <tr>
                                            <th style="text-align: center" colspan="2">AGREGAR CATEGORIA</th>  
                                        </tr>
                   </thead>
                   <tbody>
                   <tr>
                   <td>
                        <input type="hidden" class="form-control" name="categoria_id" id="categoria_id">
                        <input type="text" class="form-control" placeholder="Digita nombre categoria" name="nombre" id="nombre" required>
                  </td>
                  <td>
                        <?php
                        if($_SESSION['guardar']=='SI'){
                        ?>
                            <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
                        <?php
                        }
                        ?>
                </td>
                 <tr>
                 </tbody>
                 </table>
                 </form>
                
              </div>
              <div class="col-sm-6">
              
                            <table id="table_categoria" class="table table-striped table-responsive">
                                    <thead class="table-primary">
                                        <tr>
                                            <th style="text-align: center" scope="col">CATEGORIA</th>
                                            <th style="text-align: center" colspan="2">OPCIONES</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($categorias != "") {
                                            while ($categoria = mysqli_fetch_array($categorias)) { 
                                                    ?> 
                                                <tr>
                                                    <td>
                                                        <?php             
                                                              echo $categoria['nombre'];
                                                        ?>
                                                        <input type="hidden" class="form-control" name="categoria_id" id="categoria_id" value="<?php echo $categoria['categoria_id']; ?>">
                                                        <input type="hidden" class="form-control" name="nombre_categoria" id="nombre_categoria" value="<?php echo $categoria['nombre'] ?>">
                                                    </td>
                                                    <td>   
                                                        <button class="btn btn-success" id="actualizar"><a class="fa fa-pencil"></a></button>
                                                    </td>
                                                    <td>   
                                                        <button class="btn btn-danger" id="eliminar"><a class="fa fa-trash"></a></button>
                                                    </td>
                                                </tr> 
                                                <?php
                                            }
                                        }  
                                        ?>
                                    </tbody>
                            </table>
                           
                </div>
              </div>
             
            
        </div>
        <script src="js/categoria.js"></script>
    </body>	
</html>