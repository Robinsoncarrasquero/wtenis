<?php
//Programa para guardar la lista de posiciones en la lista y en el draw
session_start();

require_once '../clases/Torneo_Draw_cls.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once "../clases/Torneo_Lista_cls.php";
require_once "../clases/Torneo_Categoria_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";

require_once '../sql/ConexionPDO.php';
if (!isset($_SESSION['logueado']) || $_SESSION['niveluser']<9){
    header('Location: ../sesion_usuario.php');
    exit;
}
//Esta variables viene con los valores key torneo,categoria, sexo separados por guion(-)
$key_id =explode("-",$_POST['tid']); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo

//Ubicamos la categoria del torneo
$objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
$objCategoria->Fetch($torneo_id, $categoria, $sexo);
$categoria_id=$objCategoria->get_id(); 
if ($objCategoria->getPublicar()==0){
    $nrojugadores = Torneo_Lista::Count_Jugadores($categoria_id);

    $ronda = $nrojugadores; //Ronda que son el numero de jugadores

    $datastr= json_decode($_POST['datajson'],true); // Categoria

    $array = array_splice($datastr,0);
    $strTable2=$array;
    foreach ($array as $value) {
        $strTable .="<br>Poscion Draw:".$value["posiciondraw"]."</br>";
        $atleta_id=$value["id"];
        $posicion_draw = $value["posiciondraw"];
        $posicion_lista = $value["posicionlista"];
        $rk=$value['rk'];
        if ($value["posiciondraw"]!=NULL){
            $datos[]=  array('posiciondraw'=>$posicion_draw,"jugador"=>$atleta_id);

        }

        //Actualizamos el ranking el archivo de inscripciones de torneos para luego general la lista
        $objInscripcion = new TorneosInscritos();
        $objInscripcion->Find_Atleta($torneo_id,$atleta_id);
        $rk>0 ? $objInscripcion->setRknacional($rk) : $objInscripcion->setRknacional(999);
        $objInscripcion->Update();


        //Actualizamos la lista de jugadores de acuerdo a la posiciones modificadas
        $objLista = new Torneo_Lista();
        $objLista->FindPosicion($categoria_id, $ronda, $posicion_lista);
        $objLista->setPosiciondraw($posicion_draw);
        $objLista->setRanking($rk);
        $objLista->Update();
        if ($objLista->Operacion_Exitosa()){
            //Actualizamos el draw en la posiciones asignadas
            $objDraw = new Torneo_Draw();
            $objDraw->FindPosicion($categoria_id, $ronda, $posicion_draw);      //var_dump($objTorneo->getMensaje());
            if ($objDraw->Operacion_Exitosa()){
                $objDraw->setJugador($atleta_id);
                $objDraw->Update();
            }
        } 


    }

    /*
    Asignacion de BYE
    Obtenemos una lista de columnas para ordenar el array $datos 
    y tomar las posiciones de draw y jugador pasar los bye
    a la proxima ronda.

     */
    foreach ($datos as $clave => $fila) {
        $posicion[$clave] = $fila['posiciondraw'];
        $jugador[$clave] = $fila['jugador'];

    }
    array_multisort($posicion,SORT_ASC,$jugador,SORT_ASC,$datos);

    foreach ($datos as $value) {
        $posicion_draw = $value["posiciondraw"];
        $array_jugadores[]=$value["jugador"];
        //Determinamos el jugador con bye

        //Siempre buscamos la posiciones par para manejar dos jugadores 
        if ($posicion_draw % 2==0 ){
            $posicion_bye = $posicion_draw/2;
            $jugador_bye=0;
            //Verificamos si hay algun bye para pasarlos a la ronda siguiente
            if ($array_jugadores[$posicion_draw-2]==0 || $array_jugadores[$posicion_draw-1]==0){
                $jugador_bye= $array_jugadores[$posicion_draw-2]>0 ? $array_jugadores[$posicion_draw-2] :$array_jugadores[$posicion_draw -1];
            }
            $objJugadorBye = new Torneo_Draw();
            $objJugadorBye->FindPosicion($categoria_id,$ronda/2, $posicion_bye); 
            if ($jugador_bye>0){
                 $objJugadorBye->setWin(1);
                $objJugadorBye->setJugador($jugador_bye);
                $objJugadorBye->Update();
            }else{
                $objJugadorBye->setJugador(0);
                $objJugadorBye->Update();
            }

            //Colocamos BYE a los jugadores en la primera ronda
            if ($jugador_bye>0){
                //Buscamos el jugador con bye partiendo de la posicion draw
                $objJugador1 = new Torneo_Draw();
                $objJugador1->FindPosicion($categoria_id,$ronda, $posicion_draw); 
                $objJugador1->setSatus('BYE');
                $objJugador1->Update();

                //Busca el contricante con la posicion del otro jugador
                $objJugador2 = new Torneo_Draw();
                $objJugador2->FindContrincante($categoria_id,$ronda, $posicion_draw); 
                $objJugador2->setSatus('BYE');
                $objJugador2->Update();


            }
        }



    }
}


 
//if ($ok) {
//    echo json_encode(array("status" => "OK"));
//} else {
//    echo json_encode(array("status" => "FAIL", "error" => $datos));
//}
//var_dump($strTable2);





   





    


