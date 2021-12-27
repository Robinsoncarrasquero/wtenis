<?php
session_start();
require_once '../sql/Crud.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funcion_archivos.php';
error_reporting(1);
if  ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $empresa_id=$_SESSION['empresa_id'];
    $torneo_id = $_POST['torneo_id'];
    
    $unombre = htmlspecialchars(strtoupper( $_POST['nombre']));
    $umonto =   htmlspecialchars($_POST['monto']);
    $uiva =   htmlspecialchars($_POST['iva']);
    $udisponibilidad =   htmlspecialchars(strtoupper($_POST['disponibilidad']));
    $uestatus = htmlspecialchars($_POST['estatus']);
    if ($udisponibilidad=="D"){// Torneo deshabilitado desde nivel superior
     $uestatus   ='I';
    }
    $utipo = htmlspecialchars($_POST['tipo']);
    $ucategoria = htmlspecialchars($_POST['categoria']);
    $ufechainicio = ($_POST['fecha_inicio_torneo'])." ". ($_POST['fecha_inicio_torneo_hora']);
    $ufechacierre = ($_POST['fechacierre'])." ". ($_POST['fechacierrehora']);
    
    $ufecharetiros = ($_POST['fecharetiros'])." ".($_POST['fecharetiroshora']);
    $ufecha_inicio_torneo = ($_POST['fecha_inicio_torneo'])." ". ($_POST['fecha_inicio_torneo_hora']);
    $ufecha_fin_torneo = ($_POST['fecha_fin_torneo'])." ". ($_POST['fecha_fin_torneo_hora']);
    $uarbitro =   htmlspecialchars($_POST['arbitro']);
    $ucondicion=$_POST['condicion'];
    $umodalidad=$_POST['modalidad'];
    
    $ucategoriaplana=  implode(explode(",",$ucategoria));
    $uano = $_POST['anotorneo'];
    $unumero =   htmlspecialchars($_POST['numtorneo']);
    $uentidad =   htmlspecialchars(strtoupper($_POST['entidad']));
    $ucodigo=$uano.$unumero.$utipo.$ucategoriaplana.$uentidad;
    $ucodigo_unico=$uano.$unumero.$utipo.$ucategoriaplana;
    $asociacion='';
   
    $uanodenacimiento = $_POST['anodenacimiento'];
    //El ano de nacimiento para el filtro es aplicable si la categoria es unica ej:18
    //No puede haber filtro para dos categorias a la vez ejemplo(14,18)
    if(count(explode(",",$ucategoria))>1){
        $uanodenacimiento=NULL;
    }
    
    $ok=FALSE;
    if ($torneo_id==0){
        
        //Creamos un nuevo registro de torneo
        $objeto = new Crud();
        $objeto->table_name="torneo";
        $objeto->insertInto="torneo";
        $objeto->insertColumns="codigo,nombre,monto,iva,estatus,categoria,fechainicio,fechacierre,"
                . "fecharetiros,fecha_inicio_torneo,fecha_fin_torneo,tipo,empresa_id,arbitro,"
                . "condicion,modalidad,ano,numero,entidad,codigo_unico,asociacion,anodenacimiento";

        $objeto->insertValues="'$ucodigo','$unombre','$umonto','$uiva','$uestatus','$ucategoria','$ufechainicio',"
                . "'$ufechacierre','$ufecharetiros','$ufecha_inicio_torneo','$ufecha_fin_torneo',"
                . "'$utipo',$empresa_id,'$uarbitro','$ucondicion','$umodalidad','$uano','$unumero',"
                . "'$uentidad','$ucodigo_unico','$asociacion','$uanodenacimiento'";
        $objeto->Create();
       
        $torneo_id= $objeto->id;
       $mensaje ="Create Torneos :". $objeto->mensaje;
    
    }  else {
        
        //Hacemos update   
        $objeto = new Crud();
        $objeto->update="torneo";

        $objeto->set="codigo='$ucodigo',nombre='$unombre',monto='$umonto',iva='$uiva',estatus='$uestatus',asociacion=''"
                . ",tipo='$utipo',categoria='$ucategoria',fechainicio='$ufechainicio'"
                . ",fechacierre='$ufechacierre',fecharetiros='$ufecharetiros',fecha_inicio_torneo='$ufecha_inicio_torneo'"
                . ",fecha_fin_torneo='$ufecha_fin_torneo',arbitro='$uarbitro'"
                . ",condicion='$ucondicion',modalidad='$umodalidad',disponibilidad='$udisponibilidad',entidad='$uentidad'";

        $objeto->condition="torneo_id=$torneo_id";
        $objeto->Update();
        $mensaje .="UPDATE Torneos :". $objeto->mensaje;
        

    }
    
    $folder_destino = dirname(dirname(__FILE__)).'\/FILE_TORNEO/';

    $subir = count($_FILES);
    $subidos = 0;
    $maximobytes = 1600000;
    //$folder_destino="../FILE_TORNEO/";
    $array_documento=array('fs','ds','dd','la');
  
    //Subir los archivos al servidor mediante un arreglo de archivos  
    //Son 4 archivos fs,ds,dd,la
    for($i=0;$i<4;$i++){
        $filename="Torneo_".trim(strval($torneo_id))."_".$array_documento[$i];
        if ($_FILES["fsheet"]["size"][$i]>0){
            if (upload_file("fsheet",$i,$filename,$folder_destino)){
                file_archivos_delete($array_documento[$i],$torneo_id);
                file_archivos_create($torneo_id,$_FILES["fsheet"]["type"][$i],$array_documento[$i],$filename,$folder_destino);
            }
        }
        $subidos++;
    }
    //Si hubo alguna modificacion o algun archivo fue subido 
    
    if ($objeto->operacionExitosa){
        $jsondata = array("Success" =>TRUE,"Mensaje"=>"Registro exitoso.......");
    }else{
        $jsondata = array("Success" =>FALSE,"Mensaje"=>" Error en el registro o Torneo ya esta creado... ".$mensaje);
    }

        

    header('Content-type: application/json; charset=utf-8');
    echo  json_encode($jsondata, JSON_FORCE_OBJECT);
  
}

//Funcion para eliminar el archivo anterior
function file_archivos_delete($documento,$torneo_id) {
    $operacionExitosa = FALSE;
    $objfs = new Crud();
    $objfs->deleteFrom = "torneo_archivos";
    $objfs->condition = "doc ='$documento' && torneo_id=" . $torneo_id;
    $objfs->Delete();
    $operacionExitosa = $objfs->operacionExitosa;
    
    return $operacionExitosa;    
}
//Funcion para crear el nuevo archivo subido
function file_archivos_create($torneo_id,$fsheet_type,$documento,$filename,$folder_destino) {
    //$fsbinario = Contenido_Blob($fstmpName);
    $objfs = new Crud();
    $objfs->insertInto = "torneo_archivos";
    $objfs->insertColumns = "torneo_id,tipo,doc,filename,folder";
    $objfs->insertValues = "$torneo_id,'$fsheet_type','$documento','$filename','$folder_destino'";
    $objfs->Create();

    return $objfs->operacionExitosa; 
}
 
?>
