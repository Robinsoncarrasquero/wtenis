<?php
session_start();
require_once '../funciones/funciones.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneo_Puntaje_cls.php';
require_once '../clases/Torneo_Categoria_cls.php';
require_once '../clases/Torneos_cls.php';
$por_post=TRUE;
if  ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $id = htmlspecialchars($_POST['id']);
    
    //Asignamos los valores en array para ordenar los juegos de cada set segun
    //el jugador ganador y perdedor. El ganador tiene el set ordenado de izquierda
    //a derecha y el perdedor al contrario del puntaje del ganador.
    if (trim($_POST['s1'])==''){
        $s1=[NULL,NULL];$s2=[NULL,NULL]; $s3=[NULL,NULL];
        $ss1=NULL;
    }else{
        $ss1=$_POST['s1'];
        
    }
    if (trim($_POST['s2'])==''){
        $s2=[NULL,NULL]; $s3=[NULL,NULL];
        $ss2=NULL;
    }else{
        $ss2=$_POST['s2'];
    }
    if (trim($_POST['s3'])==''){
        $s3=[NULL,NULL];
        $ss3=NULL;
    }else{
        $ss3=$_POST['s3'];
    }
    if (trim($_POST['t1'])==''){
       
        $tt1=NULL;
    }else{
        $tt1=$_POST['t1'];
    }
    if (trim($_POST['t2'])==''){
        $tt2=NULL;
       
    }else{
        $tt2=$_POST['t2'];
    }
    if (trim($_POST['t3'])==''){
        $tt3=NULL;
       
    }else{
        $tt3=$_POST['t3'];
    }
   
        
    //Radio boton Ganador
    $win=  isset($_POST['optwin']) ? $_POST['optwin'] : 0 ;
    $status=$_POST['status'];
    if ($status == "WO") {
        $ss1 = 0;
        $ss2 = 0;
        $ss3 = NULL;
        $tt1 = NULL;
        $tt2 = NULL;
        $tt3 = NULL;
    }
    

    if ($win>0) {
            
            //Score cuando haya ganado el jugador 1
            //Este score viene dado en valores corto ejemplos( -3 3 4)
           
            $set1= Reglas_Juego::ScoreSet_Code($win,$ss1);
            $s1[0] = $set1[0];
            $s1[1] = $set1[1];
           
            $set2= Reglas_Juego::ScoreSet_Code($win,$ss2);
            $s2[0] = $set2[0];
            $s2[1] = $set2[1];
            $set3= Reglas_Juego::ScoreSet_Code($win,$ss3);
            $s3[0] = $set3[0];
            $s3[1] = $set3[1];
           
            if ($s1[0]+$s1[1] >12) {
                $t1[0] = Reglas_Juego::ScoreTB_Code($ss1,$tt1);
                $t1[1] = Reglas_Juego::ScoreTB_Code(-$ss1,$tt1);
            }
            if ($s2[0]+$s2[1] >12) {
                $t2[0] = Reglas_Juego::ScoreTB_Code($ss2,$tt2);
                $t2[1] = Reglas_Juego::ScoreTB_Code(-$ss2,$tt2);
            }
            if ($s3[0]+$s3[1] >12) {
                $t3[0] = Reglas_Juego::ScoreTB_Code($ss3,$tt3);
                $t3[1] = Reglas_Juego::ScoreTB_Code(-$ss3,$tt3);
            }
           
           
    }else{
            //En caso que aun no haya ganador y se requiere llevar el score
            //como una pizarra ejemplo: 4-3.
            $s1=  explode("-", $_POST['s1']);
            $s2=  explode("-", $_POST['s2']);
            $s3=  explode("-", $_POST['s3']);
            //Validamos que los tiebreak 
            $t1=[NULL,NULL];$t2=[NULL,NULL]; $t3=[NULL,NULL];
            if($s1[0]+$s1[1]>12){
                $t1=  explode("-", $_POST['t1']);
            }
            if($s2[0]+$s2[1]>12){
                $t2=  explode("-", $_POST['t2']);
            }
            if($s3[0]+$s3[1]>12){
                $t3=  explode("-", $_POST['t3']);
            }
          
    }
    
    //Variables para controlar los 2 jugadores si culminaron el juego
    //enviadas por referencia para saber quien es el ganador
    $j1=0;$j2=0;
    $juegocumplido= Reglas_Juego::juego_cumplido($s1, $s2, $s3, $j1, $j2);
    
        
    //Buscamos un jugador de juego
    $objDraw1 = new Torneo_Draw();
    $objDraw1->Fetch($id);
       
    if ($objDraw1->Operacion_Exitosa()){
        //Buscamos el otro jugador segun la posicion del jugador anterior
        $objDraw2 = new Torneo_Draw();
        $objDraw2->FindContrincante($objDraw1->getCategoria_id(),$objDraw1->getRonda(), $objDraw1->getPosicion());
        if ($objDraw1->getPosicion() % 2==0){
            $objDrawJugador2 = $objDraw1;
            $objDrawJugador1 = $objDraw2;
        }else{
            $objDrawJugador2 = $objDraw2;
            $objDrawJugador1 = $objDraw1;
        }
        
        //change Jugador 1
        $objDrawJugador1->setWin(0); //Ganador
        $objDrawJugador1->setSatus($status);
        $objDrawJugador1->setS1($s1[0]);
        $objDrawJugador1->setS2($s2[0]);
        $objDrawJugador1->setS3($s3[0]);
        $objDrawJugador1->setT1($t1[0]);
        $objDrawJugador1->setT2($t2[0]);
        $objDrawJugador1->setT3($t3[0]);

        //change jugador 1
        $objDrawJugador2->setWin(0); //Ganador
        $objDrawJugador2->setSatus($status);
        $objDrawJugador2->setS1($s1[1]);
        $objDrawJugador2->setS2($s2[1]);
        $objDrawJugador2->setS3($s3[1]);
        $objDrawJugador2->setT1($t1[1]);
        $objDrawJugador2->setT2($t2[1]);
        $objDrawJugador2->setT3($t3[1]);
        
        $jugadorw=0;$posicion=0;
        switch ($win) {
            case 1:
                //Ganador el primer jugador
                $objDrawJugador1->setWin(1); //Ganador
                $jugadorw=$objDrawJugador1->getJugador();
                $posicion=$objDrawJugador1->getPosicion();
                $objDrawGanador = $objDrawJugador1;
                $objDrawPerdedor = $objDrawJugador2;
               
                break;

            case 2:
                $objDrawJugador2->setWin(1); //Ganador
                $jugadorw=$objDrawJugador2->getJugador();
                $posicion=$objDrawJugador2->getPosicion();
                
                $objDrawGanador = $objDrawJugador2;
                $objDrawPerdedor = $objDrawJugador1;
               
              
                break;

            default:
                //En caso que funciones como una pizarra
                //Todavia no hay un ganador pero se guarda el score
                //de forma normal ejemplo (5-4) por no haber
                //finalizado el juego aun.
                $objDrawJugador1->setWin(0); //Neutral
                $objDrawJugador2->setWin(0); //Neutarl
                
                break;
        }
         
       
        //Buscamos la tabla Torneo_Categoria para obtener el
        //la categoria de juego del torneo
        
        $objCategoria = new Torneo_Categoria();
        $objCategoria->Find($objDrawGanador->getCategoria_id());
        
        //Buscamos el torneo para obtener el grado 
        $objTorneo = new Torneo();
        $objTorneo->Fetch($objCategoria->getTorneo_id());
        $grado=$objTorneo->getTipo(); //grado del torneo
       
         
        //Resumen de categorias para la tabla de puntos
        switch ($objCategoria->getCategoria()) {
            case '12B':
                $categoria='12B';
                break;
            case 'PN':
                $categoria='PN';
            case 'PV':
                $categoria='PV';
            default:
                $categoria='ALL';
            break;
        }
       
        //Obtenemos el numero de la ronda representada como en la tabla R1,R2,R3,R4
        //print_r("ronda normal ".$objDrawGanador->getRonda());
        $ronda_ganador= Torneo_Draw::Ronda($objDrawGanador->getCategoria_id(),$objDrawGanador->getRonda());
        //print_r("ronda normal ".$ronda_ganador);
        //Tabla de puntaje
        $objPuntos = new Torneo_Puntaje();
        $objPuntos->Fetch("MD", $categoria, $grado, $ronda_ganador);
        $puntosganador = $objPuntos->getPuntos();
        
        
        //print_r("PUNTOS GANADOS".$puntosganador. " RONDA".$ronda_ganador);
         //Cuando haya habido algun retiro o wo
        if ($status != 'JU' && $jugadorw > 0) {
           //Fuerza a finalizar el juego por el estatus
            $juegocumplido = TRUE; 
        }
      
        //Tenemos un ganador y actualizamos el registro de la proxima ronda
        //para identificar el ganador manejando un puntero de la posicion
        //del ganador de la ronda anterior para avanzar.
        if ($jugadorw>0 && $juegocumplido && $objDrawGanador->getRonda()!=2){
        
            $objDrawGanador->Avanzar_Ronda($objDrawGanador->getCategoria_id(),$objDrawGanador->getRonda(), $posicion,$jugadorw,$puntosganador);
            //Fuerza a cero el puntaje del perdedor en caso de cambio de ganador 
            //hasta cuartos de finales
            if($objDrawGanador->getRonda()/2>4){
                $objDrawPerdedor->setPuntos(0);
            }
            $puntos_globales=$objDrawGanador->Puntos();
            
            //Actualiza puntos en la planilla de puntos y penalidades
            $objTorneoInscritos = new TorneosInscritos();
            $objTorneoInscritos->Find_Atleta($objCategoria->getTorneo_id(), $objDrawGanador->getJugador());
            $objTorneoInscritos->setSingles($puntos_globales);
            $objTorneoInscritos->Update();
        }
        
        //Actualizar el puntaje del ganador ya que los dos finalistas tienen el mismo puntaje 
        //de la ronda finalista
        if ($jugadorw>0 && $juegocumplido && $objDrawGanador->getRonda()==2){
            
            $objDrawGanador->setPuntos($puntosganador);
                   
            //Actualiza puntos en la planilla de puntos y penalidades
            $objTorneoInscritos = new TorneosInscritos();
            $objTorneoInscritos->Find_Atleta($objCategoria->getTorneo_id(), $objDrawGanador->getJugador());
            $objTorneoInscritos->setSingles($puntosganador);
            $objTorneoInscritos->Update();
        }
        
        $objDrawJugador1->Update();
        $objDrawJugador2->Update();
          
        if ($juegocumplido){
            echo 0;
        }else{
            echo 1;
        }
        
        
    }else{
        echo 1;
        
    }
 
}else{
    echo 2;
        
}
       

?>
