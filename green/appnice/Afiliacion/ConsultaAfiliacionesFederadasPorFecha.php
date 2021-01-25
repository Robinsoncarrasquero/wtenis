<?php
require_once '../funciones/funcion_monto.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

$fdesde=$_POST['fdesde'];

$fhasta=$_POST['fhasta']; //Confirmacion de pagos o Por pagar

$str=
"<table class='table table-responsive table-striped  table-condensed'>
            <thead>
                <th>#</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Estado</th>
                <th>Cat.</th>
                <th>Modal.</th>
                <th>Confirmacion</th>
                </thead>";
            
echo $str;
            
            
            {
                //Manejos coleccion de afiliaciones
                $objAfiliaciones = new Afiliaciones();
                $rsAfiliados=$objAfiliaciones->GetRangoPorFecha($fdesde,$fhasta);
                
                $ixx=0; $nroPagos= 0;
                $totalAso=0;$totalFvt=0;$totalWeb=0;
                foreach ($rsAfiliados as $datatmp)
                {
                    $atleta_id=$datatmp['atleta_id'];

                    $objAtleta = new Atleta();
                    $objAtleta->Fetch($atleta_id);
                    $sexo = $objAtleta->getSexo();
                    $ixx ++;
             
                    $rowid=$datatmp['afiliaciones_id'];
                    //echo "<tbody>";
                    echo "<div class='data'>";
                    if($datatmp['pagado']>0){
                         if ($datatmp['conciliado']==0){
                            //echo "<tr id='data$rowid' style=' background-color:#00ffff'>"; 
                            echo "<tr id='data$rowid' >"; 
                        }else{
                            echo "<tr id='data$rowid' style=' background-color:#fff000'>"; 
                           
                        }
                        //echo "<tr id='data$rowid' style=' background-color:#fff000'>";  
                        $xfvt_monto=$datatmp['fvt'];
                        $xaso_monto=$datatmp['asociacion'];
                        $xsis_monto=$datatmp['sistemaweb'];
                    }else{
                         echo "<tr id='data$rowid'>";  
                        $xfvt_monto=$fvt_monto;
                        $xaso_monto=$aso_monto;
                        $xsis_monto=$sis_monto;
                    } 
                    
                    $nroPagos ++;
                    $totalFvt = $totalFvt + $xfvt_monto;
                    $totalAso = $totalAso + $xaso_monto;
                    $totalWeb = $totalWeb + $xsis_monto;
                    
                    echo "<td>".$ixx."</td>";
                    echo "<td>".$objAtleta->getCedula()."</td>";
                    echo "<td>".$objAtleta->getNombres()."</td>";
                    echo "<td>".$objAtleta->getApellidos()."</td>";
                    echo "<td>".$objAtleta->getEstado()."</td>";
                    if ($objAtleta->getSexo()=="F" || $objAtleta->getSexo()=="M"){
                        echo "<td>".$datatmp['categoria']."-".$objAtleta->getSexo()."</td>";
                    }else{
                         echo "<td class='alert alert-danger'>x</td>";
                    }
                    echo "<td>".$datatmp['modalidad']."</td>";
                    echo "<td>".$datatmp['fecha_pago']."<span class='glyphicon glyphicon-ok'></span>"."</td>";
                    echo "</tr>";


                    }
            }
            
            echo "</tbody>";
            echo "</div>";
$str='</table>
    </div>';
    
echo $str;

