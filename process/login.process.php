<?php

require("../class/db.class.php");
require("../class/usuarioDTO.php");
require("../class/usuarioDAO.php");
require("../class/empresaDAO.php");


$usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$usuarioDTO = new usuarioDTO();
$usuarioDAO = new usuarioDAO();
$empresaDAO = new empresaDAO();

$usuarioAdmin = $usuarioDAO->getUsuarioAdminLogin($usuario, $password);

if($usuarioAdmin){
  
  $usuario = $usuarioAdmin[0]['usuario'];
  
  for($i=0; $i<count($usuarioAdmin); $i++){
    
    $permisos = $usuarioAdmin[$i]['permisos'];
    $permiso = $permisos['permiso'];
    
    if($permiso == 'GUARDAR'){
      $guardar = 'SI';
    }else if($permiso == 'ACTUALIZAR'){
      $actualizar = 'SI';
    }else if($permiso == 'ELIMINAR'){
       $eliminar = 'SI';
      }else if($permiso == 'ANULAR'){
       $anular = 'SI';
      }else if($permiso == 'LEER'){
        $leer = 'SI';
      }
      
      if($permiso == 'ACTUALIZAR'){
        $actualizar = 'SI';
      }else if($permiso == 'ELIMINAR'){
        $eliminar = 'SI';
    }else if($permiso == 'ANULAR'){
      $anular = 'SI';
    }else if($permiso == 'LEER'){
      $leer = 'SI';
    }
    
    if($permiso == 'ELIMINAR'){
      $eliminar = 'SI';
    }else if($permiso == 'ANULAR'){
      $anular = 'SI';
    }else if($permiso == 'LEER'){
      $leer = 'SI';
    }
    
    if($permiso == 'ANULAR'){
      $anular = 'SI';
    }else if($permiso == 'LEER'){
      $leer = 'SI';
    }
    
    if($permiso == 'LEER'){
      $leer = 'SI';
    }
    
  }
  
  
  $usuario_id = $usuario['usuario_id'];
  $nombre     = $usuario['nombre'];
  $rol_id     = $usuario['rol_id'];
  
  $empresa = $empresaDAO->getDatosEmpresa();
  if($empresa>0){
    
    $razon_social = $empresa['razon_social'];
    $logo_empresa = $empresa['logo_empresa'];

  }
  session_name("datos");
  session_start();
  
  $_SESSION['usuario_id']=$usuario_id;
  $_SESSION['nombre']=$nombre;
  $_SESSION['rol_id']=$rol_id;
  $_SESSION['razon_social']=$razon_social;
  $_SESSION['logo_empresa']=$logo_empresa;

    $_SESSION['guardar']=$guardar;
    $_SESSION['actualizar']=$actualizar;
    $_SESSION['eliminar']=$eliminar;
    $_SESSION['anular']=$anular;
    $_SESSION['leer']=$leer;
   
    header("Location: ../inicio.php");
    
}else{
    ?>
    <!DOCTYPE html>
     
                            <html lang="es">
                                <head>
                                    <title>Login</title>
                                    <meta charset="UTF-8"> 
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" href="../frameworks/bootstrap/css/bootstrap.min.css">
                                    <link rel="stylesheet" href="../frameworks/bootstrap/css/bootstrap.css">
                                    <link rel="stylesheet" href="../styles/css/styleslogin.css">
                                    <script src="../frameworks/bootstrap/js/jquery.min.js"></script>
                                    <script src="../frameworks/bootstrap/js/bootstrap.js"></script>
                                    <script src="../frameworks/bootstrap/js/funciones.js"></script>
                                    <script type="text/javascript" src="../js/mensaje.js"></script>
 
                                </head>
                                <body class="imagenMsje"  onLoad="redireccionar()"> 


                               <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Lo sentimos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Usuario o contraseña incorrecta por favor vuelta a intentarlo!
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location='../index.php'">Volver</button>
                                       
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                      

                    

                                </body>
                                </html>
    <?php
 
}
       
?>