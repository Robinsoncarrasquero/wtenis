<?php
session_start();
include_once '../funciones/funciones_bootstrap.php';
include_once '../funciones/funciones.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../sql/ConexionPDO.php';

 if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}

$torneo_id=$_GET['tid'];
//print_r($_SESSION['empresa_id']);
$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
$categoria=$objTorneo->getCategoria();
$cat=  explode(',', $categoria);



$datostorneo=[];
foreach ($cat as $catego){
    
    $datostorneo[] = array('torneo_id'=>$torneo_id,'categoria'=>substr($catego,0,2),'sexo'=>"F");
    $datostorneo[] = array('torneo_id'=>$torneo_id,'categoria'=>substr($catego,0,2),'sexo'=>"M");
}


?>


<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../css/tenis_estilos.css">
    
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
       
    </head>
   <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>
  
<body>
    
<div class="container-fluid">
   
        <div class="col-md-12">
            <h3>Panel Creacion de Lista de Aceptacion</h3>
             <?php
            //Para generar las miga de pan mediante una clase estatica
            require_once '../clases/Bootstrap2_cls.php';
            echo Bootstrap::breadCrumDraw();

            ?>
            <div class="pull-right">
<!--                 <a class="btn btn-primary" href="bsPanel.php" role="button">Retornar</a>-->
<!--                <button class="btn btn-warning Procesar"  data-id="1" id="Procesar">Procesar</button>-->
                <button class="btn btn-success edit-record"  data-id="0" id="btnLista">Actualizar Lista</button>
                <button class="btn btn-success edit-record"  data-id="1" id="btnSave">Guardar Lista</button>
               
                <button class="btn btn-default edit-record"  data-id="2" id="btnAddJugador">Add Jugador</button>
                <button class="btn btn-default edit-record"  data-id="4" id="btnPuntaje">Resultados</button>
            </div>
        </div>
   
</div>
  
<div class="container-fluid"  > 
    <div class="col-md-12">
       
            <!-- Section de Calendario de Torneos -->
            <h5  class="title-table">TORNEO : <?php echo $objTorneo->getNombre() ." GRADO :". $objTorneo->getTipo()?></h5>
           
            <div  id="results">
            
            </div>
            <ul class="nav nav-pills nav-pills-meses">
               <?php
             
               foreach ($cat as $catego){
             
                   $bagef= TorneosInscritos::Count_Categoria($torneo_id, substr($catego,0,2), 'F');
                   $bagem= TorneosInscritos::Count_Categoria($torneo_id, substr($catego,0,2), 'M');
                   $data_idF=$torneo_id."-".substr($catego,0,2)."-F";
                   $data_idM=$torneo_id."-".substr($catego,0,2)."-M";
                   
                   echo  '<li role="presentation" class="edit" data-id="'.$data_idF.'"><a href="#">'.$catego.' FEM'.'<span class="badge">'.$bagef.'</span></a></li>';
                   echo  '<li role="presentation" class="edit" data-id="'.$data_idM.'"><a href="#">'.$catego.' MAS'.'<span class="badge">'.$bagem.'</span></a></li>';
               }   
               
               ?>
               </ul>
             
            <div class="calendario2">
            
            </div>
            
                    
            <div id="list">
                 
            </div>
         
             
           
        
   </div> <!-- Fin de orw container Principal -->
    
  
</div>

    


   
<!--<script src="js/jquery-1-12-4.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>-->




<script>

$(document).ready(function(){
   
    
    //Variable global para controlar la categoria
    var cind ;
    var tid ;
    
    // Manejamos la tabla de meses tabuladas con pildoras 
    // Al seleccionar un mes disparamos un ajax para presentar
    // el calendario
    $('.nav-pills-meses li').click(function(e){
        
        e.preventDefault();
        $("#results").html('');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            cind = $(this).index() + 1;
            tid=$(this).closest('li').attr('data-id');
           
            var data_array = tid.split("-");
            $("#list").html('');
            $('#list').addClass('loader');
            $('#results').removeClass("alert alert-info");
            readRecords(data_array[0],data_array[1],data_array[2]);
        }
       
    });
    
    $('#btnDraw').click(function(e){
        
        e.preventDefault();
          
        if(tid!=undefined){
            var url ='Torneo_Draw_Draw.php?tid='+tid +'&catid='+cind;
            var target='_blank';
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }
       
    });
    
    
     $('#btnPuntaje').click(function(e){
        
        e.preventDefault();
          
        if(tid!=undefined){
            var url ='torneo_puntuacion_menu_categorias.php?tid='+tid +'&catid='+cind;
            var target='_blank';
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }
       
    });
    
    
    
    //Manejamos el save de la posicion para guardar
   $('#btnSave').click(function(e){
        e.preventDefault();
        
       var ok =confirm('Esta seguro de Guardar la Lista');
      
        $("#results").html('');
        $('#list').addClass('loader');
        $('#results').removeClass("alert alert-info");
        
        if (ok){
            var datajson  = new Array();
            var condicion=0; var i=0;var id=0;var sds=0;
            $( "select option:selected" ).each(function() {
                
                sds++;
                chkValue = $( this ).val();
                var data_array_select = chkValue.split("-");
                id = data_array_select[0];
                condicion=data_array_select[1];
                //alert ('Index :'+$(this).index());
                
                
                
                if (sds===1){
                    i ++ ; 
                    //condicion = parseInt($( this ).text());
                    //id=parseInt( $( this ).val());
                    datajson[i] = new Object();
                    datajson[i].id = id;
                    datajson[i].posicionlista=i;
                    datajson[i].condicion=condicion;
                    sds=0;
                }
//                $( "li" ).each(function( index ) {
//                console.log( index + ": " + $( this ).text() );
//              });
                
            });
          
            var myString = JSON.stringify(datajson); 
            //alert('json '+myString);
            
            var data_array = tid.split("-");
            
           
            $.post("TorneoListaAceptacionCreaLista_Save.php", 
            {tid:tid,datajson:myString},
            function(html){
                $('#list').removeClass('loader');
                $('#list').html(html);
                if (html!==''){
                    $('#results').addClass("alert alert-info");
                    $('#results').html("Lista Aceptacion Guardada con exito ");
                }
                readRecords(data_array[0],data_array[1],data_array[2]);
            });
        }
       
    
    });
    
       
   //Cargamos la lista de aceptacion
   $('#btnLista').click(function(e){
        e.preventDefault();
       
        $("#results").html('');
        $('#list').addClass('loader');
        $('#results').removeClass("alert alert-info");
        var data_array = tid.split("-");    
        if (tid!=undefined){
           
             readRecords(data_array[0],data_array[1],data_array[2]);
            $('#list').removeClass('loader');
            $('#list').html(html);
            
            }
        });
       
    
    
    
    
   
    
    $('#btn-salir').click(function(){
        var url =$(this).attr('href');
        var target =$(this).attr('target');
        if(url) {
           // # open in new window if "_blank" used
           if(target == '_blank') { 
               window.open(url, target);
           } else {
               window.location = url;
           }
        }  
            
    });
    
    // Cargamos la lista de items
    function readRecords(tid,categoria,sexo) {
        
       
        
        $('#list').html('');
        $.post("TorneoListaAceptacionCreaLista_Load.php", 
        {tid:tid,categoria:categoria,sexo:sexo},
        function (data, status) {
            // reload Users by using readRecords();
            $("#list").html(data);
            

        });
        

    }
    
    
    $('#btnAddJugador').click(function(){
        var url ="TorneoListaAceptacionJugadorAdd.php?tid="+tid +'&catid='+cind;
        var target ="_blank";//$(this).attr('target');
        var data_array = tid.split("-");    
        if (tid!=undefined) {
           // # open in new window if "_blank" used
           if(target == '_blank') { 
               window.open(url, target);
           } else {
               window.location = url;
           }
        }  
            
    });
    
    
      
    
    
    
 
});



	
</script>


</body>