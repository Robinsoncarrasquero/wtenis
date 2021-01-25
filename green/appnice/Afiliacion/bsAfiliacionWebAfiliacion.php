<?PHP
//Este programa realiza las afiliaciones de federacion y asociaciones
//de forma independiente del pago
session_start();
require_once '../funciones/funcion_monto.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../bs_sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']>0){
    header('Location: ../sesion_cerrar.php');
    exit;
}

//Eliminamos la variable de session renovacion;
if (isset($_SESSION['renovacion'])) {
    unset($_SESSION['renovacion']);
 
}

header('Content-Type: text/html; charset=utf-8');


$empresa_id=$_SESSION['empresa_id'];
$atleta_id=$_SESSION['atleta_id'];
$objAtleta = new Atleta();
$objAtleta->Find($atleta_id);

//Instanciamos la clase empresa para obtener la empresa_id
//de la asociacion registrada
$objEmpresa= new Empresa();
$objEmpresa->Fetch(trim($objAtleta->getEstado()));
if ($objEmpresa->Operacion_Exitosa()){
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
    $monto_aso=$objAfiliacion->getAsociacion();
    $monto_fvt=$objAfiliacion->getFVT();
    $monto_sis=$objAfiliacion->getSistemaWeb();

    //Aqui colocamos el ano de afiliacion que cambiara cada ano
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=$objAfiliacion->get_ID();
}
header('Content-Type: text/html; charset=utf-8');
//En caso de haber alguna afiliacion activa se le presenta al usuario para que la realice   
if ($atleta_id>0)
{ 
    $array_entidades=Empresa::Entidades();
    $estado=$objAtleta->getEstado();
    $indice = array_search($estado, array_column($array_entidades, 'estado'));
    if ($indice >= 0) {
        if (strtoupper($estado) != 'FVT') {
            $rsEntidades[] = $array_entidades[$indice];
        } else {
            $rsEntidades = $array_entidades;
        }
    } else {
        $rsEntidades = $array_entidades;
    }
    $rsEntidades = $array_entidades;
    //Obtenemos los registros desde MySQL
   
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <title>Afiliacion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    
<div class="container-fluid">
  
<?PHP

    //Menu de usuario
    include_once '../Template/Layout_NavBar_User.php';
    
    echo '<hr>';
    echo '<h2>Afiliacion</h2>'; 
    //Presentar un Usu//Presentar un Usuario
    echo '<div class="col-xs-12">';
    echo '<h6 class="titulo-name" >Bienvenido :'.$_SESSION['nombre'].'</h6>';
    echo '</div>'; //Container 


echo '<div class="col-xs-12 col-sm-8">
  
<form >        
    <div  class="table">      
        <table class="table table-bordered table-responsive  table-condensed">

            <thead>
                <tr class="table-head">
                    <th>A&ntildeo</th>
                    <th>Asociacion</th>
                    <th>Cat.</th>
                    <th>Afiliacion</th>
                    <th>Disciplina</th>
                    <th>Afiliarme</th>
                </tr>
            </thead>';
    


//
    $ixx = 0;
    
   if ($objAtleta->Operacion_Exitosa()) {
       
        //Obtenemos los datos de la empresa o asociacion del atleta
        $objEmpresa= new Empresa();
        $objEmpresa->Fetch($objAtleta->getEstado());
        
        //Obtenemos la afiliacion con los montos de la asociacion y fvt anual
        $objAfiliacion = new Afiliacion();
        $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
        $afiliacion_id=$objAfiliacion->get_ID();
        
        //Obtenemos desde el objeto el periodo consumido y no consumido para
        //generar una barra de progreso con bootstrap
        $p_ya_consumido=$objAfiliacion->periodo_consumido();
        $p_no_consumido=$objAfiliacion->periodo_no_consumido();
//        print_r($p_ya_consumido.'<br>');
//        print_r($p_no_consumido);
        
        $fvtCicloCobro = $objAfiliacion->getFVTCicloCobro();
        $fvt_monto =  $objAfiliacion->getFVT();
        $asociacionCicloCobro =  $objAfiliacion->getAsociacionCicloCobro();
        $aso_monto =  $objAfiliacion->getAsociacion();
        $sis_monto =  $objAfiliacion->getSistemaWeb();
        $sistemaWebCicloCobro =  $objAfiliacion->getSistemaWebCicloCobro();
        $sexo = $objAtleta->getSexo();
        
         //Categoria del atleta a inscribir
        $categoria = $objAtleta->Categoria_Afiliacion($objAfiliacion->getAno());
       
        //Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
        $objAfiliado = new Afiliaciones();
        $objAfiliado->Find_Afiliacion_Atleta($objAtleta->getID(),$objAfiliacion->getAno());
        
        //print_r($afiliacion_id."--".$atleta_id);
        
        if ($objAfiliado->Operacion_Exitosa()) {
            $afiliado_id = $objAfiliado->get_ID();
         } else {
            $afiliado_id = 0;
        }

        $rowid = $atleta_id . '-' . $categoria . '-' . $sexo . "-" . $afiliado_id;
       
       
        echo "<tr id='data" . $rowid . "'  >";   
        
        echo "<td>".$ano_afiliacion."</td>";
        echo "<td>";
        echo '<select id="estado" name="txt_asociacion" class="form-control">';
                        // Recorremos todas las lineas del archivo
                foreach ($rsEntidades as $value) {
                  if ($estado==$value[estado]){
                    echo  '<option selected value="'.$value[estado].'">'.ucwords($value[entidad]).'</option>'; 
                  }else{
                    if ($objAfiliado->getFormalizacion()!=1){
                        echo  '<option value="'.$value[estado].'">'.ucwords($value[entidad]).'</option>'; 
                    }
                  }
                }
                        
        echo '</select>';       
        echo '</td>';
        

        echo "<td>".$objAfiliado->getCategoria()."</td>";
        
        
        //Creamos el progressbar
         $progresbar_1="progress-bar progress-bar-warning ";
         $progresbar_2="progress-bar progress-bar-warning ";
         $progresbar_3="progress-bar progress-bar-warning ";
         $progresbar_1_val=33.34;$progresbar_2_val=33.33;$progresbar_3_val=33.33;
         $progresbar_1_val = 100;$progresbar_2_val = 100;$progresbar_3_val = 100;
        //Aceptacion de afiliacion afiliado
        if ($objAfiliado->getAceptado()>0) {
            $p_ya_consumido_fed=33.34;
            $progresbar_1="progress-bar progress-bar-success progress-bar-striped";
           
        }else{
            $p_ya_consumido_fed=0;
        }
        
       //Formalizacion ante  la asociacion
        if ($objAfiliado->getFormalizacion()>0) {
            //echo "<td name='formalizado' id='f$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";
           $progresbar_2="progress-bar progress-bar-success progress-bar-striped";
           $p_ya_consumido_fed=66.67;
        }
        //Formalizacion ante la Asociaciones
        if ($objAfiliado->getPagado()>0) {
            //echo "<td name='pagado' id='p$rowid' class='glyphicon glyphicon-thumbs-up' ></td>";
           $progresbar_3="progress-bar progress-bar-success progress-bar-striped";
           $p_ya_consumido_fed=100;
           $progresbar_3_val=33.33;
        
        }
                 
//        echo'<td id="federacion">
//            <div id="fed">
//            <div class="progress">
//                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
//                aria-valuenow="'.$p_ya_consumido_fed.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$p_ya_consumido_fed.'%">
//                  '.$p_ya_consumido_fed.'% Complete (success)
//                </div>
//            </div></td>';
//
//        echo "</tr>";
        
       
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
                
         . '</td>';
          
    
    echo $str_federacion;
    echo "<td>".$objAtleta->getDisciplina()."</td>";
    if ($objAfiliado->getAfiliarme()>0) {
            if ($objAfiliado->getFormalizacion()>0) {
              echo "<td> <input  type='checkbox'  name='afiliarme' id='$rowid' checked='checked' disabled='disabled'></td>";
            }else{
               echo "<td> <input  type='checkbox'  name='afiliarme' id='$rowid' checked='checked' ></td>";
            }
        }else{
            echo "<td> <input  type='checkbox' name='afiliarme' id='$rowid' ></td>";
        }       
    }
    
?>
    

</table>
</div>
</form>
<!-- div Side Left -->
</div>
<!--Side left -->
<div class="col-xs-12 col-sm-4"> 
    
     <?php
      echo '<div class="notas-left ">';
     echo '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Fichaje:").'<br><br>
         Usted puede cambiar su Fichaje a una nueva Asociacion durante esta Afiliacion.
         Podrá realizar otro cambio de Ficha en un lapso de 6 meses en caso que lo haya gestionado
         durante esta Afiliacion y deberá solicitarlo ante la Asociacion a la que pertenece para que
         gestione su cambio de Fichaje ante esta Asociaciones.</h5>';
     
    
    
    if ($objAfiliado->getFormalizacion() > 0) {

        if ($objAfiliado->getPagado() > 0) {
            echo '<h5 class="alert alert-success">'.Bootstrap_Class::texto("Federado: ").'<br><br>'
                    . 'Se ha confirmado su Afiliacion y est&aacute habilitado para participar en el circuito oficial de Tenis Federado,'
            . ' de acuerdo a su categoria, cumpliendo  y aceptando el reglamento vigente..</p>';
        } else {
            echo '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Asociacion:","success").'<br><br>'
                    . 'Usted ha formalizado su Afiliacion ante su Asociacion y pronto ser&aacute habilitado '
            . 'para participar en el Circuito Oficial de Tenis Federado.</h5>';
        }
    } else {

            echo '<h5 class="alert alert-danger">'.Bootstrap_Class::texto("Formalizacion: ").'<br><br>'
                    . 'Aun no ha formalizado su Afiliacion ante su Asociacion. '
            . 'Debe formalizar su Afiliacion para participar en el Circuito Oficial de Tenis Federado.</h5>';

    } 
    echo '</div">';
     ?>
</div>
   
<script>
$(document).ready(function(){
   // alert("Tenga en consideracion que puede Cambiar su Fichaje a otra Asociacion en esta Afiliacion");    
$( "input[type=checkbox]" ).on( "click", function(e){  
    var estado= $("#estado").val();
    var nomestado= $("#estado").val();
    var aceptar;
    if ($( "input[type=checkbox]").is(':checked'))
    {
       aceptar= confirm("Esta de Seguro de Solicitar su Afiliacion en la asociacion seleccionada :"+nomestado);
    
    }else{
       aceptar= confirm("Esta de Seguro de Anular su solicitud de Afiliacion en la asociacion seleccionada :"+nomestado);
    
    }
    
    
    var Id = $(this).attr( "id" );
    var url="bsAfiliacionWebAfiliacionSave.php";
    //Obtenemos  checkbox
           
   var chkOperacion = $("#"+Id).is(':checked') ? 1: 0;  
   if (Id.substr(0,3)!=='btn' && aceptar){
       
       $.post(url,
       { id:Id,chkOperacion:chkOperacion,estado:estado}, 
       function(data){
            if (data.Success){
                $("#federacion").html(data.data);
            }else{
                 $("#federacion").html("nada");
            }
        });
    }   
   
    
});

})
</script> 
    
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


    
