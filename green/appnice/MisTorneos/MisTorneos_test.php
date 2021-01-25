<?php
session_start();
//require_once '../funciones/funcion_fecha.php';
require_once '../clases/Encriptar_cls.php';
//require_once '../funciones/Imagenes_cls.php';
//require_once '../clases/Bootstrap2_cls.php';
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once "../clases/Paginacion_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Atleta_cls.php';
require_once '../funciones/bsTemplate.php';

if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../../login.php');
    exit;
}

if($_SESSION['niveluser']!=0){
    header('Location: ../../sesion_inicio.php');
}
//Tabla de atleta
$objAtleta= new Atleta();
$objAtleta->Find($_SESSION['atleta_id']);
    echo bsTemplate::header('Mis Ranking',$_SESSION['nombre']);
    echo bsTemplate::aside();


    echo '<div class="col-xs-12">';
        echo '<h6 hidden class="titulo-name">Ranking Nacional de :'.($objAtleta->getNombreCorto()).'</h6>';
        echo '<h4  hidden id="token_id">'.Encrypter::encrypt($objAtleta->getID()).'</h4>';
        echo '<h4  hidden id="sexo">'.$objAtleta->getSexo().'</h4>';
    echo '</div>'; //Container    

    //<!--main content start-->
    $main = [];
    $dmain =[];
    array_push($main, $dmain);
    echo bsTemplate::main_content('Mis Torneos',$main);
    
    $thead = [];
    $thead +=["Fecha"=>"glyphicon glyphicon-calendar"];
    //$thead +=["."=>"glyphicon glyphicon-time"];
    $thead +=["Ent"=>"glyphicon glyphicon-flag"];
    $thead +=["Gr"=>"glyphicon glyphicon-signal"];
    $thead +=["Doc"=>"glyphicon glyphicon-print"];
    $thead +=["Li"=>"glyphicon glyphicon-list-alt"];
    $thead +=["Fs"=>"glyphicon glyphicon-info-sign"];
    $thead +=["Dw"=>"glyphicon glyphicon-equalizer"];

    $key= urlencode(Encrypter::encrypt($row['torneo_id']));
           
    echo bsTemplate::table_head("Mis Torneos",$thead);
    echo "<tr class='small '>";
    echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha'>2020-02-02";
    echo '<td >2-G4<br><i>16</i></td>';
            
    echo '<td><a data-id="co35'.'" href="../Constancias/ConstanciaParticipacion.php?torneo_id='.$key.'" 
    target="_blank" class=" glyphicon glyphicon-print edit-record">  </a></td>';
    echo '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos">
    <a target="_blank" href="../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
    .$key.'" class="activo-glyphicon glyphicon glyphicon-align-justify"></a></td>';

    echo '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> 
    <a  class="inactivo-glyphicon glyphicon glyphicon-info-sign">  </a></td>';

    echo '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> 
    <a  class="inactivo-glyphicon glyphicon glyphicon-info-sign">  </a></td>';

    echo'<td><p data-toggle="tooltip" data-placement="bottom" title="Draw Singles No Disponible">
    <a  class="inactivo-glyphicon glyphicon glyphicon-file">  </a></p>
    <p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles No Disponible">
    <a  class="inactivo-glyphicon glyphicon glyphicon-duplicate">  </a></p></td>';

    
    echo "</tr>";
    echo 
       '
                    </tbody>
                </table>
           </section>
       </div>
    </div>';


         
?>
<!-- <div class="col-xs-12">

</div>

<div id="mensaje" >

</div>

<div id="data_table">

</div>

<div id="paginacion" class="text text-center ">

</div>

</div>
  -->
<?php echo bsTemplate::footer();?>

<script>
$(document).ready(function(){
    var id=$("#token_id").text();
    $("#mensaje").html('');
    $("#data_table").html('');
    $.ajax({
        method: "POST",
        url: "MyTournament.php", 
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
        // $('#mensaje').removeClass('loader');
        $('#data_table').html(data.html);
        $('#paginacion').html(data.pagination);
        if (!data.Success){
            $("#mensaje").html("Estamos trabajando ");
        }
    });
    //Paginando Torneos
    $(document).on('click','.page-link',function(e)  {
        var page = $(this).attr('data-id');
        $.ajax({
            method: "POST",
            url: "MyTournament.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#data_table').html(data.html);
           $('#paginacion').html(data.pagination);
          });
                  
    });
    //Cargamos el icono de ajaxloader y la lista de personas
    //readRecords();
    
    //Link de documentos a visualizar
    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        var url = $(this).attr('href');
        var target = $(this).attr('target');
        if(url) {
            // # open in new window if "_blank" used
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }          
    });
   
    
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });

});
</script>
  
</body>

</html>
