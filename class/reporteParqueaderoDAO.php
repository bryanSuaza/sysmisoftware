<?php

class reporteParqueaderoDAO extends db{
   
    function __construct() {
        parent::__construct();
    }
    
    public function generarReporte($fecha_desde,$fecha_hasta,$consulta,$estado){

        $fecha_desde=date('Y-m-d H:i:s',strtotime($fecha_desde));
        $fecha_hasta=date('Y-m-d H:i:s',strtotime($fecha_hasta));

        $select="SELECT p.codigo_ticket,
                        p.placa,
                        (SELECT tipo FROM tipo_vehiculo WHERE tipo_vehiculo_id=p.tipo_vehiculo_id)AS tipo_vehiculo,
                        p.fecha_hora_ingreso,
                        p.fecha_hora_salida,
                        p.valor_servicio,
                        (CASE p.estado WHEN 'A' THEN 'ACTIVO' ELSE 'FINALIZADO' END)AS estado 

                 FROM parqueadero p WHERE p.estado='$estado' $consulta AND p.fecha_hora_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta'";
         
        $result=$this->query($select);

        if (mysqli_num_rows($result)>0){

            for($i=0; $row= mysqli_fetch_assoc($result); $i++){
                    $data[$i]['parqueadero']=$row;
            } 

           $select="SELECT SUM(p.valor_servicio) AS valor_total 
                    FROM parqueadero p WHERE p.estado='$estado' $consulta AND p.fecha_hora_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta'";
           $result=$this->query($select);

           if (mysqli_num_rows($result)>0){

                if($row= mysqli_fetch_assoc($result)){
                        $data[0]['total']=$row;
                } 

            }

            return $data;

        }else{
            return 1;
        }
    }

}