<?php
session_start();

require_once '../clases/Torneo_Draw_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';

$torneo_id=73; //Torneo ID
$categoria='14'; //Torneo ID
$sexo='F';






?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
<!--        <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="css/tenis_estilos.css">
    <meta title="Sistema de Tenis de Campo">
    <meta description="Sistema de Gestion de Tenis">
    <meta keywords="IPIN,Tenis,G1,G2,G3,G4,G5,ITF,Sistema de Tenis, Inscripciones, OnLine, Draw, Ranking, Pagos, Afiliacion, Afiliaciones, Asociaciones,Estadales,Regionales, Deporte">
        
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
           
    </head>
    <style>
        nav.navbar {
            background-color: #222;
            
        }
        .jumbotron{
            background:    #67b168;
        }
        iframe{
            width: 100%;
        }
                // Use as-is
                
        hr {
           
            
            
           background-color: red;
           
        }
          
        
        .maindraw1{
            padding:2px;
            
           
        }
        
        #ronda16_p1 {
		position: absolute;
                border: double;
 		left: 1200px;
		top: 115px;
		
	}
        #ronda16_p2 {
		position: absolute;
                border: double;
 		left: 400px;
		top: 250px;
		
	}
        #ronda16_p3 {
		position: absolute;
                border: double;
                
		left: 400px;
		top: 265px;
		
	}
        #ronda16_p4 {
		position: absolute;
                border: double;
                 left: 200px;
		top: 690px;
		
	}
        #ronda16_p5 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 880px;
		
	}
        #ronda16_p6 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 1070px;
		
	}
        #ronda16_p7 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 1260px;
		
	}
        #ronda16_p8 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 1450px;
		
	}
        #ronda16_p9 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 1640px;
		
	}
        
        #ronda16_p10 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 1830px;
		
	}
        
        #ronda16_p11 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 2020px;
		
	}
        #ronda16_p12 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 2210px;
		
	}
        
        #ronda16_p13 {
		position: absolute;
                border: double;
 		left: 200px;
		top: 2400px;
		
	}
        
        #ronda16_p14{
		position: absolute;
                border: double;
 		left: 200px;
		top: 2590px;
		
	}
        
         #ronda16_p15{
		position: absolute;
                border: double;
 		left: 200px;
		top: 2780px;
		
	}
        
        #ronda16_p16{
		position: absolute;
                border: double;
 		left: 200px;
		top: 2970px;
		
	}

	#sota_de_diamantes {
		position: absolute;
		left: 115px;
		top: 115px;
		z-index: 2;
	}
        
        
        
        .maindraw2{
           
            
            padding:2px;
           
        }
        //Ronda de 8
        
        
        
        #ronda8_p1 {
            border: double;
            position: absolute;
            left: 300px;
            top: 215px;
    	}
        #ronda8_p2 {
            border: double;
            position: absolute;      
            left: 300px;
            top: 595px;
                 

		
	}
        #ronda8_p3 {
            border: double;
            position: absolute;
            left: 300px;		
            top: 975px;
          

		
	}
        #ronda8_p4 {
            border: double;
            position: absolute;
            left: 300px;		
 		
            top: 1355px;
                

		
	}
        #ronda8_p5 {
            border: double;
            position: absolute;
            left: 300px;		
            top: 1735px;
               
		
	}
        #ronda8_p6 {
            border: double;
            position: absolute;
            left: 300px;		
            top: 2115px;
                

		
	}
        #ronda8_p7 {
            border: double;
            position: absolute;
            left: 300px;		
            top: 2495px;
            

		
	}
        #ronda8_p8 {
            border: double;
            position: absolute;
            left: 300px;		
            top: 2875px;
      	}
        
       
        .maindraw0{
            padding: 2px;
            
        }
        #ronda32_p1 {
		position: absolute;
                border: double;
 		left: 10px;
                top:90px;
		
	}
        #ronda32_p2 {
		position: absolute;
                border: double;
 		left: 10px;
		top: 120px;
		
	}
        
        #ronda32_p3 {
		position: absolute;
                border: double;
   		left: 10px;
		top: 170px;
		
	}
        #ronda32_p4 {
		position: absolute;
                border: double;
                left: 10px;
		top: 200px;
		
	}
        #ronda32_p5 {
		position: absolute;
                border: double;
                left: 10px;
		top: 250px;;
		
	}
        #ronda32_p6 {
		position: absolute;
                border: double;
                left: 10px;
		top: 280px;
		
	}
        #ronda32_p7 {
		position: absolute;
                border: double;
                left: 10px;
		top: 330px;
		
	}
        #ronda32_p8 {
		position: absolute;
                border: double;
                left: 10px;
		top: 360px;;
		
	}
        #ronda32_p9 {
		position: absolute;
                border: double;
                left: 10px;
		top: 410px;
		
	}
        
        #ronda32_p10 {
		position: absolute;
                border: double;
                left: 10px;
		top: 440px;
		
	}
        
        #ronda32_p11 {
		position: absolute;
                border: double;
                left: 10px;
		top: 490px;;
		
	}
        #ronda32_p12 {
		position: absolute;
                border: double;
                left: 10px;
		top: 520px;
		
	}
        
        #ronda32_p13 {
		position: absolute;
                border: double;
                left: 10px;
		top: 570px;
		
	}
        
        #ronda32_p14{
		position: absolute;
                border: double;
                left: 10px;
		top: 600px;;
		
	}
        
         #ronda32_p15{
		position: absolute;
                border: double;
                left: 10px;
		top: 650px;;
		
	}
        
         #ronda32_p16{
		position: absolute;
                border: double;
                left: 10px;
		top: 680px;
		
	}
        
        
        #ronda32_p17 {
		position: absolute;
                border: double;
 		left: 10px;
		top: 730px;
		
	}
        #ronda32_p18 {
		position: absolute;
                border: double;
 		left: 10px;
		top: 760px;
		
	}
        #ronda32_p19 {
		position: absolute;
                border: double;
    		left: 10px;
		top: 810px;
		
	}
        #ronda32_p20 {
		position: absolute;
                border: double;
                left: 10px;
		top: 840px;
		
	}
        #ronda32_p21 {
		position: absolute;
                border: double;
                left: 10px;
		top: 890px;
		
	}
        #ronda32_p22 {
		position: absolute;
                border: double;
                left: 10px;
		top: 920px;
		
	}
        #ronda32_p23{
		position: absolute;
                border: double;
                left: 10px;
		top: 970px;
		
	}
        #ronda32_p24 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1000px;
		
	}
        #ronda32_p25 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1050px;
		
	}
        
        #ronda32_p26 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1080px;
		
	}
        
        #ronda32_p27 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1130px;;
		
	}
        #ronda32_p28 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1160px;
		
	}
        
        #ronda32_p29 {
		position: absolute;
                border: double;
                left: 10px;
		top: 1210px;
		
	}
        
        #ronda32_p30{
		position: absolute;
                border: double;
                left: 10px;
		top: 1240px;
		
	}
        
         #ronda32_p31{
		position: absolute;
                border: double;
                left: 10px;
		top: 1290px;
		
	}
        
         #ronda32_p32{
		position: absolute;
                border: double;
                left: 10px;
		top: 1320px;
		
	}
                  
        
       
    </style>
<body>
    
<?php

//Chequeamos el numero de jugadores que firmaron en el draw.
$numero_jugadores = TorneosInscritos::Count_Categoria($torneo_id, $categoria, $sexo);
//Ajustamos el draw al numero de jugadores del cuadro.
$numero_jugadores = Torneo_Draw::ajusta_draw($numero_jugadores);


$ronda = $numero_jugadores;
//echo "<div class='maindraw0'>";
//echo '<div class="container">';

for ($x = 0; $x < 5; $x++) {
    //echo '<div class="row col-lg-2">';
    $rsarray = Torneo_Draw::ReadAllbyRonda($torneo_id, $categoria, $sexo, $ronda);
    echo "<div class='maindraw$x'>";
    //echo '<div class="col-lg-2">';
     $yy=0;
    foreach ($rsarray as $record) {
        
        $yy++;
        
        
        
        if ($ronda==32 || $ronda==16){
            $zz="ronda".$ronda."_p$yy";
           
             echo "<div id='ronda".$ronda."_p$yy'>";
            echo '<p>Posicion ->' . $record['posicion'] . "-" . $record['jugador'] . '</p>';
            echo "</div>";
        }
        
       
        
       
            
    }
    $ronda = $ronda / 2;
    echo "</div>";
}
echo "</div>";


?>
    
     
<p id="demo"></p>

<script>
//var cars = ["BMW", "Volvo", "Saab", "Ford", "Fiat", "Audi"];
//var text = "";
//var i;var x;var t;
//for (i = 0; i < cars.length; i++) {
//    index=i + 1;
//    t='ronda32_p'+x;
//    var n=150*x;
//    text += "<div id='"+ t +"'><p>" +cars[i] + "</p></div>";
//    //text += cars[i] + "<br>";
//   // $(t).css( "width", "+=50" );
//    
//}

//$( "div.example" ).css( "width", function( index ) {
//  return index * 50;
//});

//document.getElementById("demo").innerHTML = text;

</script>
        

         
    
    
</body>
</html>

