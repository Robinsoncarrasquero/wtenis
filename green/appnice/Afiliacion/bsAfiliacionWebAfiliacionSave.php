<?php
//Este programa permite la afiliacion de un atleta en cada semestre o periodo
session_start();
require_once '../conexion.php';
require_once '../funciones/funcion_email.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';

if ($_SESSION['niveluser'] != 0) {
    header('Location: ../sesion_inicio.php');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST'){
     die('Error fatal No pudo conectarse: ' . mysql_error());
}


$chkOperacion=  $_POST['chkOperacion'];

$array_Datos = explode ('-',trim($_POST['id'])); // Creamos un arreglo con id y categoria
$atleta_id =$array_Datos[0];
$categoria =$array_Datos[1];
$sexo =$array_Datos[2];
$afiliaciones_id =$array_Datos[3];
$estado=$_POST['estado'];

$objAtleta = new Atleta();
$objAtleta->Find($atleta_id);

$objEmpresa= new Empresa();
$objEmpresa->Fetch($estado);
if ($objEmpresa->Operacion_Exitosa()){
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
   //Aqui colocamos el ano de afiliacion que cambiara cada ano
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=$objAfiliacion->get_ID();
}

//Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
$objAfiliado = new Afiliaciones();
$objAfiliado->Find_Afiliacion_Atleta($atleta_id,$ano_afiliacion);
if (!$objAfiliado->Operacion_Exitosa()){
   //Creamos una nueva afiliacion
    $objAfiliado->setAtleta_id($atleta_id);
    $objAfiliado->setAno($objAfiliacion->getAno());
    $objAfiliado->setCategoria($objAtleta->Categoria_Afiliacion($objAfiliacion->getAno()));
    $objAfiliado->setSexo($objAtleta->getSexo());
    $objAfiliado->setFVT($objAfiliacion->getFVT());
    $objAfiliado->setAsociacion($objAfiliacion->getAsociacion());
    $objAfiliado->setSistemaWeb($objAfiliacion->getSistemaWeb());
    $objAfiliado->setAfiliacion_id($objAfiliacion->get_ID());
    $objAfiliado->create();
    
}else{
    $objAfiliado->setFVT($objAfiliacion->getFVT());
    $objAfiliado->setAsociacion($objAfiliacion->getAsociacion());
    $objAfiliado->setSistemaWeb($objAfiliacion->getSistemaWeb());
    $objAfiliado->setAfiliacion_id($objAfiliacion->get_ID());
    $objAfiliado->Update();
    
}


//Aqui identificamos a que operacion estamos realizando
//Formalizar la Federacion y Asociaciones(formalizar)
//o Contratando el servicio web
$objAfiliaciones = $objAfiliado;
if ($chkOperacion) {
    //Cambiamos el fichaje solicitado
    $objAtleta->setEstado($estado);
    $objAtleta->Update();
    
    //Crea la afiliacion y la acepta de hecho
    $objAfiliaciones->setAfiliarme(1);
    $objAfiliaciones->setAceptado(1); //la afiliacion y servicio web son un solo pago
    $objAfiliaciones->setFecha_Pago(date('Y-m-d:h:s'));
    $objAfiliaciones->Update();
} else {

    $objAfiliaciones->setAfiliarme(0);
    $objAfiliaciones->setAceptado(0);
    $objAfiliaciones->setFecha_Pago(date('Y-m-d:h:s'));
    $objAfiliaciones->Update();
}


if ($objAfiliaciones->Operacion_Exitosa()) {
    if ($chkOperacion==1) {
        //Enviamos un correo segun plantilla de formalizacion o contratacion web
        email_notificacion("Afiliarme", $objAtleta->getCedula());
       
    } else {
        email_notificacion("DesAfiliarme", $objAtleta->getCedula());
       
    }
    
        //Aceptacion de afiliacion afiliado
    if ($objAfiliaciones->getAceptado()>0) {

        $p_ya_consumido_fed=33.33;
     }else{

        $p_ya_consumido_fed=0;
    }

    //Formalizacion ante  la asociacion
    if ($objAfiliaciones->getFormalizacion()>0) {
        //echo "<td name='formalizado' id='f$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";

        $p_ya_consumido_fed=66.66;
    }
    //Formalizacion ante la Federacion
    if ($objAfiliaciones->getPagado()>0) {
        //echo "<td name='pagado' id='p$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";

        $p_ya_consumido_fed=100;
    }
    
    //Federacion
//    $str_federacion =
//         '<td id="federacion">
//        <div id="fed">
//            <div class="progress">
//                <div class="progress-bar" role="progressbar" style="width:'.$p_ya_consumido_fed.'%;" aria-valuenow="'.$p_ya_consumido_fed.'" >'.$p_ya_consumido_fed.'%
//                    
//                </div>
//            </div> 
//        </div></div><td>';
    
    //Para mostrar un progress bar por procesos
    $progresbar_1 = "progress-bar progress-bar-warning  ";
    $progresbar_2 = "progress-bar progress-bar-warning ";
    $progresbar_3 = "progress-bar progress-bar-warning ";
    $progresbar_1_val = 33.34;$progresbar_2_val = 33.33;$progresbar_3_val = 33.33;
    $progresbar_1_val = 100;$progresbar_2_val = 100;$progresbar_3_val = 100;
    //Aceptacion de afiliacion afiliado
    if ($objAfiliaciones->getAceptado() > 0) {
        $p_ya_consumido_fed = 33.34;
        $progresbar_1 = "progress-bar progress-bar-success progress-bar-striped";
    } else {

        $p_ya_consumido_fed = 0;
    }

    //Formalizacion ante  la asociacion
    if ($objAfiliaciones->getFormalizacion() > 0) {
        //echo "<td name='formalizado' id='f$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";
        $progresbar_2 = "progress-bar progress-bar-success progress-bar-striped";

        $p_ya_consumido_fed = 66.67;
    }
    //Formalizacion ante la Federacion
    if ($objAfiliaciones->getPagado() > 0) {
        //echo "<td name='pagado' id='p$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";
        $progresbar_3 = "progress-bar progress-bar-success progress-bar-striped";
        $p_ya_consumido_fed = 100;
        $progresbar_3_val = 33.33;
    }
    $str_federacion='
          <td name="fede" id="federacion">'
                    . '<div class="progress">'
                            .'<div class="'.$progresbar_1.'" role="progressbar" style="width:100%">
                            Solicitada
                            </div>'
                          
                    . '</div>'
                    . '<div class="progress">'
                            
                           . '<div class="'.$progresbar_2.'" role="progressbar" style="width:100%">
                            Formalizada
                            </div>'
                           
                    . '</div>'
                    . '<div class="progress">'
                            
                           . '<div class="'.$progresbar_3.'" role="progressbar" style="width:100%">
                            Federada
                            </div>'
                           
                    . '</div>'
                
         . '</td> ';
    $jsondata = array("Success"=>TRUE,"Mensaje"=>"Procesado ok","data"=>$str_federacion);
} else {
   $jsondata = array("Success"=>FALSE,"Mensaje"=>"No Procesado","data"=>"<b> No hay registro para actualizar</b>");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
 
//$str_asociacion ='<div id="aso">
//            <div class="progress">
//                <div class="progress-bar" role="progressbar" style="width:'.$p_ya_consumido_aso.'%;" aria-valuenow="'.$p_ya_consumido_aso.'" >'.$p_ya_consumido_aso.'%
//                    
//                </div>
//            </div> 
//        </div>';
?>


   

        

         
	
         
	
        
        
	
	


