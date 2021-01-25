<?php






function osorteo(array $posiciones) {

    $afijo = $posiciones;
    $vmax = count($afijo);
    $elementos = count($afijo);
    for ($i = 0; $i < $elementos; $i++) {
        $vmin = 0;
        $vmax = $vmax - 1;
        $pos = mt_rand($vmin, $vmax);

        $new_array[] = $afijo[$pos];
        array_splice($afijo, $pos, 1);
    }

    return $new_array;
}
//Generamos la siembra
function sorteo32_siembras(){
    
    $siembras = [1, 2, 3, 4, 5, 6, 7, 8];
    $posicion = [1, 32, 9, 24, 8, 16, 17, 25];
    $grupo0 = [1, 2]; //Grupo fijo simbra 1 y 2
    $grupo1 = [3, 4]; //Grupo que sortea posiciones
    $grupo2=[5, 6, 7, 8]; //Grupo que sortea posiciones

    $array0=$grupo0;
    $array1=osorteo($grupo1);
    $array2=osorteo($grupo2);

    $seed= array_merge($array0,$array1,$array2);
    //Combinamos posiciones con siembras para obtener los puestos sorteados            
    $posiciones_sembradas = array_combine($seed, $posicion);
    return $posiciones_sembradas;
}

  
//Sorteamos los bye fijos
function sorteo_bye32($nro_bye) {

    if ($nro_bye == 0) {
        return 0;
    }
    //Los bye disponibles los asignamos a las posiciones sorteadas
    
    //Posicion de inicio de las posiciones libres en las lista de jugadores que estan al final
    //y se asignan como bye segun el sorteo de acuerdo a las orden de siembras
    $inicio=32 - $nro_bye  + 1  ;
    for ($i=0;$i<$inicio;$i++){
        $puesto= $i + $inicio;
        $posiciones_bye[]=$puesto;

    }
    $siembras = [1, 2, 3, 4, 5, 6, 7, 8];
    $posiciones_draw = [2, 31, 10, 23, 7, 15, 18, 26];
    $grupo0 = [1, 2]; //Grupo 0 fijo posiciones 1 y 32
    $grupo1 = [3, 4]; //Grupo 1 fijo posiciones 3 y 4
    $grupo2 = [5, 6, 7, 8]; //Grupo 2 sortea posiciones 8 16 17 y 25

    //Sorteamos cada grupo de posiciones con las siembras
    $array0=$grupo0;
    $array1=osorteo($grupo1);
    $array2=osorteo($grupo2);
    $siembra_new= array_merge($array0,$array1,$array2);
    foreach ($siembra_new as $value) {
        $posiciones_sorteadas[]=$posiciones_draw[$value-1];

    }
    
    //Los bye disponibles los asignamos a las siembras por prioridad y sorteo
    $bye_out = $nro_bye <8 ? $nro_bye : 8;
    
    //Tomamos las posiciones que corresponden al numero de bye disponibles
  
    $array0 = array_splice($posiciones_sorteadas, 0, $bye_out);
    $array1 = array_splice($posiciones_bye, 0, $bye_out);

    //Combinamos las siembras con las posiciones a repartir
    $array_bye = array_combine($array1,$array0 );

    return $array_bye;
    //var_export($posiciones_sorteadas);
}

function sorteo_bye32_adicionales($nro_bye) {
   
    if ($nro_bye ==0 || $nro_bye<9) {
        return array();
    }
  
    
    //Reservamos los siguientes puesto despues de los 8 puestode los bye reglamentarios.
    $inicio=32 - $nro_bye + 8 + 1  ;
    for ($i=0;$i<$inicio;$i++){
        $puesto= $i + $inicio;
        $posiciones_bye[]=$puesto;

    }
    //Posiciones que estan libres antes de llenar colocar la
    //lista de jugadores
    $siembras = [1, 2, 3, 4, 5, 6, 7, 8];
  
    $posiciones_bye_draw= [3,30,6,27,11,22,14,19]; //Cabeza de posicion
    
    
    //Sorteamos las posiciones
    $array0=osorteo($siembras);
    $siembra_new= array_merge($array0);
    //Organizamos las posiciones segun sorteo
    foreach ($siembra_new as $value) {
        $posiciones_sorteadas[]=$posiciones_bye_draw[$value-1];

    }

     //Los bye en exceso despues de las siembras disponibles los asignamos a las posiciones definidas
    $bye_out = $nro_bye - 8;
    
    //Tomamos las posiciones que corresponden al numero de bye disponibles
  
    $array0 = array_splice($posiciones_sorteadas, -0, $bye_out);
    $array1 = array_splice($posiciones_bye, -0, $bye_out);

    //Combinamos las siembras con las posiciones a repartir
    $array_bye = array_combine($array1,$array0 );

    return $array_bye;
    //var_export($posiciones_sorteadas);
}
    
//Determina los puestos que se deben llenar desde la posicion 9 de la lista 
function sorteo32_dif(array $array_siembra, array $array_bye,array $array_bye_adicionales) {
    //Paso 1:
      /*Buscamos las posiciones vacias y creamos un arreglo con 
      las posiciones y hacemos un sorteo de cada posicion.
      luego lo llevamos al draw posicion lista y posicion draw
     */
    
    
    $inicio=32 ; $puesto=0;
    //Creamos un arreglo con todas las posiciones
    for ($i=0;$i<$inicio;$i++){
        $puesto= $i + 1;
        $array_posiciones_completas[]=$puesto;
    }
    //Reordenamos las posiciones de las siembras
    foreach ($array_siembra as $key => $posicion) {
       $array_siembra_orden[]=$posicion;
    }
    //Reordenamos las posiciones de los bye de las siembras
    foreach ($array_bye as $key => $posicion) {
       $array_bye_orden[]=$posicion;
    }
    
     //Reordenamos las posiciones de los bye de las siembras
    foreach ($array_bye_adicionales as $key => $posicion) {
       $array_bye_restan_orden[]=$posicion;
    }
    if (count($array_bye) > 0) {
        if (count($array_bye_adicionales) > 0) {

            $array_posiciones_ocupadas = array_merge($array_bye_orden, $array_siembra_orden, $array_bye_restan_orden);
            $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
        } else {

            $array_posiciones_ocupadas = array_merge($array_bye_orden, $array_siembra_orden);
            $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
       
        }
    } else {
        $array_posiciones_ocupadas = $array_siembra_orden;
        $array_posiciones_libres = array_diff($array_posiciones_completas, $array_posiciones_ocupadas);
    }


    //Reordenamos las posiciones de los bye de las siembra 8 para tomar
    //la siguiente posicion
    $inicio=8;
    foreach ($array_posiciones_libres as $key => $posicion) {
       $inicio ++;
       $array_posiciones[]=$inicio;
    }
    //Combinamos arreglos de posiciones lista con posiciones libres por actualizar 
    $array_final = array_combine($array_posiciones,$array_posiciones_libres );
    print_r($array_final);
    //sortear_jugadores($array_final);
    return $array_final;
    //var_export($posiciones_sorteadas);

}
//Genera los puestos de los jugadores a partir de la posicion 9
function sortear_jugadores($array_jugadores,$bye){
   
     
    //Jugadores segun cuadro 
    $draw32=32; $draw64=64; $draw16=16; $draw8=8; $draw4=4;
    if ($draw32-count($array_jugadores)-$bye==8){
        $puestos_draw = [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,24];
        $posiciones_draw= array_splice($puestos_draw,0,count($array_jugadores));
        $array_jugadores_sorteados=osorteo($posiciones_draw);
         
        //Organizamos las posiciones segun sorteo iniciando desde la posicion 8 
        //para obtener el key del array de los jugadores
        foreach ($array_jugadores_sorteados as $key => $value) {
            $array_jugadores_ordenado[]=$array_jugadores[$value+8];
        }
       
       
      
        $inicio=8;
        foreach ($array_jugadores_sorteados as $key => $posicion) {
           $inicio ++;
           $array_posiciones_lista[]=$inicio;
        }
        
        $array_final = array_combine($array_posiciones_lista,$array_jugadores_ordenado);
        
        
         
         
    }
    
    return($array_final);
        
    }
?>
