<?php
session_start();
require_once '../clases/Noticias_cls.php';
require_once '../sql/ConexionPDO.php';
if(isset($_SESSION['logueado']) and !$_SESSION['logueado'] && $_SESSION['niveluser']<9 ){
   header('Location: Login.php');
 }

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $empresa_id=$_SESSION['empresa_id'];
    //$operacion=$_POST['operacion'];
    $txt_titulo=$_POST['txt_titulo'];
    $txt_mininoticia=$_POST['txt_mininoticia'];
    $summernote= $_POST['content'];
    $txt_autor=$_POST['txt_autor'];
    $txt_id=$_POST['txt_id'];
    $txt_estatus=$_POST['txt_estatus'];
    
    $ok=FALSE;
    if (count($_FILES) > 0) {

        print_r(count($_FILES));
    }
    $autor = "Sys";
    if ($txt_id>0){

    //    print_r("REGISTRO NUMERO:".$txt_id);
        //Instanciamos el objeto y actualizamos datos

        $obj = new Noticias();
        $obj->Fetch($txt_id);
        $obj->setTitulo($txt_titulo);
        $obj->setMiniNoticia($txt_mininoticia);
        $obj->setNoticia($summernote);
        $obj->setAutor($txt_autor);
        $obj->setEstatus($txt_estatus);

        //echo $txt_id." ".$txt_src_imagen." ".$txt_mininoticia;
        $obj->Update();
        if ($obj->Operacion_Exitosa()){
            $ok=TRUE;
        }
        
        $obj= NULL;

       

//        $conn =  mysql_connect($servername, $username, $password);
//        $result=mysql_select_db($dbname,$conn);
//        //Comprobamos que los inputs no estén vacíos, y si lo están, mandamos el mensaje correspondiente
//           //Si el tamaño es correcto, subimos los datos
//        $sql = "UPDATE noticias SET noticia='".$summernote."',titulo='".$titulo."',mininoticia='".$mininoticia."',autor='".$autor."'  WHERE noticia_id=$txt_id";
//
//
//        //                            die("id devuelto : ".$id);



//       $result2=mysql_query($sql);
//       if($result2){
//         $ok=TRUE;
//       }
//       mysql_close($conn);


   } elseif ($txt_id <1) {
        //Instanciamos el objeto empresa para traer los datos
                $obj = new Noticias();
                $obj->setTitulo($txt_titulo);
                $obj->setEmpresa_id($empresa_id);
                $obj->setMiniNoticia($txt_mininoticia);
                $obj->setNoticia($summernote);
                $obj->setAutor($txt_autor);
                $obj->setEstatus($txt_estatus);
                $obj->create();
                echo $obj->getMensaje();
                if ($obj->Operacion_Exitosa()){
                    $ok=TRUE;
                }
                $obj= NULL;
               
        ////        $conn =  mysql_connect($servername, $username, $password);
        ////        $result=mysql_select_db($dbname,$conn);
        ////        //Comprobamos que los inputs no estén vacíos, y si lo están, mandamos el mensaje correspondiente
        ////           //Si el tamaño es correcto, subimos los datos
        ////        $sql = "INSERT INTO noticias ( noticia,titulo,empresa_id) VALUES ('".$txt_noticia."','NEW',1)";
        //
    //
    //        //                            die("id devuelto : ".$id);
        //        $result=mysql_query($sql);
        //        $id= mysql_insert_id();

//        $conn = mysql_connect($servername, $username, $password);
//        $result = mysql_select_db($dbname, $conn);
//        //Comprobamos que los inputs no estén vacíos, y si lo están, mandamos el mensaje correspondiente
//        //Si el tamaño es correcto, subimos los datos
//        $sql = "INSERT INTO noticias ( noticia,titulo,autor,mininoticia,empresa_id) VALUES ('" . $summernote . "','$titulo','$autor','$mininoticia',1)";
//         $result=mysql_query($sql);
//         $id = mysql_insert_id();
//        //Hacemos la inserción, y si es correcta, se procede
//        if ($id > 0) {
//            //Reiniciamos los inputs
//            //Cerramos la conexión con MySQL
//            //Mostramos un mensaje
//            print_r("El contenido  fue subido KB.");
//            $ok=TRUE;
//        } else {
//            //Si hay algún error con la inserción, se muestra un mensaje
//            print_r("ERROOR:" . mysql_error());
//        }


//        mysql_close($conn);
    }



    if ($ok){
        echo json_encode(array("status" => "OK"));
      
    }else{
        echo json_encode(array("status" => "FAIL","error" => $operacion));
      
    } 
}
//header('Location: NoticiasModal.php');
exit;






    
?>
 

    
    

