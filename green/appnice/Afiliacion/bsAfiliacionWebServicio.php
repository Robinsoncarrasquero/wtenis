<?PHP
//Este programa basadas en las afiliaciones separadas 
//y procesando el servicio web.
session_start();

require_once '../funciones/funcion_monto.php';
require_once '../funciones/funcion_fecha.php';

require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

 
if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_cerrar.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']>0){
    header('Location: ../sesion_cerrar.php');
    exit;
}



if (!isset($_SESSION['empresa_id'])) {

    header('Location: ../sesion_inicio.php');
    exit;
}

header('Content-Type: text/html; charset=utf-8');


$empresa_id=$_SESSION['empresa_id'];
$atleta_id=$_SESSION['atleta_id'];

$ObjAtleta = new Atleta();
$ObjAtleta->Find($atleta_id);

$objEmpresa = new Empresa();
$objEmpresa->Fetch($ObjAtleta->getEstado());
$empresa_id=$objEmpresa->get_Empresa_id();


//Buscamos la afiliacion activa 
$obAfilicion_activa = new Afiliacion();
$obAfilicion_activa->Fetch($empresa_id);

//Buscamos todas las afiliaciones del atleta
$rsAfiliacion = Afiliaciones::All_Afiliaciones_Atleta($atleta_id);


if ($rsAfiliacion)
{
    //Obtenemos los registros desde MySQL
     
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Historico Afiliaciones</title>
    <link rel="stylesheet" href="../css/master_page.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style >
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }
        tr[class~="table-head"]{
            background-color:<?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color:<?php echo $_SESSION['color_jumbotron'] ?>;
        };
        

        
        
    </style>
</head>
<body>
    
<?php
echo '<div class="container-fluid">'; //Container main
    
    //Menu de usuario
    include_once '../Template/Layout_NavBar_User.php';
    
    echo '<hr>';
    echo '<h2>Afiliaciones Realizadas</h2>';
    //Presentar un Usu//Presentar un Usuario
    echo '<div class="col-xs-12">';
    echo '<h6 class="titulo-name" >Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '</div>'; //Container
    
echo '<div class="col-xs-12 col-sm-8">';
    
 $strhead='


    <form>        
    <div  class="table-responsive">      
        <table class="table table-bordered table-responsive  table-condensed">
            <thead >
                <tr class="table-head">
                <th><p class="glyphicon glyphicon-dashboard"<p></th>
                <th>A&ntilde;o</th>
                <th>Periodo</th>
                <th>Formalizado</th>
                <th>Federado</th>
                </tr>
            </thead>';
                            
 echo $strhead;
 
 
    $ixx = 0;$id_afiliacion=0;
    $si_hay_activa=FALSE;
    foreach ($rsAfiliacion as $dataAfiliacion) {
        $afiliacion_id = $dataAfiliacion['afiliacion_id'];
        $objAfiliacion = new Afiliacion();
        $objAfiliacion->Find($afiliacion_id);
        
        //Obtenemos desde el objeto el periodo consumido y no consumido para
        //generar una barra de progreso con bootstrap
        $p_ya_consumido=  round($objAfiliacion->periodo_consumido(),2);
        $p_no_consumido=  round($objAfiliacion->periodo_no_consumido(),2);

        $fvtCicloCobro = $objAfiliacion->getFVTCicloCobro();
        $fvt_monto = $objAfiliacion->getFVT();
        $asociacionCicloCobro = $objAfiliacion->getAsociacionCicloCobro();
        $aso_monto = $objAfiliacion->getAsociacion();
        $sis_monto = $objAfiliacion->getSistemaWeb();
        $sistemaWebCicloCobro = $objAfiliacion->getSistemaWebCicloCobro();
        $sexo = $ObjAtleta->getSexo();
       
        //Ubicar la afiliacion del atleta de la coleccion
        $objAfiliado = new Afiliaciones();
        $objAfiliado->Fetch($afiliacion_id, $atleta_id);
        $categoria=$objAfiliado->getCategoria();
        $sexo=$objAfiliado->getSexo();
        $afiliado_id=$objAfiliado->get_ID();     
         
        //Ordenamos el rowid para control de id
        $rowid = $atleta_id . '-' . $categoria . '-' . $sexo . "-" . $afiliado_id;
        echo "<div id='record$rowid'>";
        echo "<tr id='data" . $rowid . "' class='alert alert-default' >";
         if ($p_ya_consumido > 99) {
            if ($objAfiliado->getPagado() > 0) {
                echo "<td><p class='glyphicon glyphicon-thumbs-up' id='glyphi" . $rowid . "' ></p></td>";
            } else {
                echo "<tr id='data" . $rowid . "' >";
                echo "<td><p class='glyphicon glyphicon-lock' id='glyphi" . $rowid . "'></p></td>";
            }
        } else {
            if ($objAfiliado->getPagado() > 0) {
                echo "<td><p class='glyphicon glyphicon-thumbs-up' id='glyphi" . $rowid . "' ></p></td>";
            } else {
                echo "<tr id='data" . $rowid . "' >";
                echo "<td><p class='glyphicon glyphicon-hourglass' id='glyphi" . $rowid . "'></p></td>";
            }
        }
        echo "<td>".$objAfiliado->getAno()."</td>";
         
//        echo 
//        '<td>
//            <div class="progress">
//                <div class="progress-bar progress-bar-success" style="width:'.$p_ya_consumido.'%">
//                  <span class="sr-only">'.$p_ya_consumido.'% Complete (info)</span>
//                </div>
//
//                <div class="progress-bar progress-bar-success" style="width:'.$p_no_consumido.'%">
//                  <span class="sr-only">'.$p_no_consumido.'% Complete (danger)</span>
//                </div>
//            </div> 
//        </td>';
   
    echo   '<td>
            <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                aria-valuenow="'.$p_ya_consumido.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$p_ya_consumido.'%">
                '.$p_ya_consumido.' % Complete (success)
            </div>
            </div>
            </td>';
           
        if ($objAfiliado->getFormalizacion()>0) {
            echo "<td><p class='glyphicon glyphicon-thumbs-up' id='glyphi" . $rowid . "' ></p></td>";
            //echo "<td> <input  type='checkbox' name='confirmado' id='pagado$rowid' checked='checked' disabled='disabled'></td>";
        }else{
            
            echo "<td> <input  type='checkbox' name='confirmado' id='pagado$rowid'  disabled='disabled'></td>";
        }
        
        if ($objAfiliado->getPagado()>0) {
             echo "<td><p class='glyphicon glyphicon-thumbs-up' id='glyphi" . $rowid . "' ></p></td>";
          //echo "<td> <input  type='checkbox' name='pagado' id='$rowid' checked='checked' disabled='disabled'></td>";
        }else{
           echo "<td> <input  type='checkbox' name='pagado' id='$rowid' disabled='disabled' ></td>";
        }
        echo "</tr>";
        echo "</div>";
         if ($obAfilicion_activa->get_ID()==$afiliacion_id){
             $si_hay_activa=TRUE;
         }
           
        }
        
    
   
     
    echo '</table>
</div>
</form>
<!-- div Side Left -->
</div>';

// Div side rigth
echo '<div class="col-xs-12 col-sm-4">';
        echo '<div class="notas-left ">';

        if ($si_hay_activa){
            $objAfiliado = new Afiliaciones();
            $objAfiliado->Fetch($obAfilicion_activa->get_ID(), $atleta_id);
       
            if ($objAfiliado->getFormalizacion()>0) {
               if ($objAfiliado->getPagado()>0){
                    echo '<h5 class="alert alert-success">'.Bootstrap_Class::texto("Federado:").'<br><br>'
                            . 'Usted ha formalizado su Afiliacion '
                            . 'ante su Asociacion y est&aacute habilitado para participar en el circuito oficial de Tenis Federado,'
                   . ' de acuerdo a su categoria, cumpliendo  y aceptando el reglamento vigente.</h5>';
               }else{
                    echo '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Asociacion:","success").'<br>'
                            . 'Usted ha formalizado su Afiliacion ante su asociacion y pronto ser&aacute habilitado '
                   . 'para participar en el Circuito Oficial de Tenis Federado.</h5>';

               }
            }else{

                 echo '<h4 class="alert alert-danger">'.Bootstrap_Class::texto("Formalizar:").'<br><br>'
                        . 'Usted aun no ha formalizado su Afiliacion ante su <span>Asociacion</span>. '
                        . 'Formalícela para que participes en el Circuito Oficial de Tenis Federado.</h4>';

            }
            
        }
        echo '</div>';
        
    echo '</div>';

?>
    
    
</body>

</html>
<?php
}
else {
    $error_login=true;
    $mensaje="NO HAY DATOS PARA LA INFORMACION SOLICITADA";

    header("Location: ../sesion_usuario.php ");
  
    exit;
   
}



?>


    
