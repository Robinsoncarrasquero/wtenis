

<?php
//Este programa crea la lista y el draw de los jugadores de un torneo
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../funciones/ReglasdeJuego_cls.php';
require_once '../clases/Torneo_Draw_cls.php';
require_once '../clases/Torneo_Lista_Sorteo_cls.php';
require_once '../clases/Torneo_Lista_cls.php';
require_once '../clases/Torneo_Categoria_cls.php';
require_once '../clases/Atleta_cls.php';
if(isset($_SESSION['logueado']) and $_SESSION['logueado']){
    $nombre = $_SESSION['nombre'];
    $cedula =$_SESSION['cedula'];
    $email =$_SESSION['email'];
 
 }else{
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../sesion_inicio.php');
    exit;
 }
if ( $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}



$key_id =explode("-",$_POST['tid']); 
$torneo_id=$key_id[0];
$categoria=$key_id[1]; // Categoria
$sexo = $key_id[2]; //Sexo
$op=$_POST['operacion'];

//Ubicamos la categoria del torneo
$objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
$objCategoria->Fetch($torneo_id, $categoria, $sexo);
if ($objCategoria->getPublicar()==0){
 

    //Creamos la lista de jugadores y creamos el draw simultaneamente
    if ($op=='lista'){
        
        if ($objCategoria->Operacion_Exitosa()){
            $objCategoria->Delete();

        }

        $objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
        $objCategoria->create();
        $categoria_id=$objCategoria->get_id(); 


        //Crear la lista de Jugadores inscritos
        $objlista = new Torneo_Lista();
        $objlista->Crear_Lista($categoria_id);

        //Generar el draw inicial sin jugadores y verifica qeue no haya
        //registros creados
        Torneo_Draw::Crear_Draw($categoria_id);


    }

    //Realizamos el sorteo de los puestos son siembras y todos los puestos
    If ($op=="sorteo"){

        $objCategoria= new Torneo_Categoria($torneo_id, $categoria, $sexo);
        $objCategoria->Fetch($torneo_id, $categoria, $sexo);
        $categoria_id=$objCategoria->get_id(); 
        if ($categoria_id>0){

            //Crear la lista de Jugadores inscritos
            $objTorneo_Lista_Torneo = new Torneo_Lista_Sorteo($categoria_id);
            $objTorneo_Lista_Torneo->SORTEAR_SORTEAR($categoria_id);

        }

    }
}
