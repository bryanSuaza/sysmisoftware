<?php

class parqueaderoDAO extends db{
   
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

    
    public function ingresarParqueadero(parqueaderoDTO $parqueadero){
         
        
        $codigo_ticket = $parqueadero->getCodigo_ticket();
        $placa = strtoupper($parqueadero->getPlaca());
        $tipo_vehiculo_id = $parqueadero->getTipo_vehiculo_id();
        $fecha_hora_ingreso = $parqueadero->getFecha_hora_ingreso();
        $descripcion = $parqueadero->getDescripcion();
        $parqueadero_id = $this->getMaxId('parqueadero','parqueadero_id');

        $usuario_id = $_REQUEST['usuario_id'];

        $por_horas = $_REQUEST['por_horas'];
        $por_medio = $_REQUEST['por_medio'];
        $por_dia = $_REQUEST['por_dia'];
        $por_mes = $_REQUEST['por_mes'];
        
        if($por_mes=='true'){

             $fecha_hora_salida = $parqueadero->getFecha_hora_salida();
             $tipo_servicio = "mensual";

               $sql = "SELECT valor_mes FROM tarifas_parqueadero WHERE tipo_vehiculo_id=$tipo_vehiculo_id AND estado='A' ORDER BY tarifas_parqueadero_id DESC LIMIT 1";
               $result_tarifas = $this->query($sql);
            
               if (mysqli_num_rows($result_tarifas)>0){

                    if($row_tarifas = mysqli_fetch_assoc($result_tarifas)){
                        $valor_servicio=$row_tarifas['valor_mes'];
                    }
                }

        }else if($por_horas=='true'){

               $tipo_servicio = "por horas";
               $valor_servicio = 0;

        }else if($por_medio=='true'){

               $tipo_servicio = "por medio dia";
               $valor_servicio = 0;

        }else if($por_dia == 'true'){

                $tipo_servicio = "por dia";
                $valor_servicio = 0;

        }

        date_default_timezone_set('America/Bogota');
        $fecha_registro =  date("Y-m-d H:i:s");

        $select="SELECT placa FROM parqueadero WHERE placa = '$placa' AND estado ='A'";
        $result=$this->query($select);

        if(mysqli_num_rows($result)>0){
            return 2;
        }else{

            $select="SELECT codigo_ticket FROM parqueadero WHERE codigo_ticket = $codigo_ticket";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                return 3;

            }else{

                if($por_mes=='true'){
                    $sql="INSERT INTO parqueadero (parqueadero_id,codigo_ticket,placa,tipo_vehiculo_id,fecha_hora_ingreso,fecha_hora_salida,descripcion,valor_servicio,estado,tipo_servicio,usuario_id,fecha_registro)
                            VALUES ($parqueadero_id,$codigo_ticket,'$placa',$tipo_vehiculo_id,'$fecha_hora_ingreso','$fecha_hora_salida','$descripcion',$valor_servicio,'A','$tipo_servicio',$usuario_id,'$fecha_registro')";
                }else{
                    $sql="INSERT INTO parqueadero (parqueadero_id,codigo_ticket,placa,tipo_vehiculo_id,fecha_hora_ingreso,descripcion,valor_servicio,estado,tipo_servicio,usuario_id,fecha_registro)
                            VALUES ($parqueadero_id,$codigo_ticket,'$placa',$tipo_vehiculo_id,'$fecha_hora_ingreso','$descripcion',$valor_servicio,'A','$tipo_servicio',$usuario_id,'$fecha_registro')";
                }

                $result=$this->query($sql);
                    
                    if($result>0){
                        return 1;
                    }else{
                        throw new Exception("No se pudo ingresar el registro, el motivo: ".$this->error);
                    }
            }
        }
    }

    public function actualizarParqueadero(parqueaderoDTO $parqueadero){

        $parqueadero_id = $parqueadero->getParqueadero_id();
        $placa = $parqueadero->getPlaca();
        $tipo_vehiculo_id = $parqueadero->getTipo_vehiculo_id();
        $fecha_hora_ingreso = $parqueadero->getFecha_hora_ingreso();
        $fecha_hora_salida = $parqueadero->getFecha_hora_salida();
        $estado = $parqueadero->getEstado();
        $descripcion = $parqueadero->getDescripcion();
        $valor_servicio = $parqueadero->getValor_servicio();

        $usuario_actualiza_id = $_REQUEST['usuario_id'];

        $por_mes = $_REQUEST['por_mes'];
        $por_horas = $_REQUEST['por_horas'];
        $por_dia = $_REQUEST['por_dia'];
        $por_medio = $_REQUEST['por_medio'];

        if($por_mes=='true'){

               $tipo_servicio = "mensual";

               $sql = "SELECT valor_mes FROM tarifas_parqueadero WHERE tipo_vehiculo_id=$tipo_vehiculo_id AND estado='A' ORDER BY tarifas_parqueadero_id DESC LIMIT 1";
               $result_tarifas = $this->query($sql);
            
               if (mysqli_num_rows($result_tarifas)>0){

                    if($row_tarifas = mysqli_fetch_assoc($result_tarifas)){
                        $valor_servicio=$row_tarifas['valor_mes'];
                    }
                }

        }else if($por_horas == 'true'){
               $tipo_servicio = "por horas";
        }else if($por_medio == 'true'){
               $tipo_servicio = "por medio dia";
        }else if($por_dia == 'true'){
               $tipo_servicio = "por dia";
        }

        date_default_timezone_set('America/Bogota');
        $fecha_actualiza =  date("Y-m-d H:i:s");

        if($valor_servicio == ''){
            $valor_servicio = 0;
        }

                $update="UPDATE parqueadero SET placa='$placa',tipo_vehiculo_id=$tipo_vehiculo_id,fecha_hora_ingreso='$fecha_hora_ingreso',fecha_hora_salida='$fecha_hora_salida',estado='$estado',tipo_servicio='$tipo_servicio',descripcion='$descripcion',valor_servicio=$valor_servicio,usuario_actualiza_id=$usuario_actualiza_id,fecha_actualiza='$fecha_actualiza'
                         WHERE parqueadero_id=$parqueadero_id";
                         
                $result=$this->query($update);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo actualizar el servicio de parqueadero, el motivo: ".$this->error);
                }
        
    }


    public function eliminarParqueadero(parqueaderoDTO $parqueadero){

            $parqueadero_id = $parqueadero->getParqueadero_id();

            $select="SELECT parqueadero_id FROM parqueadero WHERE parqueadero_id = $parqueadero_id";
            $result=$this->query($select);

            if(mysqli_num_rows($result)>0){

                $sql="DELETE FROM parqueadero WHERE parqueadero_id=$parqueadero_id";
                $result=$this->query($sql);
                
                if($result>0){
                        return 1;
                }else{
                    throw new Exception("No se pudo eliminar el servicio de parqueadero, el motivo: ".$this->error);
                }

            }else{
                    throw new Exception("No se pudo eliminar el servicio de parqueadero ya que no existe, el motivo: ".$this->error);
            }
            
    }

        public function getTipo_vehiculo(){  
                 
            $sql = "SELECT tipo_vehiculo_id, tipo FROM tipo_vehiculo WHERE estado = 'A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                return 0;        
            } 
        } 

        public function getCodigo_ticket(){  
                 
            $sql = "SELECT MAX(codigo_ticket)AS codigo_ticket FROM parqueadero ORDER BY parqueadero_id DESC";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                if($row = mysqli_fetch_assoc($result)){
                  $codigo_ticket=$row['codigo_ticket']+1;
                }
                return $codigo_ticket;
            }else{            
                return 1;        
            } 
        }


        public function salidaParqueadero(parqueaderoDTO $parqueadero){

            $placa = $parqueadero->getPlaca();
            
            date_default_timezone_set('America/Bogota');
            $fecha_hora_salida =  date("Y-m-d H:i:s");

            $sql = "SELECT p.placa,
                           p.codigo_ticket,
                           p.tipo_vehiculo_id,
                           (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                           p.fecha_hora_ingreso,
                           p.tipo_servicio
                        
                    FROM parqueadero p WHERE p.placa='$placa' AND p.estado='A' ORDER BY p.parqueadero_id DESC";
                    
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){

                if($row = mysqli_fetch_assoc($result)){

                  $placa=$row['placa'];
                  $codigo_ticket=$row['codigo_ticket'];
                  $tipo_vehiculo_id=$row['tipo_vehiculo_id'];
                  $tipo_vehiculo=$row['tipo_vehiculo'];
                  $fecha_hora_ingreso=$row['fecha_hora_ingreso'];
                  $tipo_servicio=$row['tipo_servicio'];
        
                }

                $sql = "SELECT tipo_vehiculo_id,
                               valor_hora_diurna,
                               valor_hora_nocturna,
                               valor_medio_dia,
                               valor_dia,
                               valor_mes,
                               tiempo_cobro
                        
                    FROM tarifas_parqueadero WHERE tipo_vehiculo_id=$tipo_vehiculo_id AND estado='A' ORDER BY tarifas_parqueadero_id DESC";
                
                $result_tarifas = $this->query($sql);
            
               if (mysqli_num_rows($result_tarifas)>0){

                 if($row_tarifas = mysqli_fetch_assoc($result_tarifas)){
                     
                     $tipo_vehiculo_id=$row_tarifas['tipo_vehiculo_id'];
                     $valor_hora_diurna=$row_tarifas['valor_hora_diurna'];
                     $valor_hora_nocturna=$row_tarifas['valor_hora_nocturna'];
                     $valor_medio_dia=$row_tarifas['valor_medio_dia'];
                     $valor_dia=$row_tarifas['valor_dia'];
                     $valor_mes=$row_tarifas['valor_mes'];
                     $tiempo_cobro=$row_tarifas['tiempo_cobro'];
                     
                    }
                    
                    //aqui comenzamos a hacer los calculos de la funcion de tarifas
                    $horas=0;
                    $horas = abs(floor((strtotime($fecha_hora_salida) - strtotime($fecha_hora_ingreso))/(60*60)));
                    
                    
                    $select="SELECT DATE_FORMAT('$fecha_hora_salida', '%H')AS hora_actual";
                    $result = $this->query($select);
                    
                    if (mysqli_num_rows($result)>0){
                        if($row = mysqli_fetch_assoc($result)){
                            
                            $hora_actual=$row['hora_actual'];
                            $hora_salida_actual = "$hora_actual:00:00";
                            
                            
                            if($hora_actual <= 19){
                                $zona_horaria = 'dia';
                            }else if($hora_actual >= 19){
                                $zona_horaria = 'noche';
                            }
                            
                        }
                    }
                    
                    $instante = date("H:i:s");
                    
                    $minutos = (strtotime($instante)-strtotime($hora_salida_actual))/60;
                    $minutos = abs(floor($minutos));
                    
                    //exit("horas: ".$horas);
                    
                    if($minutos>=0){

                        $tiempo_transcurrido = 0;
                        $hora_aumento=0;

                        $tiempo_transcurrido = abs(floor((strtotime($fecha_hora_salida) - strtotime($fecha_hora_ingreso))/60));
                        //exit("tiempo_transcurrido: ".$tiempo_transcurrido);

                        for($i=0; $i<24; $i++){

                            $hora_aumento=$hora_aumento+(60*$horas);
                            
                            if($tiempo_transcurrido>$hora_aumento){
                                
                                $tiempo_transcurrido = $tiempo_transcurrido-$hora_aumento;
                                
                                if($tiempo_transcurrido>$tiempo_cobro){
                                    $horas = $horas + 1;
                                    //exit("tiempo_transcurrido: ".$tiempo_transcurrido." horas: ".$horas);
                                }else{
                                    $i = 24;
                                }

                            }else{

                                if($tiempo_transcurrido>$tiempo_cobro && $i==0){
                                   $horas = $horas + 1; 
                                }

                                $i = 24;

                            }

                        }

                        
                    }

                //si el tipo de servicio es por horas
                if($tipo_servicio == 'por horas'){
                    
                    if($horas < 6){
                            if($zona_horaria=='dia'){
                                $valor_servicio = $horas * $valor_hora_diurna;
                            }else{
                                $valor_servicio = $horas * $valor_hora_nocturna;
                            }   
                        $dias = 0; 
                        $medios_dias = 0;  
    
                     }else if($horas >= 6 && $horas < 12){
                         $horas = $horas - 6;
                         if($zona_horaria=='dia'){
                             $valor_servicio = abs($valor_medio_dia + ($horas * $valor_hora_diurna));
                         }else{
                             $valor_servicio = abs($valor_medio_dia + ($horas * $valor_hora_nocturna));
                         }
    
                        $dias = 0; 
                        $medios_dias = 1;  
                     }else if($horas >= 12 && $horas < 18){
                          $horas = $horas - 12;
                          if($zona_horaria=='dia'){
                             $valor_servicio = abs($valor_dia + ($horas * $valor_hora_diurna));
                             
                          }else{
                             $valor_servicio = abs($valor_dia + ($horas * $valor_hora_nocturna));
                          }
                          $dias = 1; 
                          $medios_dias = 0; 
                     }else if($horas >= 18 && $horas < 24){
                         $horas = $horas - 18;
                         if($zona_horaria=='dia'){
                             $valor_servicio = abs(($valor_dia+$valor_medio_dia)+($horas * $valor_hora_diurna));
                         }else{
                             $valor_servicio = abs(($valor_dia+$valor_medio_dia)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 1; 
                         $medios_dias = 1; 
                     }else if($horas >= 24 && $horas < 30){
                         $horas = $horas - 24;
                         if($zona_horaria=='dia'){
                             $valor_servicio = abs(($valor_dia*2)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*2)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 2; 
                         $medios_dias = 0; 
                     }else if($horas >= 30 && $horas < 36){
                         $horas = $horas - 30;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*2)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*2)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 2; 
                         $medios_dias = 1; 
                     }else if($horas >= 36 && $horas < 42){
                         $horas = $horas - 36;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*3)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*3)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 3; 
                         $medios_dias = 0; 
                     }else if($horas >= 42 && $horas < 48){
                         $horas = $horas - 42;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*3)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*3)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 3; 
                         $medios_dias = 1; 
                     }else if($horas >= 48 && $horas < 54){
                         $horas = $horas - 48;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*4)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*4)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 4; 
                         $medios_dias = 0; 
                     }else if($horas >= 54 && $horas < 60){
                         $horas = $horas - 54;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*4)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*4)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 4; 
                         $medios_dias = 1; 
                     }else if($horas >= 60 && $horas < 66){
                         $horas = $horas - 60;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*5)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*5)+($horas * $valor_hora_nocturna));
                         }
                          $dias = 5; 
                         $medios_dias = 0; 
                     }else if($horas >= 66 && $horas < 72){
                         $horas = $horas - 66;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*5)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*5)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 5; 
                         $medios_dias = 1; 
                     }else if($horas >= 72 && $horas < 76){
                         $horas = $horas - 72;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*6)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*6)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 6; 
                         $medios_dias = 0; 
                     }else if($horas >= 76 && $horas < 82){
                         $horas = $horas - 76;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*6)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*6)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 6; 
                         $medios_dias = 1; 
                     }else if($horas >= 82 && $horas < 88){
                         $horas = $horas - 82;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*7)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*7)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 7; 
                         $medios_dias = 0; 
                     }else if($horas >= 88 && $horas < 94){
                         $horas = $horas - 88;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*7)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*7)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 7; 
                         $medios_dias = 1; 
                     }else if($horas >= 94 && $horas < 100){
                         $horas = $horas - 94;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*8)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*8)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 8; 
                         $medios_dias = 0; 
                     }else if($horas >= 100 && $horas < 106){
                         $horas = $horas - 100;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*8)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*8)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 8; 
                         $medios_dias = 1; 
                     }else if($horas >= 106 && $horas < 112){
                         $horas = $horas - 106;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*9)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*9)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 9; 
                         $medios_dias = 0; 
                     }else if($horas >= 112 && $horas < 118){
                         $horas = $horas - 112;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*9)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*9)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 9; 
                         $medios_dias = 1; 
                     }else if($horas >= 118 && $horas < 124){
                         $horas = $horas - 118;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*10)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*10)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 10; 
                         $medios_dias = 0; 
                     }else if($horas >= 124 && $horas < 130){
                         $horas = $horas - 124;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*10)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*10)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 10; 
                         $medios_dias = 1; 
                     }else if($horas >= 130 && $horas < 136){
                         $horas = $horas - 130;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*11)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*11)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 11; 
                         $medios_dias = 0; 
                     }else if($horas >= 136 && $horas < 142){
                         $horas = $horas - 136;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*11)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*11)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 11; 
                         $medios_dias = 1; 
                     }else if($horas >= 142 && $horas < 148){
                         $horas = $horas - 142;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*12)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*12)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 12; 
                         $medios_dias = 0; 
                     }else if($horas >= 148 && $horas < 154){
                         $horas = $horas - 148;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*12)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*12)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 12; 
                         $medios_dias = 1; 
                     }else if($horas >= 154 && $horas < 160){
                         $horas = $horas - 154;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*13)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*13)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 13; 
                         $medios_dias = 0; 
                     }else if($horas >= 160 && $horas < 166){
                         $horas = $horas - 160;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*13)+$valor_medio_dia+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*13)+$valor_medio_dia+($horas * $valor_hora_nocturna));
                         }
                         $dias = 13; 
                         $medios_dias = 1; 
                     }else if($horas >= 166 && $horas < 172){
                         $horas = $horas - 166;
                         if($zona_horaria=='dia'){
                            $valor_servicio = abs(($valor_dia*14)+($horas * $valor_hora_diurna));
                         }else{
                            $valor_servicio = abs(($valor_dia*14)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 14; 
                         $medios_dias = 0; 
                     }else{
                         $valor_servicio=abs(($horas*$valor_hora_diurna));
                         $dias = round($horas/24);
                         $medios_dias = abs($dias*2);
                     }
 
                //si el tipo de servicio es por medio dia
                }else if($tipo_servicio == 'por medio dia'){

                    if($horas <= 6){
                            
                        $valor_servicio = abs($valor_medio_dia);
                            
                        $dias = 0; 
                        $medios_dias = 1;  
    
                     }else if($horas > 6){
                         $horas = $horas - 6;
                         if($zona_horaria=='dia'){
                             $valor_servicio = abs($valor_medio_dia + ($horas * $valor_hora_diurna));
                         }else{
                             $valor_servicio = abs($valor_medio_dia + ($horas * $valor_hora_nocturna));
                         }
    
                        $dias = 0; 
                        $medios_dias = 1;  
                     }
                    
                //si el tipo de servicio es por dia
                }else if($tipo_servicio == 'por dia'){

                    if($horas <= 12){
                          
                        $valor_servicio = abs($valor_dia);
                        
                        $dias = 1; 
                        $medios_dias = 0; 

                    }else if($horas > 12){
                         $horas = $horas - 12;
                         if($zona_horaria=='dia'){
                             $valor_servicio = abs(($valor_dia)+($horas * $valor_hora_diurna));
                         }else{
                             $valor_servicio = abs(($valor_dia)+($horas * $valor_hora_nocturna));
                         }
                         $dias = 1; 
                         $medios_dias = 0; 
                     }

                //si el tipo de servicio es mensual
                }else if($tipo_servicio =='mensual'){

                    return 4;

                }


               }else{
                   return 3;
               }

               if($zona_horaria=='dia'){
                   $data[0]['valor_hora']=$valor_hora_diurna;
               }else{
                  $data[0]['valor_hora']=$valor_hora_nocturna;
               }

               $data[0]['codigo_ticket']=$codigo_ticket;
               $data[0]['tipo_vehiculo_id']=$tipo_vehiculo_id;
               $data[0]['fecha_hora_ingreso']=$fecha_hora_ingreso;
               $data[0]['fecha_hora_salida']=$fecha_hora_salida;
               $data[0]['horas']=$horas;
               $data[0]['dias']=$dias;
               $data[0]['medios_dias']=$medios_dias;
               $data[0]['valor_servicio']=$valor_servicio;
        
               return $data;


            }else{            
                return 2;        
            } 


        }

    public function actualizarServicio(parqueaderoDTO $parqueadero){

    
        $codigo_ticket = $parqueadero->getCodigo_ticket();
        $fecha_hora_salida = $parqueadero->getFecha_hora_salida();
        $valor_servicio = $parqueadero->getValor_servicio();
        $horas = $parqueadero->getHoras();
        $dias = $parqueadero->getDias();
        $medios_dias = $parqueadero->getMediosDias();

        if($valor_servicio == ''){
            $valor_servicio = 0;
        }

        $update="UPDATE parqueadero SET fecha_hora_salida='$fecha_hora_salida',estado='F',valor_servicio=$valor_servicio,horas='$horas',dias='$dias',medios_dias='$medios_dias'
                 WHERE codigo_ticket=$codigo_ticket AND estado='A'";
                         
        $result=$this->query($update);
                
        if($result>0){
            return 1;
        }else{
            throw new Exception("No se pudo actualizar el servicio de parqueadero, el motivo: ".$this->error);
        }
        
    }

    public function getDatosParqueo($placa){

        $sql = "SELECT  p.placa,
                        p.codigo_ticket,
                        (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                        p.fecha_hora_ingreso,
                        p.fecha_hora_salida,
                        p.descripcion,
                        p.valor_servicio,
                        p.horas,
                        p.dias,
                        p.medios_dias
                        
                    FROM parqueadero p WHERE p.placa='$placa' AND p.estado='A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){

                if($row = mysqli_fetch_assoc($result)){

                  $placa=$row['placa'];
                  $codigo_ticket=$row['codigo_ticket'];
                  $tipo_vehiculo=$row['tipo_vehiculo'];
                  $fecha_hora_ingreso=$row['fecha_hora_ingreso'];
                  $fecha_hora_salida=$row['fecha_hora_salida'];
                  $descripcion=$row['descripcion'];
                  $valor_servicio=$row['valor_servicio'];
                  $horas=$row['horas'];
                  $dias=$row['dias'];
                  $medios_dias=$row['medios_dias'];

                }
            }

             $data[0]['placa']=$placa;
             $data[0]['codigo_ticket']=$codigo_ticket;
             $data[0]['tipo_vehiculo']=$tipo_vehiculo;
             $data[0]['fecha_hora_ingreso']=$fecha_hora_ingreso;
             $data[0]['fecha_hora_salida']=$fecha_hora_salida;
             $data[0]['descripcion']=$descripcion;
             $data[0]['valor_servicio']=$valor_servicio;
             $data[0]['horas']=$horas;
             $data[0]['dias']=$dias;
             $data[0]['medios_dias']=$medios_dias;

             return $data;

    }

        public function getDatosParqueoSalida($placa){

        $sql = "SELECT  p.placa,
                        p.codigo_ticket,
                        (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                        p.fecha_hora_ingreso,
                        p.fecha_hora_salida,
                        p.descripcion,
                        p.valor_servicio,
                        p.horas,
                        p.dias,
                        p.medios_dias
                        
                    FROM parqueadero p WHERE p.placa='$placa' AND p.estado='F' ORDER BY parqueadero_id DESC LIMIT 1";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){

                if($row = mysqli_fetch_assoc($result)){

                  $placa=$row['placa'];
                  $codigo_ticket=$row['codigo_ticket'];
                  $tipo_vehiculo=$row['tipo_vehiculo'];
                  $fecha_hora_ingreso=$row['fecha_hora_ingreso'];
                  $fecha_hora_salida=$row['fecha_hora_salida'];
                  $descripcion=$row['descripcion'];
                  $valor_servicio=$row['valor_servicio'];
                  $horas=$row['horas'];
                  $dias=$row['dias'];
                  $medios_dias=$row['medios_dias'];

                }
            }

             $data[0]['placa']=$placa;
             $data[0]['codigo_ticket']=$codigo_ticket;
             $data[0]['tipo_vehiculo']=$tipo_vehiculo;
             $data[0]['fecha_hora_ingreso']=$fecha_hora_ingreso;
             $data[0]['fecha_hora_salida']=$fecha_hora_salida;
             $data[0]['descripcion']=$descripcion;
             $data[0]['valor_servicio']=$valor_servicio;
             $data[0]['horas']=$horas;
             $data[0]['dias']=$dias;
             $data[0]['medios_dias']=$medios_dias;

             return $data;

    }

    public function getDatosParqueoSalidaBoton($codigo_ticket){

        $sql = "SELECT  p.placa,
                        p.codigo_ticket,
                        (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                        p.fecha_hora_ingreso,
                        p.fecha_hora_salida,
                        p.descripcion,
                        p.valor_servicio,
                        p.horas,
                        p.dias,
                        p.medios_dias
                        
                    FROM parqueadero p WHERE p.codigo_ticket=$codigo_ticket AND p.estado='F'";
                    
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){

                if($row = mysqli_fetch_assoc($result)){

                  $placa=$row['placa'];
                  $codigo_ticket=$row['codigo_ticket'];
                  $tipo_vehiculo=$row['tipo_vehiculo'];
                  $fecha_hora_ingreso=$row['fecha_hora_ingreso'];
                  $fecha_hora_salida=$row['fecha_hora_salida'];
                  $descripcion=$row['descripcion'];
                  $valor_servicio=$row['valor_servicio'];
                  $horas=$row['horas'];
                  $dias=$row['dias'];
                  $medios_dias=$row['medios_dias'];

                }
            }

             $data[0]['placa']=$placa;
             $data[0]['codigo_ticket']=$codigo_ticket;
             $data[0]['tipo_vehiculo']=$tipo_vehiculo;
             $data[0]['fecha_hora_ingreso']=$fecha_hora_ingreso;
             $data[0]['fecha_hora_salida']=$fecha_hora_salida;
             $data[0]['descripcion']=$descripcion;
             $data[0]['valor_servicio']=$valor_servicio;
             $data[0]['horas']=$horas;
             $data[0]['dias']=$dias;
             $data[0]['medios_dias']=$medios_dias;

             return $data;

    }

    public function getDatosEmpresa(){

        $sql = "SELECT (SELECT t.razon_social FROM tercero t WHERE tercero_id=e.tercero_id)AS razon_social,
                       (SELECT t.numero_identificacion FROM tercero t WHERE tercero_id=e.tercero_id)AS numero_identificacion,
                       (SELECT t.digito_verificacion FROM tercero t WHERE tercero_id=e.tercero_id)AS digito_verificacion,
                       (SELECT t.telefono FROM tercero t WHERE tercero_id=e.tercero_id)AS telefono,
                       e.logo_empresa,
                       e.ubicacion,
                       e.direccion,
                       e.pagina,
                       e.camara_comercio

                FROM empresa e WHERE e.estado='A'";
                    
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){

                if($row = mysqli_fetch_assoc($result)){

                  $razon_social=$row['razon_social'];
                  $numero_identificacion=$row['numero_identificacion'];
                  $digito_verificacion=$row['digito_verificacion'];
                  $telefono=$row['telefono'];
                  $logo_empresa=$row['logo_empresa'];
                  $ubicacion=$row['ubicacion'];
                  $direccion=$row['direccion'];
                  $pagina=$row['pagina'];
                  $camara_comercio=$row['camara_comercio'];

                }

            }

             $data[0]['razon_social']=$razon_social;
             $data[0]['numero_identificacion']=$numero_identificacion;
             $data[0]['digito_verificacion']=$digito_verificacion;
             $data[0]['telefono']=$telefono;
             $data[0]['logo_empresa']=$logo_empresa;
             $data[0]['ubicacion']=$ubicacion;
             $data[0]['direccion']=$direccion;
             $data[0]['pagina']=$pagina;
             $data[0]['camara_comercio']=$camara_comercio;

             return $data;

    }
        
    public function listarVehiculosParqueadero(){ 
             
        $sql = "SELECT p.parqueadero_id,
                       p.codigo_ticket,
                       p.placa,
                       p.tipo_vehiculo_id,
                       (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                       p.fecha_hora_ingreso,
                       p.fecha_hora_salida,
                       p.descripcion,
                       p.estado AS estado_val,
                       p.tipo_servicio,
                       (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'FINALIZADO' END)AS estado,
                       p.valor_servicio,
                       p.horas,
                       p.medios_dias,
                       p.dias,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=p.usuario_id)AS usuario,
                       p.fecha_registro,
                       (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=p.usuario_actualiza_id)AS usuario_actualiza,
                       p.fecha_actualiza
                       
                FROM parqueadero p ORDER BY codigo_ticket DESC";
               
        $result = $this->query($sql);
        
        if (mysqli_num_rows($result)>0){ 
               return $result;
        }
    }
    
    
    public function contarParqueo(){
                 
            $sql = "SELECT COUNT(*) AS parqueos FROM parqueadero WHERE estado='A'";
            $result = $this->query($sql);
            
            if (mysqli_num_rows($result)>0){
                return $result;
            }else{            
                throw new Exception("Error consultando los usuarios el motivo:".$this->error);        
            } 
    } 

    public function validarMensual(){

        date_default_timezone_set('America/Bogota');
        $fecha_hora_actual =  date("Y-m-d H:i:s");
        $array = array();
        $data = array();

        $select="SELECT parqueadero_id,
                        placa 
                FROM parqueadero WHERE tipo_servicio = 'mensual' AND fecha_hora_salida <= '$fecha_hora_actual'  AND fecha_hora_salida != '0000-00-00 00:00:00' AND estado = 'A' ";
        $result = $this->query($select);
            
        if (mysqli_num_rows($result)>0){

            for($i=0; $row= mysqli_fetch_assoc($result); $i++){

                    $data[$i]['vencidos']=$row;
                    array_push($array,$data[$i]['vencidos']['parqueadero_id']);

            } 
 
            $vencidos = implode(",",$array);
            $update="UPDATE parqueadero SET estado = 'F' WHERE parqueadero_id IN($vencidos)";
            $result = $this->query($update);

            return $data;

        }
    }

        
    }