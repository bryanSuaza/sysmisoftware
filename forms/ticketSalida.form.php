<?php

require_once("../class/db.class.php");
require_once("../class/parqueaderoDAO.php");

$placa = filter_input(INPUT_GET, "placa", FILTER_SANITIZE_STRING);
$codigo_ticket = filter_input(INPUT_GET, "codigo_ticket", FILTER_SANITIZE_STRING);

$parqueaderoDAO = new parqueaderoDAO(); 

if($placa != ''){
  $datosParqueo = $parqueaderoDAO->getDatosParqueoSalida($placa);
}else if($codigo_ticket != ''){
  $datosParqueo = $parqueaderoDAO->getDatosParqueoSalidaBoton($codigo_ticket);
}

$datosEmpresa = $parqueaderoDAO->getDatosEmpresa();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Impresion de ticket salida</title>
        <link media='screen' type='text/css' href='../styles/css/impresion.css' rel='stylesheet' />
        <link media='print'  type='text/css'  href='../styles/css/impresion.css' rel='stylesheet' />
	</head>
	<body onLoad="javascript:window.print()">
    <p><?php echo $datosEmpresa[0]['razon_social'] ?></p>
    <p>NIT: <?php echo $datosEmpresa[0]['numero_identificacion']."-".$datosEmpresa[0]['digito_verificacion'] ?></p>
    
    <?php 
      if($datosEmpresa[0]['camara_comercio'] != '' || $datosEmpresa[0]['camara_comercio'] != null){
    ?>
      <p>C COMERCIO:<?php echo $datosEmpresa[0]['camara_comercio']?> <p>
    <?php
     }
    ?>

    <p>TEL: <?php echo $datosEmpresa[0]['telefono']?></p>
    <p>UBI: <?php echo $datosEmpresa[0]['ubicacion']?></p>
    <p>DIR: <?php echo $datosEmpresa[0]['direccion']?></p>
    <p><?php echo $datosEmpresa[0]['pagina']?></p>
    <p>------------------------------</p>
    <p>PLACA: <?php echo $datosParqueo[0]['placa']?></p>
    <p>TICKET: <?php echo $datosParqueo[0]['codigo_ticket']?></p>
    <p>TIPO VEHICULO: <?php echo $datosParqueo[0]['tipo_vehiculo']?></p>
    <p>FEC INGR: <?php echo $datosParqueo[0]['fecha_hora_ingreso']?></p>
    <p>FEC SALI: <?php echo $datosParqueo[0]['fecha_hora_salida']?></p>
    <p><?php echo $datosParqueo[0]['descripcion']?></p>
    <p>------------------------------</p>
    <p>HORAS: <?php echo $datosParqueo[0]['horas']?></p>

    <?php 
      if($datosParqueo[0]['medios_dias'] != '' || $datosParqueo[0]['medios_dias'] != null){
    ?>
      <p>MEDIOS DIAS: <?php echo $datosParqueo[0]['medios_dias']?> <p>
    <?php
     }
    ?>

    <?php 
      if($datosParqueo[0]['dias'] != '' || $datosParqueo[0]['dias'] != null){
    ?>
      <p>DIAS: <?php echo $datosParqueo[0]['dias']?> <p>
    <?php
     }
    ?>

    <p>VALOR SERVICIO: $<?php echo number_format($datosParqueo[0]['valor_servicio'],0,",",".");?></p>
    <p>Sistema: Sysmisoftware</p>
    </body>

</html>