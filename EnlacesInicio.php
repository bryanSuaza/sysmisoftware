<?php

require ("./class/db.class.php");

require ("./class/parqueaderoDTO.php");
require ("./class/parqueaderoDAO.php");

require ("./class/usuarioDTO.php");
require ("./class/usuarioDAO.php");

require ("./class/clienteDTO.php");
require ("./class/clienteDAO.php");

require ("./class/servicioDTO.php");
require ("./class/servicioDAO.php");

$parqueaderoDTO = new parqueaderoDTO();
$parqueaderoDAO = new parqueaderoDAO();

$usuarioDTO = new usuarioDTO();
$usuarioDAO = new usuarioDAO();

$clienteDTO = new clienteDTO();
$clienteDAO = new clienteDAO();

$servicioDTO = new servicioDTO();
$servicioDAO = new servicioDAO();

$conteoParqueadero = $parqueaderoDAO->contarParqueo();
$conteoUsuarios = $usuarioDAO->contarUsuarios();
$conteoClientes = $clienteDAO->contarClientes();
$conteoServicios = $servicioDAO->contarServicios();

?>


<!DOCTYPE html>

<html lang="es">
	
	<head>
		<title>Inicio</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles/css/styles.css">
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	</head>
	<body>
	<div class="container">

	    <div class="row">
				<div class="col-md-3 text-center">
                   <div class="conteo_usuarios">
					   Usuarios
					   <br>
					   <?php
                         if ($conteoUsuarios != "") {
							 $lista = mysqli_fetch_array($conteoUsuarios);
                             echo $lista['usuarios'];	 
						 }
					   ?>
				   </div>
				</div>
				<div class="col-md-3 text-center">
				   <div class="conteo_clientes">
						Clientes
						<br>
					   <?php
                         if ($conteoClientes != "") {
							 $lista = mysqli_fetch_array($conteoClientes);
                             echo $lista['clientes'];	 
						 }
					   ?>
				   </div>
				</div>
				<div class="col-md-3 text-center">
                   <div class="conteo_servicios">
						Servicios
						<br>
						<?php
							if ($conteoServicios != "") {
								$lista = mysqli_fetch_array($conteoServicios);
								echo $lista['servicios'];	 
							}
						?>
				   </div>
				</div>
				<div class="col-md-3 text-center">
                   <div class="conteo_parqueadero">
						Vehiculos Parqueadero
						<br>
						<?php
							if ($conteoParqueadero != "") {
								$lista = mysqli_fetch_array($conteoParqueadero);
								echo $lista['parqueos'];	 
							}
						?>
				   </div>
				</div>
		</div>


		<div class="row">
				<div class="col-md-6 text-center">
				  <div class="cuadroEnlance">
				  	<div class=imgEnlace>
                        <img src="images/verServices.jpg" width="200"  height="150"><br>
                    </div>
                    <div class="alignBtn">
                    	<a href="?page=reporteReservas" class="btn btn-primary">VER SERVICIOS</a>
                    </div>
				  </div>
				</div>
				<div class="col-md-6 text-center">
				  <div class="cuadroEnlance">
                     <div class=imgEnlace>
                        <img src="images/verUsers.jpg" width="200"  height="150">
                    </div>
                    <div class="alignBtn">
                    	<a href="?page=listaUsuarios" class="btn btn-primary">VER USUARIOS</a>
                    </div>
				  </div>
				</div>
		</div>
       <hr>
		<div class="row">
				<div class="col-md-6 text-center">
				  <div class="cuadroEnlance">
                     <div class=imgEnlace>
                        <img src="images/verClient.jpg" width="200"  height="150">
                    </div>
                    <div class="alignBtn">
                    	<a href="?page=listaClientes" class="btn btn-primary">VER CLIENTES</a>
                    </div>
				  </div>
				</div>
				<div class="col-md-6 text-center">
				  <div class="cuadroEnlance">
                     <div class=imgEnlace>
                        <img src="images/vehiculoparking.jpg" width="200"  height="150">
                    </div>
                    <div class="alignBtn">
                    	<a href="?page=listaVehiculos" class="btn btn-primary">VER PARQUEADERO</a>
                    </div>
				  </div>
				</div>
		</div>
	</div>
    </body>
    </html>