<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';

if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: ../Login.php');
 }


?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Noticias</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
  
    <!-- awesone -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
   
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    <style >
            .loader{

                    background-image: url("images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

 </head>
<body>
    
<!-- Content Section -->
<div class="container-fluid">
        <?php  
            //Menu de usuario
            include_once '../Template/Layout_NavBar_Admin.php';
            echo '<br><hr>';
        ?>
        <div class="col-md-12">
            <h3>Noticias</h3>
            <div class="pull-right">
<!--               <a href="sesion_usuario_admin.php"> <button id="btn-salir" type="button" class="btn btn-primary">Regresar</button></a>
        -->
                <button class="btn btn-success edit-record"  data-id="0" id="New">Add New</button>
            </div>
<!--            <div class="my-return">
             </div>-->
        </div>
        <div class="col-md-12">
            <form  id="myform"  method="POST"   enctype="multipart/form-data"> 
                    <div id="list" >
                    </div>
            </form>
        </div>
            <div class="col-md-12">
            
                        <div id="results" >          

                        </div>
                        <div id="paginacion" >          

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
        var conten1 =$('textarea[name="content"]').val();
        var conten=$('#summernote').summernote('code');
      
        var op =$(this).attr('id'); // Nos indica que operacion Save o Close
//        if (conten1!==conten){
//            alert("Los conteidos son diferentes submitted" + conten);
//        }
         if (op!=='close'){
            var f = $(this);
            var formData = new FormData(document.getElementById("myform"));
            formData.append("operacion", op);
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "NoticiasModalSave.php",
                type: "POST",
                data:formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response){
               // var status = response.status;
                var status=response;
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
        
          
            $("#results").html('');
            $("#paginacion").html('');
//            $('#summernote').summernote('destroy');
            $( "#New" ).prop( "disabled", true );
            $.post("NoticiasModalEdit.php",
            {operacion: "Edit",id: $(this).attr('data-id')}, 
            function(html){
                   //$('.modal-body').removeClass('loader');
                  //$('#results').html(html);
                  $('#list').html(html);
                  $('#summernote').summernote({height: 300});
                  
                   
              }

        );
    });
   
    //Eliminar un Registro de la lista
    $(document).on('click','.delete-record',function(e)  {
        e.preventDefault();

        var conf = confirm("Estas Seguro de eliminar este registro? "+$(this).attr('data-id'));
        if (conf == true) {
            $.post("NoticiasModalDelete.php", 
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
        
         $( "#New" ).prop( "disabled", false );
         $.ajax({
            method: "POST",
            url: "NoticiasModalList.php", 
            data:  {pagina:0}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
          // console.log(data.pagination);
        });
    }
     //Paginando Ranking
    $(document).on('click','.page-link',function(e)  {
        var page = $(this).attr('data-id');
        
        $.ajax({
            method: "POST",
            url: "NoticiasModalList.php", 
            data:  {pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#results').html(data.html);
           $('#paginacion').html(data.pagination);
          // console.log(data.pagination);
        });
                  
    });
 
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
        url: 'NoticiasModalSave.php',
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

