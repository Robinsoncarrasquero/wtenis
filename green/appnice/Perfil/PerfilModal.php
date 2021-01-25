<?php
session_start();
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

require_once '../clases/Bootstrap2_cls.php';
 if (isset($_SESSION['niveluser'])){ 
    if ($_SESSION['niveluser']>0){
     header('Location: ../bsPanel.php'); 
     exit;
    }
}else{
    header('Location: ../sesion_inicio.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Perfil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
  
    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
</head>
<body>
<div class="container">
    <div class="row">
        
  

    <?php   
        
        //Container
        echo '<div class="container">';
        echo '<div class="row">';
          Bootstrap::master_page();
        echo '</div>';
        echo '</div>'; //Container   

    ?>
   </div>
</div>     

<div class="container">
    <div class="row">
        <div class="col-sx-12">
            
                
                <form  id="myform"  method="POST"   > 
                    
                   
                    <div id="list" class="col-sx-12">
                    </div>
                     <div id="results" >          

                     </div>     
                    
                </form>
               
        </div>
    </div>
</div>
<!-- /Content Section -->


	
 
<script>

$(function (){
    
    
    //Cargamos el icono de ajaxloader y la lista de personas
    readRecords();
    
 
    //Buscamos que boton fue pulsado durante un update o new record
    // y cargar nuevamente los registros
    $('#myform').on('click','.btnbtn',function(e){
        
        
        var op =$(this).attr('id'); // Nos indica que operacion Save o Close
       
         if (op!=='close'){
              
            var f = $(this);
            var formData = new FormData(document.getElementById("myform"));
            formData.append("operacion", op);
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "PerfilModalSave.php",
                type: "POST",
                data:formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response){
                var status = response.status;
                //var status=response;
                $("#results").html("Respuesta: " + status);

                readRecords();
            })
            .fail(function( xhr, status, errorThrown ) {
            //alert( "Sorry, there was a problem!" );
            $("#results").html("Sorry, there was a problem: " + errorThrown);
            console.log( "Error: " + errorThrown );
            console.log( "Status: " + status );
            console.dir( xhr );
            });
        }else{
           readRecords();

        }
        
        
        
    });
       
    
    
    //Editamos el registro nuevo o update
    $(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        //Cuando data-id es cero representa un nuevo registro y update debe ser mayor> 0 
        var x =$(this).attr('data-id');
        
          // alert('aqui pulsaron ' +x);
           
            $("#results").html('');
//            $('#summernote').summernote('destroy');
            $( "#New" ).prop( "disabled", true );
            $.post("PerfilModalEdit.php",
            {operacion: "Edit",id: $(this).attr('data-id')}, 
            function(html){
                   //$('.modal-body').removeClass('loader');
                  //$('#results').html(html);
                  $('#list').html(html);
                  
                   
              }

        );
    });
   
    //Eliminar un Registro de la lista
    $(document).on('click','.delete-record',function(e)  {
        e.preventDefault();

        var conf = confirm("Estas Seguro de eliminar este registro? "+$(this).attr('data-id'));
        if (conf == true) {
            $.post("PerfilModalDelete.php", 
            {operacion:"Del",id: $(this).attr('data-id')},
            function (data, status) {
                // reload Users by using readRecords();
                //$("#results").html("Respuesta: " + data);
                readRecords();
            });
        }
    });
    
    //Aqui regresamos a una direccion referenciada
    $('#btn-salir').click(function(){
         location.href = this.href; // ir al link    
            
    });
    
    
    // Cargamos la lista de items
    function readRecords() {
      
        $('#list').html('');
        $('#list').addClass('loader');
        $("#list").load("PerfilModalList.php",function(){;
            $("#list").removeClass('loader');
        });
         $( "#New" ).prop( "disabled", false );

    }
 
// function summerNote(){
//    $('#txt_noticia').summernote({
//
//          height: 300,
//          onImageUpload: function(files, editor, welEditable) {
//              sendFile(files[0], editor, welEditable);
//          }
//   });
// }
    

   
function sendFile(file, editor, welEditable) {
   
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: 'PerfilModalSave.php',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
            editor.insertImage(welEditable, url);
        }
    });
}
 
    

   

    
    

});



	
</script>


    
    
 
</body>
</html>

