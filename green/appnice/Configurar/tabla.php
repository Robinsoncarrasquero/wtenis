<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

 <!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Configuracion</title>
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
    
  
    <!-- awesone -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
   
    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    
    
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
     
    
    


    
 	
		
</head>
<body>

   

<div class="form-group">
        <input type="text" id="inputText1" required>
        <input type="text" id="inputText2" required>
        <input type="text" id="inputText3" required>
        <input type="text" id="inputText4" required>
        <input type="text" id="inputText5" required>
        <input type="text" id="inputText6" required>
             
<div class="table-responsive">
        <table class="table table-striped table-bordered table-condensed" id="myTable" style="width:90%; margin:0 auto;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Nivel</th>
                    <th>DUI</th>
                    <th>ISSS</th>
                    <th>ISSS</th>
                   
                </tr>
            </thead>
            <tbody>
                <tr id="td1" >
                    <td >TD 1 Last Name</td>
                    <td>Last Name</td>
                   <td>Last Name</td>
                    <td>Last Name</td>
                   <td>Last Name</td>
                    <td>Last Name</td>
                   <td><button name="1" id="select">Modificar</td>
                </tr>
                 <tr id="td2">
                    <td >TD 2 Last Name</td>
                    <td>Last Name</td>
                   <td>Last Name</td>
                    <td>Last Name</td>
                   <td>Last Name</td>
                    <td>Last Name</td>
                    
                    <td><button name="2" id="select">Modificar</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
$(document).ready(function () {

     $("#myTable").on('click', '#select', function (e) {
         e.preventDefault();
         var idbutton=$(this).attr('name');
         var currentRow = $("#td"+idbutton);
       
         $("#inputText1").val(currentRow.find("td:eq(0)").text() );
         $("#inputText2").val(currentRow.find("td:eq(1)").text() );
         $("#inputText3").val(currentRow.find("td:eq(2)").text() );
         $("#inputText4").val(currentRow.find("td:eq(3)").text() );
         $("#inputText5").val(currentRow.find("td:eq(4)").text() );
         $("#inputText6").val(currentRow.find("td:eq(5)").text() );
    });
});
</script>
</body>
</html>