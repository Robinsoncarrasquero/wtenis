<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Busca ip
function getRealIP()
{

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }
    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', 
            mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535),
            mt_rand(0, 65535), mt_rand(0, 65535));
}

function openTabFather($class_container,$class_ul){
    $outTabulador=
    '<div class="$class_container">' .
    '<h3>Ranking Nacional de los Atletas de Competencia Organizado por Categoria</h3>' .
        '<ul class="$class_ul">';
    return $outTabulador;
}

function closeTabFather(){
    $outTabulador=
       '</div>'.
   '</div>';
    return $outTabulador;
}
function openTabChildActive($id_name_tab,$titulo_tab,$claseActive){
   
    
    $clase='<div id="'. $id_name_tab .'" class="$claseActive">';
    
    $outTabulador=
    $clase .
    '<h3>'. $titulo_tab .'</h3>'.
    '<div>' .
        '<table  margin-left="10%" width="99%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666"  style="border-collapse:collapse"> ' .
               '<th>RK.Nacional</th><th>RK.Regional</th><th>RK.Estadal</th><th>Estado
                </th><th>Nombres</th><th>Apellidos</th><th>Categoria</th><th>Fecha Nac.</th>' .
               '<th>Fecha Rank.</th>';
   return $outTabulador;
}


function closeTabChild()  {     
    $outTabulador=
        '</table>'.
     "</div>" .    
    "</div>" ;
    return $outTabulador;

}

function htmlcloseWindow() {
    echo "<script type='text/javascript'>window.close();</script>";
    
}



function openTabChild($menuX,$tituloX,$inactive){
   
    
    $clase='<div id="'. $menuX .'" class="tab-pane fade' .$inactive.'">';
    
    $outTabulador=
    $clase .
    '<h3>'. $tituloX .'</h3>'.
    '<div>' .
        '<table  margin-left="10%" width="99%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666"  style="border-collapse:collapse"> ' .
               '<th>RK.Nacional</th><th>RK.Regional</th><th>RK.Estadal</th><th>Estado
                </th><th>Nombres</th><th>Apellidos</th><th>Categoria</th><th>Fecha Nac.</th>' .
               '<th>Fecha Rank.</th>';
   return $outTabulador;
}





function simpleopenTabFather(){
    $outTabulador=
    '<div class="container">' .
    '<h3>Ranking Nacional de los Atletas de Competencia Organizado por Categoria</h3>' .
        '<ul">';
    return $outTabulador;
}

function simplecloseTabFather(){
    $outTabulador=
       '</div>'.
   '</div>';
    return $outTabulador;
}

function simpleopenTabChild($menuX,$tituloX,$claseActive){
   
   
    $clase='<div id="'. $menuX .'"' .'" "'.$claseActive.'">';
    
    $outTabulador=
    $clase .
    '<h3>'. $tituloX .'</h3>'.
    '<div>' .
        '<table  margin-left="10%" width="99%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666"  style="border-collapse:collapse"> ' .
               '<th>RK.Nacional</th><th>RK.Regional</th><th>RK.Estadal</th><th>Estado
                </th><th>Nombres</th><th>Apellidos</th><th>Categoria</th><th>Fecha Nac.</th>' .
               '<th>Fecha Rank.</th>';
   return $outTabulador;
}


function simplecloseTabChild()  {     
    $outTabulador=
        '</table>'.
     "</div>" .    
    "</div>" ;
    return $outTabulador;

}

function select_tabla_puntos($chkName,$chkValue,$chkEnabled){
    $array_puntos=array(0,1,2,3,4,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,150);
    
    //$strSelect= "<select  $chkEnabled id='".$chkName."'>";
    $strSelect= "<select onchange='myFunction()' $chkEnabled name='lista_punto[]'>";
    
          
    for ($x=0; $x < count($array_puntos); $x++){ // vamos a imprimir las categorias en el elemento select
          if ($chkValue==$array_puntos[$x]){
             $strSelect .= "<option selected value='$chkName'>$array_puntos[$x]</option>";
          }else{
            $strSelect .= "<option  value='$chkName'>$array_puntos[$x]</option>";
          }
    }
   
   
    $strSelect .= '</select>';
    return $strSelect;
             
            
            
}

function select_tabla_penalidad($chkName,$chkValue,$chkEnabled){
    $array_puntos=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
    
    $strSelect= "<select  $chkEnabled id='".$chkName."'>";
    $strSelect= "<select $chkEnabled name='lista_sancion[]'>";
          
    for ($x=0; $x < count($array_puntos); $x++){ // vamos a imprimir las categorias en el elemento select
          if ($chkValue==$array_puntos[$x]){
             $strSelect .= "<option selected value='$chkName'>$array_puntos[$x]</option>";
          }else{
            $strSelect .= "<option  value='$chkName'>$array_puntos[$x]</option>";
          }
    }
   
   
    $strSelect .= '</select>';
    return $strSelect;
             
            
            
}

function categorias($categoria){
    
    switch ($categoria) {
        case "12,16":
            break;
        case "12B":
            break;
        
        case "14,18":
            break;
        case "PN,PV":
            break;
         case "PN":
            break;
         case "PV":
            break;
        case "12,14,16,18":
            break;
        case "14,16":
            break;

        default:
            break;
    }
                     
    
    
    return strCategoria;
}

function fun_Estado($estado_str){
    
   $arrayEdo= array('DC'=>'DISTRITO CAPITAL','ANZ'=>'ANZOATEGUI','APU'=>'APURE','ARA'=>'ARAGUA','BAR'=>'BARINAS','BOL'=>'BOLIVAR',
         'CAR'=>'CARABOBO','COJ'=>'COJEDES','FAL'=>'FALCON','GUA'=>'GUARICO','LAR'=>'LARA','MER'=>'MERIDA','MIR'=>'MIRANDA',
         'MON'=>'MONAGAS','NES'=>'NUEVA ESPARTA','POR'=>'PORTUGUESA','TRU'=>'TRUJILLO','SUC'=>'SUCRE','TAC'=>'TACHIRA','DEL'=>'DELTA AMACURO',
         'YAR'=>'YARACUY','VAR'=>'VARGAS','ZUL'=>'ZULIA');
   
     return $arrayEdo[$estado_str];
}

//Funcion para imprimir el draw semilla
function css_draw_semilla($ronda,$left,$inicio){
    $leftv=30;
    $topv=$inicio;
    for ($i=0;$i<$ronda;$i++){
        $j=$i + 1;
        if ($j%2==0){
            $topv +=30;
            
        }else{
            $topv +=50;
        }
        $drawPadre[]=$topv;
        if ($j%2==0){
            $drawHijo[]=($drawPadre[$i-1] + $drawPadre[$i])/2;
        }
        echo "#ronda".$ronda."_p".$j."{
                position: absolute;
                border: double;width:200px;
                left:".$leftv."px;
                top:".$topv."px;
        }\n";
         echo "#imgbandera".$ronda."_p".$j."{
                
                position: absolute;
                border: double;width:30px;
                left:".($leftv-20)."px;
                top:".$topv."px;
        }\n";
    }

    //Se imprime los siguientes draw partiendo de la semilla
    $rondas=$ronda/2;
    $leftv=30;$height=28;
    $drawNew=array();$v=0;
    while ($rondas>=1){
        $v++;
        unset($drawPadre); unset($drawNew);
        $leftv +=118;
//        if ($v%2==0){
//            $leftv +=200;
//        }else{
//            $leftv +=190;
//        }
        $height +=2;
        for ($i=0;$i<$rondas;$i++){
            $j=$i + 1;

            $topv=$drawHijo[$i];
            $drawPadre[]=$topv;
            echo "#ronda".$rondas."_p".$j."{
                    position: absolute;
                    border: double;width:200px;
                    left:".$leftv."px;
                    top:".$topv."px;
            }\n";
            if ($j%2==0){
                $drawNew[]=($drawPadre[$i-1] + $drawPadre[$i])/2 - 1;
            }
        }
        $drawHijo=$drawNew;
        $rondas /=2;
        
    }
    
    
    
}










