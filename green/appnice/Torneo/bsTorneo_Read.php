<?php
session_start();
require_once  '../funciones/funciones_bootstrap.php';
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';

if(isset($_SESSION['logueado']) and !$_SESSION['logueado']){
   header('Location: ../Login.php');
   exit();
   
}
if(isset($_SESSION['niveluser']) && $_SESSION['niveluser']==8 ){
   header('Location: ../Torneo/bsTorneo_Read_Arbitro.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/master_page.css">
        <link rel="stylesheet" href="../css/tenis_estilos.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    
    <body>
    
    <div class="container-fluid">
    
        <?php  
            //Menu de usuario
            include_once '../Template/Layout_NavBar_Admin.php';
            echo '<br><hr>';
        ?>
           
    
   
       <div class="col-xs-12">
            <!-- Section de Calendario de Torneos -->
            <h3>Administracion de Torneos</h3>
            <a ><h2 class="glyphicon glyphicon-plus" id="New" data-id="0"  ></h2></a>
            
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

    <script>

    $(function (){
    
    // Manejamos la tabla de meses tabuladas con pildoras 
    // Al seleccionar un mes disparamos un ajax para presentar
    // el calendario
    $('.nav-pills-meses li').click(function(e){
        e.preventDefault();
        $("#results").html('');
        $("#results").removeClass('alert alert-danger');
        $("#results").removeClass('alert alert-success');
        if (!$(this).hasClass("active")){
            $(".nav-pills-meses li").removeClass('active');
            $(this).addClass("active");
            var mes = $(this).index() + 1;
            var emp=$(".edit-record").attr('data-id');
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
    
   
    
    //Delete record
    $(document).on('click','.delete-record',function(e)  {
        e.preventDefault();
        $("#results").html('');
        $("#results").removeClass('alert alert-danger');
        $("#results").removeClass('alert alert-success');
        var conf = confirm("Estas Seguro de eliminar este registro??? ");
        if (conf === true) {
            $.post("bsTorneo_Delete.php", 
            {operacion:"Del",id: $(this).attr('data-id')},
            function (data, status) {
                if (data.Success){
                    $("#results").html("Respuesta: " + data.Mensaje).addClass("alert alert-success");
                    alert(data.Mensaje);
                }else{
                    $("#results").addClass("alert alert-danger").html("Respuesta: " + data.Mensaje);
                    alert(data.Mensaje);
                }
             });
            
        }
    });
    
    //Update record
    $(document).on('click','.update-record',function(e)  {
        e.preventDefault();
        $("#results").html('');
        $("#results").removeClass('alert alert-danger');
        $("#results").removeClass('alert alert-success');
        var url = $(this).attr('href')+"?tid="+$(this).attr('data-id');
        var target =$(this).attr('target');       
        if(target ==='_blank') { 
             window.open(url, target);
        } else {
            window.location = url;
        }
        
    });
   
    // New record
    $('#New').click(function(){
        var href='bsTorneo_Edit.php';
        //location.href = href; // ir al link    
        $("#results").html('');
        $("#results").removeClass('alert alert-danger');
        $("#results").removeClass('alert alert-success');
        var url = href; //$(this).attr('href');
        var target ='_blank'; //$(this).attr('target');
        if(url) {
            if(target === '_blank') { 
                window.open(url, target);
            } else {
                window.location = url;
            }
        }  
            
    });
    
    //Exit
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
      
    });
	
    </script>



    </body>
</html>
 




