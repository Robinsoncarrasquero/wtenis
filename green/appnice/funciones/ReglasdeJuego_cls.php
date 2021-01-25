<?php
//Clase para manejar metodos para reutilizar codigo

class Reglas_Juego{
    
    
    //Metodo para definir el score de un set de juego
    //que aun no ha finalizado y se maneja como una pizarra
    public static function ScoreSetPizarra($setJugador1, $setJugador2) {

        return $setJugador1 . '-' . $setJugador2;
    }

    public static function ScoreSet_Corto($scoreSet) {

        if ($scoreSet < 0) {
            $valpositivo = -$scoreSet;
            if ($valpositivo >= 6) {
                $set = $valpositivo . "-7";
            } else {
                $set = $valpositivo . "-6";
            }
        } else {
            if ($scoreSet >= 6) {
                $set = "7-" . $scoreSet;
            } else {
                $set = "6-" . $scoreSet;
            }
        }

        return $set;
    }
    
     //Devuelve el menor puntaje del jugador que perdio
    
    public static function ScoreSet_Decode_X($ganador, $setJ1, $setJ2) {
        
        if ($setJ1==NULL || $setJ2==NULL){
            return NULL;
        }
        
        if ($ganador==1){
            if ($setJ1<$setJ2) {
               
                    $set="-".$setJ1;
            }else{
                
                $set=$setJ2;
            }
        }
        if ($ganador==2){
            if ($setJ2<$setJ1) {
               
                    $set="-".$setJ2;
            }else{
                
                $set=$setJ1;
            }
        }
            
        return $set;
    } 
        

    
    
    
    //Sirve para decodificar la puntuacion que se carga por input
    //de forma rapida y entendia por los arbitros
    public static function ScoreSet_Code($win,$score) {
       
        if ($score==NULL){
            return [NULL,NULL];
        }
        
       
       
        switch ($score) {

            case "-1":
                $set=[1,6];
                break;
            case "-2":
                $set=[2,6];
                break;
            case "-3":
                $set=[3,6];
                break;
            case "-4":
                $set=[4,6];
                break;
            case "-5":
                $set=[5,7];
                break;
            case "-6":
                $set=[6,7];
                break;
            case '0':
                $set=[6,0];
                break;
            case "1":
                $set=[6,1];
                break;
            case "2":
                $set=[6,2];
                break;
            case "3":
                $set=[6,3];
                break;
            case "4":
                $set=[6,4];
                break;
            case "5":
                $set=[7,5];
                break;
            case "6":
                $set=[7,6];
                break;
            default:
                $set=[NULL,NULL];
                break;
        }
        
        if ($score=== '-0'){
            $set = [0,6];
        }     
        
        if ($win=="2"){
            $rset[0] =$set[1];
            $rset[1] =$set[0];
        }else{
            $rset =$set;
        }
            
        return $rset;
    } 
    
    public static function ScoreTb_Corto($scoreTB) {

        if ($scoreTBt < 0) {
            $valpositivo = -$scoreTB;
            if ($valpositivo > 7) {
                $set = $valpositivo . "-" . $valpositivo + 2;
            } else {
                $set = $valpositivo . "-" . "7";
            }
        } else {
            if ($scoreTB > 7) {
                $set = $scoreTB + 2 . "-" . $scoreTB;
            } else {
                $set = "7-" . $scoreTB;
            }
        }

        return $set;
    } 
    
    //Permite obtener el numero menor del tiebreak, decodificando
    //un valor corto y resumido para el arbitro
    public static function ScoreTB_Decode($tiebreakJ1,$tiebreakJ2) {
    
        if ($tiebreakJ1 > $tiebreakJ2) {
            $tb = $tiebreakJ2;
        } else {
            $tb = $tiebreakJ1;
        }

        return $tb;
    }
    
    //Genera el score del tb segun resultado del set
    //Para code debe ser el tb siempre positivo y en caso que lo
    //carguen negativo se fuerza a positivo
    //En este caso es reuqerido el parametro set del juego para determinar
    //si gano o perdio el set
    public static function ScoreTB_Code($score_set,$tb) {
        
        if ($tb<0){
            $tb=-$tb;
        }
        
        if ($score_set > 0) {
           $set = ($tb>5) ? $tb + 2 : 7;
            
        } else {

            $set = $tb;
        }

        return $set;
    } 
    
    //Determina si el juego ya fue cumplido totalmente
    public static function juego_cumplido($s1, $s2, $s3, &$j1, &$j2) {
        $jj1=$j1;
        $jj2=$j2;
        Reglas_Juego::resultado_set($s1, $j1, $j2);
        Reglas_Juego::resultado_set($s2, $j1, $j2);

        if ($j1 + $j2 > 1 && $j1 == $j2) {
            Reglas_Juego::resultado_set($s3, $j1, $j2);
        }
       
        //Valida que se haya cumplidos 2 set y que haya un jugador con mas set ganados
        if ($j1 + $j2 > 1 && ($j1 > $j2 || $j2 > $j1)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Determina el jugador ganador del set
    public static function resultado_set($set, &$j1, &$j2) {
        if ($set[0] >= 6 || $set[1] >= 6) {
           ($set[0] > $set[1]) ? $j1++ : $j2++;
        }
        
    }

    public static function Count_Jugadores_Draw($torneo_id, $categoria, $sexo) {

        $numero_jugadores = TorneosInscritos::Count_Categoria($torneo_id, $categoria, $sexo);
        //Determinamos el numero de jugadores para generar el cuadro
        //partiendo de la premisa que los registros son generados por ronda
        //y cada resgistro es un juego
        if ($numero_jugadores <= 8) {
            $draw = 8;
        } elseif ($numero_jugadores <= 16) {
            $draw = 16;
        } elseif ($numero_jugadores <= 32) {
            $draw = 32;
        } elseif ($numero_jugadores <= 64) {
            $draw = 64;
        } elseif ($numero_jugadores <= 128) {
            $draw = 128;
        } else {
            $draw = 0;
        }
        return $draw;
    }
    
    
    public static function select_posicion_lista($nrojugadores,$chkName,$chkValue,$chkEnabled){

        $array_pos=[];

        for ($i=0; $i<$nrojugadores;$i++){
            $array_pos[$i]=$i + 1;
        }

        //$strSelect= "<select  $chkEnabled id='".$chkName."'>";
        $strSelect= "<select $chkEnabled name='lista_posicion[]'>";


        for ($x=0; $x < count($array_pos); $x++){ // vamos a imprimir las categorias en el elemento select
              if ($chkValue==$array_pos[$x]){
                $strSelect .= "<option selected value='$chkName'>$array_pos[$x]</option>";
              }else{
                $strSelect .= "<option  value='$chkName'>$array_pos[$x]</option>";
              }
        }


        $strSelect .= '</select>';
        return $strSelect;
    }
    
    public static function select_posicion_rk($chkName,$chkValue,$chkEnabled){

        $array_pos[]=[];

        for ($i=0; $i<301;$i++){
            $array_pos[$i]=$i ;
        }

        //$strSelect= "<select  $chkEnabled id='".$chkName."'>";
        $strSelect= "<select $chkEnabled name='lista_rk[]'>";


        for ($x=0; $x < count($array_pos); $x++){ // vamos a imprimir las categorias en el elemento select
              if ($chkValue==$array_pos[$x]){
                $strSelect .= "<option selected value='$chkName'>$array_pos[$x]</option>";
              }else{
                $strSelect .= "<option  value='$chkName'>$array_pos[$x]</option>";
              }
        }


        $strSelect .= '</select>';
        return $strSelect;
    }
    
    
     public static function select_posicion_lista_aceptacion($atleta_id,$chkValue,$chkEnabled){

                
        $array_pos=['..','MDW','MWC','QLY','QWC','ALT','RET'];
        

        //$strSelect= "<select  $chkEnabled id='".$chkName."'>";
        $strSelect= "<select $chkEnabled name='lista_aceptacion[]'>";


        for ($x=0; $x < count($array_pos); $x++){ // vamos a imprimir las categorias en el elemento select
              if ($chkValue==$x){
                $strSelect .= "<option selected value='".$atleta_id."-$x"."'>$array_pos[$x]</option>";
              }else{
                $strSelect .= "<option  value='".$atleta_id."-$x"."'>$array_pos[$x]</option>";
              }
        }


        $strSelect .= '</select>';
        return $strSelect;
    }
    
    
     //Metodo para definir el score de un set de juego
    //que aun no ha finalizado y se maneja como una pizarra
    public static function NombredeRonda($ronda) {
        switch ($ronda) {
            case 2:
                $str="FF";

                break;
            case 4:
                $str="SF";

                break;
             case 8:
                $str="QF";

                break;
             

            default:
                $str=$ronda;
                break;
        }
        return $str;
    }
    
    
    
    

}

