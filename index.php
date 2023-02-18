
<!DOCTYPE html>

<html lang="es">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="frameworks/bootstrap/css/bootstrap.css">  
        <link rel="stylesheet" href="styles/css/styleslogin.css">
        <link rel="stylesheet" href="styles/css/animate.css">
        
    </head>
    <body>
        <div class="container">
        	<div class="row">
    
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
            	<div class="animated zoomIn">
            	<div class="login">
                 <form class="form-group" action="process/login.process.php" method="post">
                        <div style="text-align:center">
                        <img src="images/logo.jpg" height="100" width="100">
                        </div>
                        <h4  class="animated rubberBand" style="text-align:center"><b>INICIAR SESI&Oacute;N</b></h4>
                        <br> 
                        <div class="espacio">
                            <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Nombre de usuario" required> 
                        </div>
                        <div>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>  
                        </div>
                        <br>
                        <button class="btn btn-success" type="submit" id="iniciar">Iniciar Sesión</button>
                        <br><br>
                        <h5 class="animated rubberBand" style="text-align:center; color: #868686">www.sysmisoftware.com</h5>

                </form>

                </div>
            </div>  
            </div>
            <div class="col-md-3">
            </div>
            
           </div> 
        </div>

        <script src="framworks/bootstrap/js/jquery.min.js"></script>
        <script src="framewroks/bootstrap/js/bootstrap.js"></script>
        <script src="framwworks/bootstrap/js/funciones.js"></script>
        <script type="text/javascript" src="js/mensaje.js"></script>

    </body>
    
</html>
 
