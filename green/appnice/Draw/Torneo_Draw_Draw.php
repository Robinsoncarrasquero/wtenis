<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
require_once '../funciones/funciones.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Torneo_Categoria_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
// Notificar todos los errores de PHP
// Le decimos a PHP que usaremos cadenas UTF-8 hasta el final del script


// Le indicamos a PHP que necesitamos una salida UTF-8 hacia el navegador


$key_id =explode("-",$_GET['tid']); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo



//Ubicamos la categoria para luego traer los datos 
//de la lista para obtener la categoria_id que relaciona con lista y draw
$objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
$objCategoria->Fetch($torneo_id, $categoria, $sexo);
$categoria_id=$objCategoria->get_id(); 

//Sacamos la potencia de 2 para obtener el numero de rondas
$ronda= Torneo_Draw::Rondas($categoria_id);
$ronda=pow(2, $ronda); //Exponencial de base 2 a la n
$objTorneo = new Torneo();
$objTorneo->Fetch($torneo_id);
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
         
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                
        .maindraw{
            //padding:2px;
         }
         body{ 
            
         }
        
        div {
         
            
          
            
            // border-top-right-radius: 1.2em;
            //border-bottom-right-radius:  1.2em;
        }
        .ronda {
         
            
            background:#c4e3f3;
            
            // border-top-right-radius: 1.2em;
            //border-bottom-right-radius:  1.2em;
        }
        p{
            font-size: 8px;
            //font-style: italic;
            font-weight: bold;
            color:#222;
            
           // border: 1px solid yellow;
            padding-top:8px;
            
            
        }
        
        
        #ronda1_p1{
            padding-top:6px;
            font-size: 14px;
            border:#FFF;
            color:#222;
            
            
                 
           
		
	}
        div #ronda1_p1{
            background:#777;
            color:#c4e3f3;
            padding:6px;
            border: 2px solid #222;
            
            padding-top:7px;
            
           
;
      	}
        div #ronda1_p1 p b{
            
             color:#c4e3f3;
             
            
             
        }
        .titulo-draw {
            
             color:#00c;
            
        }
        
         
        
               
        <?php
        $left=1;$inicio=10;
        css_draw_semilla($ronda, $left, $inicio)
        
       
        ?>
                  
        
       
    </style>
<body>
    
<div class="container">
   
        <div class="titulo-draw col-xs-12">
            <h5 >Draw Torneo <?php echo $objTorneo->getNombre()?>
            / Grado : <?php echo $objTorneo->getTipo()?>
            / Fecha Inicio: <?php echo $objTorneo->getFechaInicio()?>
            / Fecha Fin: <?php echo $objTorneo->getFechaFinTorneo()?></h5>
            
           
        </div>
    
    
    
</div>
 
<?php
//echo '<div class="container">';
//echo '<div class="titulo-draw col-xs-12">';
//
////Para generar las miga de pan mediante una clase estatica
//require_once '../clases/Bootstrap2_cls.php';
//echo Bootstrap::breadCrumDraw();
//echo "</div>";
//echo "</div>";





           
echo '<div class="container-fluid">';
echo '<div class="row col-xs-10">';

$rondas=$ronda;
$idcampeon=0;
for ($r = 0; $r <=$rondas; $r++) {
   
    $rsarray = Torneo_Draw::ReadAllbyRonda($categoria_id, $ronda);
    echo '<div class="col-xs-1 ">';
    
    
    //Variable para controlar el layaout por jugador #ronda_p_yy
    $yy=0;
    if ($r == 0) {
        for($i=0;$i<32;$i++){
            $y++;      
//            echo "<div id='imgbandera".$ronda."_p$y'>";
//            echo '<p>'.$y.'</p>';
//            echo '<img src="../banderas/estados/banderamirico.png" class="img-thumbnail" >';
//
//            echo '</div>'; 
        }
    }
    
    //Recorremos los registros de la ronda actual
    foreach ($rsarray as $record) {
        $atleta_id=$record['jugador'];
        $ObjAtleta = new Atleta();
        $ObjAtleta->Find($atleta_id);
        if ($record['jugador'] > 0) {
            $nombre = $ObjAtleta->getNombreCorto()."(".$ObjAtleta->getEstado().")";
        } else {
            $nombre = 'Match';
        }

        if ($r == 0 && $record['jugador'] == 0 && $record['antposicion'] == 0) {
            $nombre = 'Bye ';
        }
        

        $score = '';
        if ($record['antposicion']>0) {
            
            //Buscamos el juego anterior para ubicar su contrincante y el resultado
             $objDraww = new Torneo_Draw();
             $objDraww->FindRondaAnterior($record['categoria_id'],$record['ronda'],$record['jugador']);
            //Buscamos el contrincante del juego anterior ppara obtener el resultado
            $objDrawl = new Torneo_Draw();
            $objDrawl->FindContrincante($objDraww->getCategoria_id(),$objDraww->getRonda(), $objDraww->getPosicion());
        
            $score = '';
            if ($objDraww->getStatus() != "JU" && $objDraww->getStatus() != NULL) {
                $score = $objDraww->getStatus();
            } else {
                if ($objDraww->getS1() + $objDrawl->getS1() > 0) {
                    if ($objDraww->getT1() + $objDrawl->getT1() > 7) {
                        $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1();
                        $score .= "[" . (($objDraww->getT1() > $objDrawl->getT1()) ? $objDrawl->getT1() : $objDraww->getT1()) . "]";
                    } else {
                        $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1() . " ";
                    }
                }
                if ($objDraww->getS2() + $objDrawl->getS2() > 0) {
                    if ($objDraww->getT2() + $objDrawl->getT2() > 7) {
                        $score .=" " . $objDraww->getS2() . "-" . $objDrawl->getS2();
                        $score .="[" . (($objDraww->getT2() > $objDrawl->getT2()) ? $objDrawl->getT2() : $objDraww->getT2()) . "]";
                    } else {
                        $score .= " " . $objDraww->getS2() . "-" . $objDrawl->getS2() . " ";
                    }
                }
                if ($objDraww->getS3() + $objDrawl->getS3() > 0) {
                    if ($objDraww->getT3() + $objDrawl->getT3() > 7) {
                        $score .=" " . $objDraww->getS3() . "-" . $objDrawl->getS3();
                        $score .="[" . (($objDraww->getT3() > $objDrawl->getT3()) ? $objDrawl->getT3() : $objDraww->getT3()) . "]";
                    } else {
                        $score .= " " . $objDraww->getS3() . "-" . $objDrawl->getS3() . " ";
                    }
                }
            }
        }
       
        
        $href="TorneoDrawDrawEdit.php";
        $yy++;
        //if ($ronda==32 || $ronda==16 || $ronda==8 || $ronda==4 || $ronda==2){
            echo "<div class='ronda' id='ronda".$ronda."_p$yy'>";
            if ($_SESSION['niveluser']>1){
                echo "<a target='_blank' href='".$href."' class='edit-record' data-id='".$record['id']."'><p>" . $record['ronda'] . "-" . $nombre."<b> ".$score.'</b></p></a>';
            }else{
                if(MODO_DE_PRUEBA){
                    $href="../Biografia/BioPlayerMenu.php?id=".$record['jugador'];
                }else{
                    $href="http://tenis.net.ve/app/Biografia/BioPlayerMenu.php?id=".$record['jugador'];
                }
                $href='';
                
               // echo "<a  href='".$href."' class='enlace' data-id='".$record['jugador']."'><p>" . $record['ronda'] . "-" . $nombre."<b> ".$score.'</b></p></a>';
               
                    echo "<p>" . $record['ronda'] . "-" . $nombre."<b> ".$score.'</b></p>';
             
                    
                
                //echo "<a target='_blank'"."'><p>" . $record['ronda'] . "-" . $nombre."<b> ".$score.'</b></p></a>';
            }
            echo "</div>";
        //}
            
        if ($record['ronda'] == 2 && $record['win']>0) {
            $campeonnombre = $nombre;

            $idcampeon=$record['id'];
        }
       
        
    }
    $score=" ";
    $ronda = $ronda / 2;
    if ($ronda==1 && $idcampeon>0) {
            
        //Buscamos el juego anterior para ubicar su contrincante y el resultado
         $objDraww = new Torneo_Draw();
         $objDraww->Fetch($idcampeon);
        //Buscamos el contrincante del juego para obtener el resultado
        $objDrawl = new Torneo_Draw();
        $objDrawl->FindContrincante($objDraww->getCategoria_id(),$objDraww->getRonda(), $objDraww->getPosicion());

        $score = '';
        if ($objDraww->getStatus() != "JU" && $objDraww->getStatus() != NULL) {
            $score = $objDraww->getStatus();
        } else {
            if ($objDraww->getS1() + $objDrawl->getS1() > 0) {
                if ($objDraww->getT1() + $objDrawl->getT1() > 7) {
                    $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1();
                    $score .= "[" . (($objDraww->getT1() > $objDrawl->getT1()) ? $objDrawl->getT1() : $objDraww->getT1()) . "]";
                } else {
                    $score = " " . $objDraww->getS1() . "-" . $objDrawl->getS1() . " ";
                }
            }
            if ($objDraww->getS2() + $objDrawl->getS2() > 0) {
                if ($objDraww->getT2() + $objDrawl->getT2() > 7) {
                    $score .=" " . $objDraww->getS2() . "-" . $objDrawl->getS2();
                    $score .="[" . (($objDraww->getT2() > $objDrawl->getT2()) ? $objDrawl->getT2() : $objDraww->getT2()) . "]";
                } else {
                    $score .= " " . $objDraww->getS2() . "-" . $objDrawl->getS2() . " ";
                }
            }
            if ($objDraww->getS3() + $objDrawl->getS3() > 0) {
                if ($objDraww->getT3() + $objDrawl->getT3() > 7) {
                    $score .=" " . $objDraww->getS3() . "-" . $objDrawl->getS3();
                    $score .="[" . (($objDraww->getT3() > $objDrawl->getT3()) ? $objDrawl->getT3() : $objDraww->getT3()) . "]";
                } else {
                    $score .= " " . $objDraww->getS3() . "-" . $objDrawl->getS3() . " ";
                }
            }
        }
           
    }
   
    if ($ronda==1) {
        $scorecampeon=$score;
        $titulo = ($sexo == "F" ? "CAMPEONA " : "CAMPEON ");
        
        $campeonnombre= $campeonnombre;
        $titulo="";
        echo "<div id='ronda1_p1'>";
        
        $href="http://tenis.net.vet/app/Biografia/BioPlayerMenu.php";
        //echo "<p><a  href='".$href."' class='edit-record' data-id='".$record['jugador']."'><b>" . $titulo .''.$campeonnombre." ".$scorecampeon.'</b></a></p>';
        echo "<p><b>" . $titulo .''.$campeonnombre." ".$scorecampeon.'</b></p>';
     
        echo "</div>";
    }
     echo "</div>";
}
 

echo "</div>";
echo "</div>";

?>
    
     
<p id="demo"></p>

<script>



$(document).on('click','.edit-record',function(e)  {
        e.preventDefault();
        var idx =$(this).attr('data-id');
        var url=$(this).attr('href')+"?id="+idx;
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
</script>
        

         
    
    
</body>
</html>

