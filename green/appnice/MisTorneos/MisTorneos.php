<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/Imagenes_cls.php';
require_once '../clases/Atleta_cls.php';
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/bsTemplate.php';

if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../../login.php');
    exit;
}

if($_SESSION['niveluser']!=0){
    header('Location: ../../sesion_inicio.php');
    exit;
}
//Tabla de atleta
$objAtleta= new Atleta();
$objAtleta->Find($_SESSION['atleta_id']);
    // require_once '../niceadmin/header.html';
    // require_once '../niceadmin/aside.html';

    echo bsTemplate::header('Mis Torneos',$_SESSION['nombre']);
    echo bsTemplate::aside();
    
    echo '<div class="col-xs-12">';
        echo '<h6 class="titulo-name">Ranking Nacional de :'.($objAtleta->getNombreCorto()).'</h6>';
        echo '<h4  hidden id="token_id">'.Encrypter::encrypt($objAtleta->getID()).'</h4>';
        echo '<h4  hidden id="sexo">'.$objAtleta->getSexo().'</h4>';
    echo '</div>';

?>

<div class="col-xs-12" >
    

        <div id="mensaje" >

        </div>

        <div id="results">

        </div>

        <div id="paginacion" class="text text-center ">

        </div>

</div>
       
<?php echo bsTemplate::footer();?>


<script>

$(document).ready(function(){
    var id=$("#token_id").text();
    $("#mensaje").html('');
    $("#results").html('');
    $.ajax({
        method: "POST",
        url: "MyTournament.php",
        dataType: "json",
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
        if (data.Success){
             $('#results').html(data.html);
             $('#paginacion').html(data.pagination);
        }else{
            $('#results').html(data.status);
             
        }
        console.log(data.status);
    })
    .error(function(xhr){
        alert("An error occured: " + xhr.status + " " + xhr.statusText);
    });
    //Paginando Torneos
    $(document).on('click','.page-link',function(e)  {
        var page = $(this).attr('data-id');
        e.preventDefault();
        
        $.ajax({
            method: "POST",
            url: "MyTournament.php", 
            dataType: "json",
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
            $('#results').html(data.html);
            $('#paginacion').html(data.pagination);
            console.log(data.html);
        })
        .error(function(xhr){
          alert("An error occured: " + xhr.status + " " + xhr.statusText);
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