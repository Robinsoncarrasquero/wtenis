<?php
session_start();
require_once '../ConexionMysqli_cls.php';
//require_once '../clases/Bootstrap_Class_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/bsTemplate.php';
require_once  '../clases/Torneos_cls.php';
require_once  '../clases/Atleta_cls.php';
require_once  '../clases/Torneos_Inscritos_cls.php';
require_once '../sql/ConexionPDO.php';

if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../Login.php');
    exit;
}
if ($_SESSION['niveluser']>0){
    header('Location: ../sesion_inicio.php');
    exit;
}


//Validamos que la afiliacion sea confirmada
$atleta_id=$_SESSION['atleta_id'];

 echo bsTemplate::header('Retiro',$_SESSION['nombre']);
 echo bsTemplate::aside();
 //Main content
 $main = [];
 $dmain =["opcion"=>"Retiro","icono"=>"glyphicon glyphicon-user","href"=>""];
 array_push($main, $dmain);
 echo  bsTemplate::main_content('Retiro',$main);

$thead = [];
$thead +=["."=>"glyphicon glyphicon-time"];
$thead +=["Acc"=>"glyphicon glyphicon-flash"];
$thead +=["Gra"=>"glyphicon glyphicon-cog"];
$thead +=["Cat"=>"glyphicon glyphicon-signal"];
$thead +=["Fecha"=>"glyphicon glyphicon-calendar"];
//$thead +=["Torneo"=>"glyphicon glyphicon-road"];
$table_head= bsTemplate::table_head("Retiro",$thead);

$table_footer='
                   </tbody>
                </table>
            </section>
        </div>
    </div>';


?>

<div class="col-lg-8">
    <form id ="register-form" class="form-signin" method="post"  >
        <div id="error">
                <!-- error will be showen here ! -->
        </div>
        <?php echo $table_head;?>

<?php
    $record_encontrados=0;
    
    $objAtleta = new Atleta();
    $objAtleta->Find($atleta_id);
    if ($objAtleta->Operacion_Exitosa())         
    {
         
        $rsTorneos= Torneo::Torneos_Retiro();  
        
        foreach ($rsTorneos as $filator)
        {
            
            $objTorneo_Inscritos= new TorneosInscritos();
            $objTorneo_Inscritos->Find_Atleta($filator["torneo_id"],$objAtleta->getID());
            
            if ($objTorneo_Inscritos->Operacion_Exitosa()){
                $record_encontrados ++;
                $chkchecked=" ";
                $chkenabled=" ";
                if ($objTorneo_Inscritos->getEstatus()=="Retiro"){
                    $chkchecked="checked ";
                    $chkenabled="disabled ";
                }
                $tachado=" ";

                switch ($objTorneo_Inscritos->getEstatus()) {
                    case "Retiro":
                        echo '<tr class="" >';
                        echo '<td><span class="label label-success"><i class="glyphicon glyphicon-thumbs-down"></i></span></td>  ';
                    
                        break;
                    default:
                        echo '<tr class=" "  >  ';
                        echo '<td><span class="label label-warning"><i class="glyphicon glyphicon-minus"></i></span></td>  ';
                        break;
                }
        
                //Argumentos de datos para disparar post 
                $dato=$filator['torneo_id'].",".$objAtleta->getID().",".$objTorneo_Inscritos->ID().",".$objTorneo_Inscritos->getCategoria().",RET";

                echo "<td class=' '> <input  id='".$objTorneo_Inscritos->ID()."' type=\"checkbox\"  name=\"chkretirar[]\" value=\"$dato\" $chkchecked $chkenabled ></td>";
                echo "<td class='small italic' >".$filator['numero']."-".$filator['tipo']."-".$filator['entidad']."</td>";
                echo "<td class='small italic'>";
                echo "<select  disabled id='".$filator["torneo_id"]."'>";
                echo "<option  selected value='".$objTorneo_Inscritos->getCategoria()."'>".$objTorneo_Inscritos->getCategoria()."</option>";
                echo '</select>';
                echo "</td>";
                echo "<td class='small italic'>".date_format(date_create($filator["fecha_inicio_torneo"]),"d-M")."<br> al <br>".date_format(date_create($filator["fecha_fin_torneo"]),"d-M")."</td>";
                //echo "<td class='small italic'>".($filator["codigo"])."</td>";
                echo '</tr>';
            }
            
        }
    }
       


echo $table_footer;


if ($record_encontrados>0 and $status="Retirado"){
    echo '
        
            <input  type="submit" name="btnProcesar" id="btn-submit" value="Guardar" class="btn btn-primary" > 
        
    ';
}else{
    $mensaje=' '
    . 'No tiene torneos disponibles para retirar en este momento.';
    echo bsTemplate::mensaje_alerta('Mensaje',$mensaje,'alert alert-success','col-lg-8');
    
}


echo "  </form>";

//Div-end site Left
echo "</div>";

 //Div side right
    $texto=' '
        . 'Puede retirarse de los torneos cerrados solo en los plazos establecidos. Vencida la fecha, '
        . 'el jugador podr&iacutea estar sujeto a sanciones de acuerdo al reglamento vigente.';
        echo bsTemplate::panel('<i class="glyphicon glyphicon-minus label label-warning"></i>
        Penalidad',$texto,' alert alert-info','hidden-xs hidden-sm col-md-4');
    //Div-end side right
 
?>

<?php echo bsTemplate::footer();?>


<script>

$('#register-form').on('submit',function(e){
    //var ok=confirm("Esta Seguro de Modificar Los Datos");
    //var frmdata = $("#register-form").serialize();
    var frmdata = $("#register-form :input").serializeArray();
    var data = JSON.stringify(frmdata);
    

    $.ajax({
    type : 'POST',
    url  : 'retiro_save_submit.php',
    data : {data:data},
    beforeSend: function()
    {	
        $("#error").html('').fadeOut(100);
        $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Procesando ...');
    },
    success :  function(data)
        {						
            if(data.Success==false){
                $("#error").fadeIn(1000, function(){
                    $("#error").html('<div class="alert alert-danger">'
                    +'<span class="glyphicon glyphicon-circle"></span>'+data.Mensaje+'</div>');
                });
            }else{
                $("#error").fadeIn(1000, function(){
                    $("#error").html('<div class="alert alert-success"><span class="glyphicon glyphicon-thumbs-up">'
                    +'</span> &nbsp;'+data.Mensaje+'</div>');
                    $("#btn-submit").html('<span class="glyphicon glyphicon-ok"></span> &nbsp; Guardar');
                });
                dJSON= data.Retirados;
                $.each(dJSON, function(i,item){
                    $("#"+dJSON[i].retiro).prop("disabled","disabled");
                	//document.write("<br>"+i+" - "+miJSON[i].retiro);
        		});

                
                    
            }
        }
    });
    return false;
})

function xApuntarme(e){  
    var id = $(this).attr( "id" );
    var chkOperacion = $("#"+id).is(':checked') ? 1: 0;  
    if ($("#"+id).is(':checked')){
        ok = alert("Despues de dar Click al Boton Guardar, No podra revertir la decision de retiro marcada.")
    }
}
$( "input[type=checkbox]" ).on( "click", Apuntarme);

</script>
</body>

</html>







 