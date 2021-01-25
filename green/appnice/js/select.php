<!--<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>change demo</title>
  <style>
  div {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body>-->

<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="css/tenis_estilos.css">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
       
    </head>
    <style>
  
    </style>
  
<body>
<div  class="table">  
    <table class="table table-bordered table-condensed">
         <thead >
            <tr class="table-head ">
                <th><p class="glyphicon glyphicon-dashboard"<p></th>


            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <select class='xx' name="sweets" >
                    <option value='5'>Chocolate</option>
                    <option value='10'>Candy</option>
                    <option value='15'>Taffy</option>
                    <option value='20'>Caramel</option>
                    <option value='25'>Fudge</option>
                    <option value='30'>Cookie</option>
                  </select>
            </td>
        </tr>
        <tr>
            <td>
                <select class='xx2' name="sweets2" >
                    <option value='5'>Chocolate</option>
                    <option value='10'>Candy</option>
                    <option value='15'>Taffy</option>
                    <option value='20'>Caramel</option>
                    <option value='25'>Fudge</option>
                    <option value='30'>Cookie</option>
                  </select>
            </td>
        <tr>
        <tr>
            <td>
                <select class='xx3' name="sweets3" >
                    <option value='5'>Chocolate</option>
                    <option value='10'>Candy</option>
                    <option value='15'>Taffy</option>
                    <option value='20'>Caramel</option>
                    <option value='25'>Fudge</option>
                    <option value='30'>Cookie</option>
                  </select>
            </td>
            
        </tr>
        </tbody>
    </table>
</div>
    

    

<div id='results'></div>
 
<script>
$( "select" )
  .change(function () {
    var str = "";
     var Id = $(this).attr( "name" );
     var valor=$( this ).val() + " ";
    alert('ID: '+Id);
    alert('vallor: '+valor);
     
    $( "select option:selected" ).each(function() {
      str += $( this ).text() + " ";
       str += $( this ).val() + " ";
    });
    $( "#results" ).text( str );
  })
  //.change();
</script>
  
</body>

 
</html>
