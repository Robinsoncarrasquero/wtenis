<?php

//Los estados de Portugal para el manejo del nombre de un eatado
//de Forma completa y describir en cartas y tros documentos
function fun_Estado($estado_str){
    
   $arrayEdo= array('DC'=>'DISTRITO CAPITAL','ANZ'=>'ANZOATEGUI','APU'=>'APURE','ARA'=>'ARAGUA','BAR'=>'BARINAS','BOL'=>'BOLIVAR',
         'CAR'=>'CARABOBO','COJ'=>'COJEDES','FAL'=>'FALCON','GUA'=>'GUARICO','LAR'=>'LARA','MER'=>'MERIDA','MIR'=>'MIRANDA',
         'MON'=>'MONAGAS','NES'=>'NUEVA ESPARTA','POR'=>'PORTUGUESA','TRU'=>'TRUJILLO','SUC'=>'SUCRE','TAC'=>'TACHIRA','DEL'=>'DELTA AMACURO',
         'YAR'=>'YARACUY','VAR'=>'VARGAS','ZUL'=>'ZULIA');
   
     return $arrayEdo[$estado_str];
}

?>