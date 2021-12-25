<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../clases/Funciones_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once  '../clases/Atleta_cls.php';
require_once  '../clases/Torneos_cls.php';
require_once  '../clases/Torneos_Inscritos_cls.php';
require_once '../funciones/bsTemplate.php';

if (!isset($_SESSION['atleta_id'])){
    $_SESSION['asociacion']='FVT';
    header("location: ../Login.php");
    exit;
}

//Tabla de atleta
$objAtleta= new Atleta();
$objAtleta->Find($_SESSION['atleta_id']);
    // require_once '../niceadmin/header.html';
    // require_once '../niceadmin/aside.html';

    echo bsTemplate::header('Mis Ranking',$_SESSION['nombre']);
    echo bsTemplate::aside();
    
    
    echo '<div class="col-xs-12">';
        echo '<h6 class="titulo-name">Ranking Nacional de :'.($objAtleta->getNombreCorto()).'</h6>';
        echo '<h4  hidden id="token_id">'.Encrypter::encrypt($objAtleta->getID()).'</h4>';
        echo '<h4  hidden id="sexo">'.$objAtleta->getSexo().'</h4>';
    echo '</div>'; //Container    

        
?>
             


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- <div class="col-xs-12 ">
                        <div class="col-xs-4">
                            <img class="img-responsive"   src="../images/logo/fvtlogo.png" ></img>
                        </div>
                        <div class="col-xs-offset-4 col-xs-4">
                            <img id="avatar"  src="../uploadFotos/perfil/foto.jpg" ></img>
                        </div>

                    </div> -->
                    <div class="eborder-top">
                    
                        <div class="col-xs-4">
                            <span class="profile-ava">
                                <!-- <img id='avatar' alt="" src="../niceadmin/img/avatar1_small.jpg"> -->

                                <img class="img-responsive" width="50%"  src="../uploadFotos/perfil/female.jpg" ></img>
                            </span>
                        </div>
                        <div class="col-xs-offset-4 col-xs-3">
                            <img class="img-responsive"   src="../images/logo/logo_jugador.png" ></img>
                        </div>
                        
                    </div>
           
                    <div class="col-xs-10">
                        Tenista :<span class=" small text text-danger" id="header"></span>
                    </div>
                    
                    <div class="col-xs-12">
                        Puntos :<span class="small text text-danger" id="puntos"></span>
                    </div>
                    <div class="col-xs-12" id="detail">

                    </div>
             
                </div>
            </div>
          </div>
        </div>
        
        <div id="mensaje" >

        </div>

        <div id="results">

        </div>

        <div id="paginacion" class="text text-center ">

        </div>

         
    <?php echo bsTemplate::footer();?>

<script>

$(document).ready(function(){
    
    var id=$("#token_id").text();
    var sexo=$("#sexo").text();
    if (sexo==="M"){
        $("#avatar").attr("src","../uploadFotos/perfil/foto.jpg");
    }else{
        $("#avatar").attr("src","../uploadFotos/perfil/female.jpg");
    }
    
       
    $("#mensaje").html('');
    $("#results").html('');
    $.ajax({
        method: "POST",
        url: "RankingByAtletaLoad2.php", 
        data:  {id:id,pagina:0}
    })
    .done(function( data) {
       $('#mensaje').removeClass('loader');
       $('#results').html(data.html);
       $('#paginacion').html(data.pagination);
       
    });
    
    
    //Ranking detallado
    $("#myModal").on('show.bs.modal', function(e){
       
        var button = $(e.relatedTarget); // Button that triggered the modal
        var rkid = button.data('whatever'); // Extract info from data-* attributes
        var id = button.data('id'); // Extract info from data-* attributes
        
        $.ajax({
        method: "POST",
        url: "RankingDetail.php", 
        data: {rkid:rkid,id:id}
        })
        .done(function( data) {
        console.log(data.html);
           if (!data.html) return e.preventDefault(); // stops modal from being shown
           $('#header').html('<i class="small">'+data.Nombre+"</i>");
           $('#puntos').html('<i class="small">'+data.Puntos+"</i>");
           $('#detail').html('<i class="small">'+data.html+"</i>");
        
        });
        
    });
     
    //Ranking detallado
    $(document).on('click','.page-link',function(e)  {
        e.preventDefault();
        var page = $(this).attr('data-id');
        $.ajax({
            method: "POST",
            url: "RankingByAtletaLoad2.php", 
            data:  {id:id,pagina:page}
        })
        .done(function( data) {
           $('#mensaje').removeClass('loader');
           $('#results').html(" ");
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
           
        });
                  
    });
        
        
     
});

</script>

</body>
</html>