<?php
session_start();
require_once  '../funciones/funciones_bootstrap.php';

require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';

 
 if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}

// $_SESSION['empresa_id']=1;
//print_r($_SESSION['empresa_id']);
?>


<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="../css/tenis_estilos.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
           
    </head>
    <style>
       
                
        
       
    </style>
<body>
    


<div class="container-fluid">
   
        <div class="col-md-12">
            <h3>Panel de Calendario de Torneos</h3>
            <?php
            //Para generar las miga de pan mediante una clase estatica
            require_once '../clases/Bootstrap2_cls.php';
            echo Bootstrap::breadCrumTorneos();

            ?>
            <div class="pull-right">
                <button class="btn btn-success edit-record"  data-id="0" id="New">Add New</button>
                
<!--                <a class="btn btn-primary" href="bsPanel.php" role="button">Retornar</a>-->
            </div>
        </div>
    
    
    
</div>
    
  

           
<div class="container-fluid">
   
       <div class="col-md-12">
            <!-- Section de Calendario de Torneos -->
            <h4 id="xcalendario" class="title-table">CALENDARIO</h4>
            
            <ul class="nav nav-pills nav-pills-meses ">
                <li role="presentation"><a href="#"   class="edit-record" data-id="<?PHP echo $_SESSION['empresa_id']?>">Ene</a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Feb</a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Mar</a></li>
                <li role="presentation"><a href="#"  class="edit-record>">Abr</a></li>
                <li role="presentation"><a href="#"   class="edit-record" >May</a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Jun</a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Jul</a></li>
                <li role="presentation"><a href="#"   class="edit-record" >Ago</a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Sep</a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Oct</a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Nov</a></li>
                <li role="presentation"><a href="#"  class="edit-record" >Dic</a></li>
            </ul>
             
            <div class="calendario">
            
            </div>
             <div id="results">
            
            </div>
            
        </div> 
   
    
  
</div>
    


   
<!--<script src="js/jquery-1-12-4.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>-->




<script>

$(function (){
    
  // Manejamos la tabla de meses tabuladas con pildoras 
  // Al seleccionar un mes disparamos un ajax para presentar
  // el calendario
    $('.nav-pills-meses li').click(function(e){
        
        e.preventDefault();
         $("#results").html('');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            var mes = $(this).index() + 1;

            //alert("Mes : " + mes );

            var emp=$(".edit-record").attr('data-id');
            //  alert("Empresa : " + emp );


            $(".calendario").html('');
            $('.calendario').addClass('loader');

            $.post("bsTorneo_Read_Load_Calendario.php",
                {empresa_id:emp,mes: mes}, 
                function(html){
                        $('.calendario').removeClass('loader');
                        $('.calendario').html(html);
            });

            $('.calendario').show(100);
        }else{
            
            $('.calendario').toggle(100);

        }
       
    });
    
    //Eliminar un Registro de la lista
    $(document).on('click','.delete-record',function(e)  {
        e.preventDefault();
        $("#results").html('');
        var conf = confirm("Estas Seguro de eliminar este registro? "+$(this).attr('data-id'));
        if (conf == true) {
            $.post("bsTorneo_Delete.php", 
            {operacion:"Del",id: $(this).attr('data-id')},
            function (data, status) {
                // reload Users by using readRecords();
                $("#results").html("Respuesta: " + data);
                
            });
        }
    });
    
       
     // definimos lo que queremos hacer en el click primero 
    $('#New').click(function(){
        var href='bsTorneo_Edit.php';
        //location.href = href; // ir al link    
        
        var url = href; //$(this).attr('href');
        var target ='_blank'; //$(this).attr('target');
        
        if(url) {
            // # open in new window if "_blank" used
            if(target == '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
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
    
    
    
    
    
    
    //Ocultar las noticias
    
    
    //Editamos el registro nuevo o update
   
    
    
   
    
    

    
   
   
    
   
});



	
</script>



</body>
 




