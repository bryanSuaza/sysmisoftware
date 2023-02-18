<?php

require("./class/db.class.php");
require("./class/empresaDTO.php");
require("./class/empresaDAO.php");

$empresa_id = filter_input(INPUT_GET, "empresa_id", FILTER_SANITIZE_NUMBER_INT);
 
$empresaDTO = new empresaDTO();
$empresaDAO = new empresaDAO(); 

$tipo_persona = $empresaDAO->getTipo_persona(); 

?>

<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Crear Empresa</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="container-fluid">
              <div style="text-align: center;">
              <h2><i class="fa fa-archive"></i> DATOS EMPRESA</h2>
              </div>
              <br>
              <div class="input-group md-form form-sm form-1 pl-0">
                <div class="input-group-prepend">
                  <span class="input-group-text cyan lighten-2" id="basic-text1"><i class="fa fa-search text-white"
                      aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" id="buscar" name="buscar" placeholder="Busca una empresa con su numero de identificación o nit" aria-label="Search">
              </div>
              <br>
               <!-- Image loader -->
              <div id='loader' style="text-align: center; display: none">
                <img src='./images/loading.gif' width='80px' height='75px'>
              </div>
            

              <form id="form" method="POST" enctype="multipart/form-data" style="padding-left: 40px; padding-right: 40px;">
               <div class="row">
                    <div class="form-group col-md-4">
                      <input type="hidden" class="form-control" name="empresa_id" id="empresa_id" value="<?php echo $empresa_id ?>">
                      <label>Tipo Persona<span style="color:red">*</span></label>
                      <select class="form-control" id="tipo_persona_id" name="tipo_persona_id">
                        <?php
                        while ($row = mysqli_fetch_array($tipo_persona)) {
                          echo '<option value="'.$row['tipo_persona_id'].'">'.$row['nombre'].'</option>';
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Primer Nombre<span style="color:red">*</span></label>
                      <input type="text" class="form-control"  name="primer_nombre" id="primer_nombre">
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label>Segundo Nombre</label>
                      <input type="text" class="form-control"  name="segundo_nombre" id="segundo_nombre">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Primer Apellido<span style="color:red">*</span></label>
                        <input type="text" class="form-control"  name="primer_apellido" id="primer_apellido">
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label>Segundo Apellido</label>
                      <input type="text" class="form-control"  name="segundo_apellido" id="segundo_apellido">
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label>Razon Social<span style="color:red">*</span></label>
                      <input type="text" class="form-control"  name="razon_social" id="razon_social">
                    </div>

                    <div class="form-group col-md-4">
                      <label>Numero Identificaci&oacute;n<span style="color:red">*</span></label>
                      <input type="number" class="form-control"  name="numero_identificacion" id="numero_identificacion" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Digito Verificaci&oacute;n</label>
                        <input type="number" class="form-control"  name="digito_verificacion" id="digito_verificacion" readonly="readonly">
                      </div>
                    
                    <div class="form-group col-md-4">
                      <label>Ubicacion<span style="color:red">*</span></label>
                      <input type="text" class="form-control"  name="ubicacion" id="ubicacion" required>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Direccion<span style="color:red">*</span></label>
                      <input type="text" class="form-control"  name="direccion" id="direccion" required>
                    </div>

                    <div class="form-group col-md-4">
                      <label>Registro Mercantil</label>
                      <input type="number" class="form-control"  name="registro_mercantil" id="registro_mercantil">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Camara de Comercio<span style="color:red">*</span></label>
                      <input type="number" class="form-control"  name="camara_comercio" id="camara_comercio" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="foto_empresa">Cargar Foto Empresa</label>&nbsp;&nbsp;<button id="archivo_foto" class="btn btn-light"><a class="fa fa-file-archive-o"></a>  Ver Archivo</button>
                      <input type="file" class="form-control" id="foto_empresa" name="foto_empresa" lang="es">
                   </div>





                  <div class="form-group col-md-4">
                    <label for="doc_registro">Cargar Registro Mercantil</label>&nbsp;&nbsp;<button id="archivo_doc_registro" class="btn btn-light"><a class="fa fa-file-archive-o"></a>  Ver Archivo</button>
                    <input type="file" class="form-control" id="doc_registro" name="doc_registro" lang="es">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="doc_camara">Cargar Camara Comercio</label>&nbsp;&nbsp;<button id="archivo_doc_camara" class="btn btn-light"><a class="fa fa-file-archive-o"></a>  Ver Archivo</button>
                    <input type="file" class="form-control" id="doc_camara" name="doc_camara" lang="es">
                  </div>

                  <div class="form-group col-md-4">
                      <label>Telefono<span style="color:red">*</span></label>
                      <input type="number" class="form-control"  name="telefono" id="telefono" required>
                  </div>

                  <div class="form-group col-md-4">
                      <label>Email<span style="color:red">*</span></label>
                      <input type="email" class="form-control"  name="email" id="email" required>
                  </div>

                  <div class="form-group col-md-4">
                      <label>Pagina Web</label>
                      <input type="text" class="form-control"  name="pagina" id="pagina">
                  </div>

                  <div class="form-group col-md-4">
                    <label>Representante Legal</label>
                    <input type="text" class="form-control"  name="representante" id="representante">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="logo_empresa">Cargar Logo</label>&nbsp;&nbsp;<button id="archivo_logo" class="btn btn-light"><a class="fa fa-file-archive-o"></a>  Ver Archivo</button>
                    <input type="file" class="form-control" id="logo_empresa" name="logo_empresa" lang="es">
                  </div>

                  <div class="form-group col-md-4">
                    <label>Estado<span style="color:red">*</span></label>
                    <select class="form-control" id="estado" name="estado">
                      <option value="A">ACTIVO</option>
                      <option value="I">INACTIVO</option>
                    </select>
                </div>
              </div>
              
              <div style="text-align: center">
              <?php
               if($_SESSION['guardar']=='SI'){
              ?>
                 <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
              <?php
               }
               if($_SESSION['actualizar']=='SI'){
              ?>
                <button type="submit" class="btn btn-primary" id="actualizar">Actualizar</button>
              <?php
               }
               if($_SESSION['eliminar']=='SI'){
              ?>
                <button type="submit" class="btn btn-primary" id="eliminar">Eliminar</button>
              <?php
               }
               ?>  
                <button type="submit" class="btn btn-primary" id="limpiar">Limpiar</button>
              </div>
               
               </form>
            
        </div>
        <script src="js/empresa.js"></script>
    </body>	
</html>