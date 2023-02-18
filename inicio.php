<?php


$page= filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);

switch ($page) {
    case 'inicio':
        $openPage = "inicio.php";
        break;
    case 'crearRol':
        $openPage = "forms/rol.form.php";
        break;
    case 'crearUsuario':
        $openPage = "forms/usuario.form.php";
        break;  
    case 'crearEmpresa':
        $openPage = "forms/empresa.form.php";
        break;  
    case 'crearCategoria':
        $openPage = "forms/categoria.form.php";
        break;
    case 'crearHabitacion':
        $openPage = "forms/habitacion.form.php";
        break;
    case 'crearProducto':
        $openPage = "forms/producto.form.php";
        break;
    case 'crearCliente':
       $openPage = "forms/cliente.form.php";
        break; 
    case 'crearTarifa':
       $openPage = "forms/tarifaParqueadero.form.php";
        break;
    case 'crearTipoVehiculo':
       $openPage = "forms/tipoVehiculo.form.php";
        break; 
    case 'crearServicio':
       $openPage = "forms/servicio.form.php";
        break;
    case 'crearFactura':
       $openPage = "forms/factura.form.php";
        break;
    case 'ingresarVehiculo':
       $openPage = "forms/parqueadero.form.php";
        break;
     case 'salidaVehiculo':
       $openPage = "forms/salidaParqueadero.form.php";
        break;
    case 'reporteReservas':
       $openPage = "list/reporteServicios.list.php";
        break;
    case 'listaUsuarios':
       $openPage = "list/usuario.list.php";
        break;
    case 'listaClientes':
       $openPage = "list/clientes.list.php";
        break;
    case 'listaVehiculos':
       $openPage = "list/parqueadero.list.php";
        break;
    case 'reporteParqueadero':
       $openPage = "list/reporteParqueadero.list.php";
        break;
    default:
        $openPage = "EnlacesInicio.php";
        break;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Mi Software</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="frameworks/jquery/jquery-3.5.1.min.js"></script>
    <script src="frameworks/bootstrap/js/jquery.min.js"></script>
    <script src="frameworks/jquery-ui/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="frameworks/jquery-ui/jquery-ui-1.12.1.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="frameworks/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="frameworks/bootstrap-toggle/css/bootstrap4-toggle.min.css">
        <link rel="stylesheet" href="librerias/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="librerias/sweetalert2/package/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="styles/css/styles.css">
        <link rel="stylesheet" type="text/css" href="librerias/datetimepicker-master/jquery.datetimepicker.css"/ >

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="sidebar/sidebar-01/css/style.css">
</head>

<body>
     <?php
        session_name("datos");
        session_start();

        if (!isset($_SESSION["nombre"]) && !isset($_SESSION["rol_id"])) {
            header("Location: index.php");
        }
        ?>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                
                <a href="#" class="img logo rounded-circle mb-5">
                    <?php 
                    if($_SESSION["logo_empresa"] != ''){
                    ?>
                         <img id="imagen_user" src="process/img_uploads/<?php echo $_SESSION["logo_empresa"]?>" height="130" width="130"/> 
                    <?php
                    }else{
                    ?>
                        <img id="imagen_user" src="process/img_uploads/usuario.png" height="130"/>
                    <?php
                    }
                    ?>
                </a>
                <b style='font-family: Arial Black; text-align:center;  display:block'> 
                USUARIO
                </b>
                <?php echo "<h6 style=' text-shadow: 0px 0px 9px #BBB; display: block; text-align: center;'>".$_SESSION["nombre"]."</h6>";?>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="inicio.php"><i class="fa fa-home"></i> Inicio</a>
                    </li>
                    <li class="active">
                        <a href="#parametros_sistema" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-gift fa-lg"></i> Parametros Sistema</a>
                        <ul class="collapse list-unstyled" id="parametros_sistema">
                            <li class="active"><a href="?page=crearRol"><i class="fa fa-gears"></i> Crear Rol</a></li>
                            <li class="active"><a href="?page=crearUsuario"><i class="fa fa-user"></i> Crear Usuario</a></li>
                            <li><a href="?page=crearEmpresa"><i class="fa fa-archive"></i> Datos Empresa</a></li>
                            <li><a href="?page=listaUsuarios"><i class="fa fa-user"></i> Reporte Usuarios</a></li>
                        </ul>
                    </li>
                     <!-- <li>
                        <a href="#inventario" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-handshake-o"></i> Inventario y Ventas</a>
                        <ul class="collapse list-unstyled" id="inventario">
                            <li><a href="?page=crearCategoria"><i class="fa fa-level-up"></i> Crear Categoria</a></li>
                            <li><a href="?page=crearProducto"><i class="fa fa-product-hunt"></i> Crear Producto</a></li>
                            <li><a href="?page=crearCliente"><i class="fa fa-user-plus"></i> Crear cliente</a></li>
                            <li><a href="?page=crearFactura"><i class="fa fa-file-text"></i> Factura</a></li>
                            <li><a href="?page=listaClientes"><i class="fa fa-address-card"></i> Reporte Clientes</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#hotel" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-h-square"></i> Servicio Hotel</a>
                        <ul class="collapse list-unstyled" id="hotel">
                            <li><a href="?page=crearHabitacion"><i class="fa fa-image"></i> Crear Habitación</a></li>
                            <li><a href="?page=crearCliente"><i class="fa fa-user-plus"></i> Crear cliente</a></li>
                            <li><a href="?page=crearServicio"><i class="fa fa-book"></i> Servicio</a></li>
                            <li><a href="?page=crearFactura"><i class="fa fa-file-text"></i> Factura</a></li>
                            <li><a href="?page=listaClientes"><i class="fa fa-address-card"></i> Reporte Clientes</a></li>
                            <li><a href="?page=reporteReservas"><i class="fa fa-table"></i>  Reporte Servicios</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a href="#parqueadero" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-motorcycle"></i> Parqueaderos</a>
                        <ul class="collapse list-unstyled" id="parqueadero">
                            <li><a href="?page=crearTipoVehiculo"><i class="fa fa-th-list"></i> Tipos De Vehiculos</a></li>
                            <li><a href="?page=crearTarifa"><i class="fa fa-money"></i> Tarifas Parqueadero</a></li>
                            <li><a href="?page=ingresarVehiculo"><i class="fa fa-car"></i> Ingreso Parqueadero</a></li>
                            <li><a href="?page=salidaVehiculo"><i class="fa fa-car"></i> Salida Parqueadero</a></li>
                            <li><a href="?page=listaVehiculos"><i class="fa fa-braille"></i>Lista Vehiculos</a></li>
                            <li><a href="?page=reporteParqueadero"><i class="fa fa-braille"></i> Reporte</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="footer">
                <h3><div style="color:#939393">Sysmisoftware</div></h3>
                </div>

            </div>
        </nav>

        <div class="row">

        <!-- Page Content  -->
        <div id="content" class="p-1 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

                   
                        <ul class="nav navbar-nav ml-auto">
                             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <div style="text-align: center;  width: auto; margin-right:20px;" >
                                        <?php if($_SESSION["razon_social"] != ''){
                                           echo "<h3 style='text-shadow: 0px 0px 9px #B9B9B9; color:#606060'>".$_SESSION["razon_social"]."</h3>"; 
                                        }?>
                                    </div>
                            <button class="btn btn-info" onclick="window.location='cerrarSesion.php'"><i class="fa fa-sign-out" style="font-size:24px;" aria-hidden="true"></i>
                            </button>
                        </ul>
                    </div>
                </div>
            </nav>

            
            <div id="content" class="p-1 p-md-5">
                <div id="contenedor" class="contenedor">
                       <?php
                       require($openPage); 
                       ?>
               </div>
            </div>

            </div>
            
        </div>
    </div>


</body>

<script src="frameworks/bootstrap/js/bootstrap.min.js"></script>
<script src="frameworks/bootstrap/js/bootstrap.js"></script>
<script src="frameworks/bootstrap-toggle/js/bootstrap4-toggle.min.js"></script>
<script src="frameworks/bootstrap/js/jquery.dataTables.min.js"></script>
<script src="frameworks/bootstrap/js/dataTables.bootstrap4.min.js"></script>
<script src="frameworks/bootstrap/js/dataTables.buttons.min.js"></script>
<script src="frameworks/bootstrap/js/dataTables.fixedHeader.min.js"></script>
<script src="frameworks/bootstrap/js/dataTables.responsive.min.js"></script>
<script src="frameworks/bootstrap/js/responsive.bootstrap.min.js"></script>
<script src="frameworks/bootstrap/js/jszip.min.js"></script>
<script src="frameworks/bootstrap/js/pdfmake.min.js"></script>
<script src="frameworks/bootstrap/js/vfs_fonts.js"></script>
<script src="frameworks/bootstrap/js/buttons.html5.min.js"></script>
<script src="frameworks/bootstrap/js/popper.min.js"></script>
<script src="frameworks/bootstrap/js/popper.js"></script>
<script src="librerias/sweetalert2/package/dist/sweetalert2.all.min.js"></script>
<script src="librerias/sweetalert2/package/dist/sweetalert2.min.js"></script>
<script src="sidebar/sidebar-01/js/main.js"></script>
<script src="librerias/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>

</html>