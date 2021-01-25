<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneo_Lista_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Atleta_cls.php';

if (isset($_SESSION['logueado']) and $_SESSION['logueado']) {
    $nombre = $_SESSION['nombre'];
    $cedula = $_SESSION['cedula'];
    $email = $_SESSION['email'];
} else {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
}
if ($_SESSION['niveluser'] < 9) {
    header('Location: ../sesion_inicio.php');
    exit;
}

//Recibimos el torneo donde se va a generar el draw y generar el listado de jugadores
$torneo_id = 73;//$_GET['tid'];
$categoria ='14'; // $_GET['categoria'];
$sexo ='F' ; // $_GET['sexo'];
$nrojugadores = Torneo_Lista::Count_Jugadores($torneo_id, $categoria, $sexo);
//Este arreglo para usarlo con json_encode para javascript para disparar consulta
//desde un archivo
$datostorneo = ['torneo_id'=>$torneo_id,'categoria'=>$categoria,'sexo'=>$sexo,'jugadores'=>$numero_jugadores];


//Clave compuesta de torneo para manejar id en javascript
//compuesta por torneo, categoria, sexo y ronda
$key=$torneo_id."-".$categoria."-".$sexo."-".$nrojugadores; 
$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);



?>

<!DOCTYPE html>
<html lang="es">
<head>
	
    
    <title>Genera lista de jugadores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    

    <style >
            .loader{

                    background-image: url("../images/ajax-loader.gif");
                    background-repeat: no-repeat;
                    background-position: center;
                    height: 100px;
            }
    </style>

    <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>-->
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>
    
  		
</head>
<body>
 
<div class="container"  > 
    <div class="row col-md-12">
        <!-- Section de Calendario de Torneos -->
        <h3>Crear Lista de Jugadores para el Draw</h3>
        <h5  >TORNEO : <?php echo $objTorneo->getNombre(). " <b>CATEGORIA :".$categoria." SEXO : ".$sexo."</b>"?></h4>
        
        <div id="results">
            
            
        </div>
        
        <div class="pull-right">
           <button class="btn btn-primary" data-id="<?php echo $key ?>" id="btnSave">Guardar</button>

        </div>  
        
                
    </div> 
  
</div>
    
<div class="container"  > 
    <div class="row col-md-12">

        <div id="list">
            

        </div>
        

    </div> <!-- Fin de orw container Principal -->
</div>
   

<script>

$(document).ready(function (){
    readRecords();
    
    
    //Manejamos el save de la posicion para guardar
   $('#btnSave').click(function(e){
        e.preventDefault();
        
       var ok =confirm('Esta seguro de Actualizar el Draw');
      
        $("#results").html('');
        $('#list').addClass('loader');
        $('#results').removeClass("alert alert-info");
       
        if (ok){
            var datajson  = new Array();
            var posicion=0; var i=0;var id=0;
            $( "select option:selected" ).each(function() {
                i ++ ;
                id=parseInt( $( this ).val());
                posicion = parseInt($( this ).text());
               // alert ('INDICE :'+$(this).index());
                datajson[i] = new Object();
                datajson[i].id = id;
                datajson[i].posicionlista=i;
                datajson[i].posiciondraw=posicion;
//                $( "li" ).each(function( index ) {
//                console.log( index + ": " + $( this ).text() );
//              });
                
            });
          
            var myString = JSON.stringify(datajson); 
            //alert('json '+myString);
            var tid=$(this).attr('data-id');
            $.post("TorneoDrawCreaLista_Save.php", 
            {tid:tid,datajson:myString},
            function(html){
                $('#list').removeClass('loader');
                //$('#list').html(html);
                if (html!==''){
                    $('#results').addClass("alert alert-info");
                    $('#results').html("Datos Guardados con exito ");
                }
                //readRecords();
            });
        }
       
    
    });
    // Cargamos la lista de items
    function readRecords() {
        
        var objdata= <?php echo json_encode($datostorneo);?>;
        
        $('#list').html('');
        $.post("TorneoDrawCreaLista_Load.php", 
        {tid:objdata.torneo_id,categoria: objdata.categoria,sexo:objdata.sexo},
        function (data, status) {
            // reload Users by using readRecords();
            $("#list").html(data);
            

        });
        

    }
    
        
    
   
     
    //Aqui regresamos a una direccion referenciada
    $('#btn-close').click(function(){
         window.close();   
            
    });
    
    
    
    


});



	
</script>
    
</body>
</html>
