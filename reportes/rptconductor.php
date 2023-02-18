<?php
// Incluimos a la clase MC_TABLE
require ('mc_table.php');


$pdf = new PDF_MC_Table();

//Agregamos la primera pagina al documento
$pdf->AddPage();

//Seteamos el inicio del margen superio en 25 pixeles
$y_axis_initial = 30    ;

//Seteamos el tipo de letra y creamos el titulo de la pagina. No es un encabezado no se repetira
$pdf->SetFont('Arial','B','12');

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE CONDUCTORES',1,0,'C');
$pdf->Ln(10);

//Creamos las celdas para los titulos de cada columna le asignamos un fondo gris y un tipo de letra

$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(5,6,'Id',1,0,'C',1);
$pdf->Cell(30,6,'Nombres',1,0,'C',1);
$pdf->Cell(30,6,'Apellidos',1,0,'C',1);
$pdf->Cell(20,6,'T.I',1,0,'C',1);
$pdf->Cell(20,6,'Num ID',1,0,'C',1);
$pdf->Cell(30,6,'Email',1,0,'C',1);
$pdf->Cell(20,6,'Num Licencia',1,0,'C',1);
$pdf->Cell(12,6,'C.T',1,0,'C',1);
$pdf->Cell(12,6,'T.S',1,0,'C',1);
$pdf->Ln(10);

//Comenzamos a crear las filas de los registros segun la consulta mysql
require ("../class/db.class.php");
require ("../class/conductorDTO.php");
require ("../class/conductorDAO.php");
require ("../class/terceroDTO.php");
require ("../class/terceroDAO.php");

$terceroDTO = new terceroDTO();
$conductorDTO = new conductorDTO();
$conductorDAO = new conductorDAO();

$terceros = $conductorDAO->listarTercero();
$conductores = $conductorDAO->listarConductor();

      if ($terceros->num_rows and $conductores->num_rows) {
          //Implementamos las celdas de la tabla con los registors a mostrar
            $pdf->SetWidths(array(5,30,30,20,20,30,20,12,12));
                        while ($tercero = $terceros->fetch_object() and $conductor = $conductores->fetch_object()) {
                               $terceroDTO->mapear($tercero);
                               $conductorDTO->mapear($conductor);
                               
                               $id = $conductorDTO->getConductor_id();
                               $nombre = $terceroDTO->getPrimer_nombre()." ".$terceroDTO->getSegundo_nombre();
                               $apellido = $terceroDTO->getPrimer_apellido()." ".$terceroDTO->getSegundo_apellido();
                               $tipoIdentificacion = $tercero->nombre;
                               $numeroIdentificacion = $terceroDTO->getNumero_identificacion();
                               $email = $terceroDTO->getEmail();
                               $numLicencia = $conductorDTO->getNumero_licencia_cond();
                               $categoria = $conductor->categoria;
                               $tipoSangre =  $conductor->tipo_sangre;
                               
                               $pdf->SetFont('Arial','',7);
                               $pdf->Row(array($id,$nombre,$apellido,$tipoIdentificacion,$numeroIdentificacion,$email,$numLicencia,$categoria,$tipoSangre));
                        }
                        
                        //Mostramos nuestro PDF 
                        $pdf->Output();
      }





