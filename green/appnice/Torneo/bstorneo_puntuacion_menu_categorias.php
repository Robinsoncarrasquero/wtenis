<?php
session_start();
include_once '../funciones/funciones_bootstrap.php';
include_once '../funciones/funciones.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';

 if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<8){
    header('Location: ../sesion_usuario.php');
    exit;
}

$torneo_id=$_GET['tid'];
//print_r($_SESSION['empresa_id']);
$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
$categoria=$objTorneo->getCategoria();
$estado=$objTorneo->getAsociacion();
$cat=  explode(',', $categoria);

$datostorneo=[];
foreach ($cat as $catego){
    
    $datostorneo[] = array('torneo_id'=>$torneo_id,'categoria'=>substr($catego,0,2),'sexo'=>"F");
    $datostorneo[] = array('torneo_id'=>$torneo_id,'categoria'=>substr($catego,0,2),'sexo'=>"M");
}


?>


<!Doctype html>
<html lang="en">
    <head>
        <title>Cargar Puntuacion</title>
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../css/tenis_estilos.css">
        <link rel="stylesheet" href="../css/master_page.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
       
    </head>
    
  
<body>
    
<div class="container-fluid">
        
        <?php  
            //Menu de usuario
            include_once '../Template/Layout_NavBar_Arbitro.php';
            echo '<br><hr>';
        ?> 
            <div>
                <h3>Puntuacion de Torneo  </h3>
                <p><a href="../Torneo/bsTorneo_Read.php" class="glyphicon glyphicon-backward"></a></p>
            </div>
    
            <div class="pull-right">
<!--                 <a class="btn btn-primary" href="bsPanel.php" role="button">Retornar</a>-->
<!--                <button class="btn btn-warning Procesar"  data-id="1" id="Procesar">Procesar</button>-->
              
                <button class="btn btn-success edit-record"  data-id="0" id="Save">Guardar</button>
                <button class="btn btn-default edit-record"  data-id="2" id="Printer">Imprimir</button>
            </div>
        </div>
   
 
    <div class="col-md-12">
       
            <!-- Section de Calendario de Torneos -->
            <h4  class="title-table">TORNEO : <?php echo $objTorneo->getNombre()." - ".($objTorneo->getEntidad())?></h4>
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
            
                    
            <div id="puntos">
                 
            </div>
         
             <div  id="results2">
            
            </div>
           
        
   </div> 
      
</div>
    
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
        $("#results2").html('');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            cind = $(this).index() + 1;
            tid=$(this).closest('li').attr('data-id');
            var data_array = tid.split("-");
            //alert("Categoria : " + cind );

            //alert("Torneo : " + tid );

            
            $("#puntos").html('');
            $('#puntos').addClass('loader');
            $('#results2').removeClass("alert alert-info");
            $.post("bstorneo_puntuacion_resumen_categoria.php",
           
                {tid:data_array[0],catid: data_array[1],sexo:data_array[2]}, 
                function(html){
                        $('#puntos').removeClass('loader');
                        $('#puntos').html(html);
                       
            });

            $('.calendario2').show(100);
        }else{
            
            $('.calendario2').toggle(100);

        }
       
    });
    
    $('#Printer').click(function(e){
        
        e.preventDefault();
        var data_array = tid.split("-");
        var url ='bstorneo_puntuacion_resumen_categoria_print.php?tid='
                +data_array[0] +' &catid='+data_array[1] +" &sexo="+data_array[2];
        var target='_blank';
        if(target === '_blank') { 
            window.open(url, target);
        } else {
            window.location = url;
        }
        
       
    });
    
    
    //Eliminar un Registro de la lista
    $(document).on('click','.Procesar',function(e)  {
        e.preventDefault();
        $("#results2").html('');
        var conf = confirm("Estas Seguro de Actualizar Ranking? "+$(this).attr('data-id'));
        if (conf == true) {
            $.post("bstorneo_puntuacion_menu_categorias_procesark.php", 
            {operacion:"Del",id: $(this).attr('data-id')},
            function (data, status) {
                // reload Users by using readRecords();
                $("#results2").html("Respuesta: " + data);
                
            });
        }
    });
    
       
     // definimos lo que queremos hacer en el click primero 
    $('#Save').click(function(e){
        e.preventDefault();
        $("#results2").html('');
        var puntos='';
         
        var concatValor='';
         
        var myjson='';
        if ($(".nav-pills-meses li").hasClass("active")){
//               var myObject = new Object();
//                myObject.name = "John";
//                myObject.age = 12;
//                myObject.pets = ["cat", "dog"];
//                myObject = Object();
//                myObject.name = "luis";
//                myObject.age = 30;
//                myObject.pets = ["dog", "cat"];
//                var myString = JSON.stringify(myObject); 
                
                //Aqui generamos un objeto json para manejar los
                //puntos y sanciones. dado que vienen de dos select
                //al momento de recorrer se debe tomar en cuenta los
                //pares que son los puntos de sanciones y los impares 
                //los puntos del torneo
               var datajson = {  };
               datajson = new Array();
               var r=0; 
               var i=0;
               var sancion=0; var puntos=0; var puntosdoble;
               var sds=0; //Varible para saber que listbox esta activo
            $( "select option:selected" ).each(function() {
                r = r + 1;
                sds= sds + 1;
                var id= $( this ).val();
                var res=r%2 ;
//                if (res==0){
//                    sancion = $( this ).text();
//                }else{
//                    puntos = $( this ).text();
//                }
                if (sds===1){
                    puntos = $( this ).text();
                }
                if (sds===2){
                    puntosdoble = $( this ).text();
                }
                if (sds===3){
                    sancion = $( this ).text();
                }
                if (sds===3){
                    
                    datajson[i] = new Object();
                    datajson[i].id = id;
                    datajson[i].singles=puntos;
                    datajson[i].dobles=puntosdoble;
                    datajson[i].penalidad = sancion;
                    puntos=0;
                    sancion=0;
                    i= i + 1;
                    sds=0;
                }
                
                 
                if ($(this).val() !== "" ){        
                    concatValor += $(this).val()+' - '+$(this).text()+'\n';
                    if (myjson!==''){
                        myjson += ",";
                    }
                    myjson +=  + id + ":" +  puntos ;
                   
                }
           });
            myjson += '';
            var myString = JSON.stringify(datajson); 
            //alert('json '+myString);
            
            var data_array = tid.split("-");
            //alert("Categoria : " + tid );
            $.post("bstorneo_puntuacion_resumen_categoria_save.php", 
            {catid:data_array[1],tid:data_array[0],sexo:data_array[2],datajson:myString},
            function(html){
                $('#puntos').removeClass('loader');
                $('#puntos').html(html);
                if (myjson!==''){
                    $('#results2').addClass("alert alert-info");
                    $('#results2').html("Datos Guardados con exito ");
                }
            });
        }
    
    });
    
    function myFunction(){
            alert("la function");
            var datajson = {  };
            datajson = new Array();
            var r=0; 
            var i=0;
            var sancion=0; var puntos=0; var puntosdoble;
            var sds=0; //Varible para saber que listbox esta activo
            $( "select option:selected" ).each(function() {
                 r = r + 1;
                 sds= sds + 1;
                 var id= $( this ).val();
                 var res=r%2 ;
                
                if (sds===1){
                     puntos = $( this ).text();
                 }
                 if (sds===2){
                     puntosdoble = $( this ).text();
                 }
                 if (sds===3){
                     sancion = $( this ).text();
                 }
                 if (sds===3){

                     datajson[i] = new Object();
                     datajson[i].id = id;
                     datajson[i].singles=puntos;
                     datajson[i].dobles=puntosdoble;
                     datajson[i].penalidad = sancion;
                     puntos=0;
                     sancion=0;
                     i= i + 1;
                     sds=0;
                 }


                 if ($(this).val() !== "" ){        
                     concatValor += $(this).val()+' - '+$(this).text()+'\n';
                     if (myjson!==''){
                         myjson += ",";
                     }
                     myjson +=  + id + ":" +  puntos ;

                 }
            });
             myjson += '';
             var myString = JSON.stringify(datajson); 
             //alert('json '+myString);

             var data_array = tid.split("-");
             //alert("Categoria : " + tid );
             $.post("bstorneo_puntuacion_resumen_categoria_save.php", 
             {catid:data_array[1],tid:data_array[0],sexo:data_array[2],datajson:myString},
             function(html){
                 //$('#puntos').removeClass('loader');
                 //$('#puntos').html(html);
                 if (myjson!==''){
                     $('#results2').addClass("alert alert-info");
                     $('#results2').html("Datos Guardados con exito ");
                 }
             });
         
        
    }
    
    $('#btn-salir').click(function(){
        
        
        var url =$(this).attr('href');
        var target =$(this).attr('target');
      
        if(url) {
            // # open in new window if "_blank" used
            if(target === '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }  
            
    });
//    $( "select" )
//  .change(function() {
//    var str = "";
//    $( "select option:selected" ).each(function() {
//      str += $( this ).text() + " ";
//    });
//    $( "#results" ).text( str );
//  })
//  .trigger( "change" );
//    
  
   
    
   
});



	
</script>


</body>
</html>