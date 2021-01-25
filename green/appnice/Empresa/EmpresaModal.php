<?php
session_start();
if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
    $atleta_id = $_SESSION['atleta_id'];
   
 }else{
    //Si el usuario no está logueado redireccionamos al login.
   $logueado=false;
   header('Location: ../sesion_inicio.php');
  
 }
 if ($_SESSION['niveluser']!=9){
     header('Location: ../sesion_inicio.php');
 }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Asociacion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
            
    </style>
    

    <!--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  	<script <source src="js/bootstrap.js"></script>-->

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    

    

  	
		
</head>
<body>
	

<div class="container">
    <h3>Configuracion</h3>
        <div class="row-fluid">

                <div id="list" class="span6">
                </div>
                
                <div id="results" class="span6">
               
                </div>

        </div>

</div>


<div class="modal fade" id="dialog-example" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
      <form class="modal-content" action="EmpresaModalSave.php" id="forma" method="POST">
        
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Record</h4>
          </div>
          <div class="modal-body">

            
          </div>
        <div id="results">
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button type="submit" id="btnSave" class="btn btn-primary">Guardar</button>
          </div>
        
    </form>
  </div>
</div>
    
	
	
   <!--<script <source src="js/jquery-3.1.1.min.js"></script> -->
	 <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
	
 
<script>

$(function (){
    //Cargamos el icono de ajaxloader y la lista de personas
    $('#list').addClass('loader');
    $("#list").load("EmpresaModalList.php",function(){;
        $("#list").removeClass('loader');
    });

    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();

        //var x =$(this).attr('data-id');
        //alert('esta es la data '+ x);
        $(".modal-body").html('');
        $(".modal-body").addClass("loader");
        $('#dialog-example').modal('show');

        //$(".modal-title").html('<b>Editar esto</b>')

        $.post("EmpresaModalEdit.php",
            {operacion: "Edit",id: $(this).attr('data-id')}, 
            function(html){
                    $('.modal-body').removeClass('loader');
                    $('.modal-body').html(html);

            }

        );
    });
    //Aqui salvamos la data modificada la enviamos mediante ajax post
    $('#btn-Save').click(function(){
           $.post("edit2xxx.php",
           {operacion: "Save",id: $(this).attr('data-id'), fvtMonto: fvt}, 
            function(html){
                     $('.modal-body').html(html);
                    alert('Procesos '+ $("#fvtMonto").val());
           }

        );
        $('#dialog-example').modal('hide');    
            
    });
    //Aqui regresamos a la ventana anterior
    $('#btn-salir').click(function(){
         //alert('Pulsaron salir');
        location.href = this.href; // ir al link    
            
    });
    
    
//    $("button").click(function(){
//        var x = $("form").serializeArray();
//        $.each(x, function(i, field){
//            $("#results").append(field.name + ":" + field.value + " ");
//        });
//    });
    
    $('.modal form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          type: $(this).attr('method'),
          data: { data: $(this).serializeArray() }
        })
        .done(function(response) {
           
           if(response.status === "OK") {
    //            console.log(JSON.stringify(response));
    //            var status = response.status;
    //            $("#results").html("Servidor:<br><pre>"+JSON.stringify(response, null, 2)+"</pre>");

             $('.modal').modal('hide');
          } else {
            $('#results').html('<p>No pudimos actualizar</p>');
          }
        })
        
        .fail(function( xhr, status, errorThrown ) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
        })
        
        
    });
    
    
    



});



	
</script>
  	 
</body>
</html>

