<?php
session_start();
require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud_1.php';
require_once '../funciones/funcion_fecha.php';
require_once '../funciones/funcion_archivos.php';

if  ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $empresa_id=$_SESSION['empresa_id'];
    $torneo_id = htmlspecialchars($_POST['torneo_id']);
    //$torneo_id = $_POST['torneo_id'];
    //$ucodigo =   htmlspecialchars(strtoupper($_POST['codigo']));
   
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
   // $ufechainicio = ($_POST['fechainicio'])." ".($_POST['fechainiciohora']);
    $ufechainicio = ($_POST['fecha_inicio_torneo'])." ". ($_POST['fecha_inicio_torneo_hora']);
    $ufechacierre = ($_POST['fechacierre'])." ". ($_POST['fechacierrehora']);
    
    $ufecharetiros = ($_POST['fecharetiros'])." ".($_POST['fecharetiroshora']);
    $ufecha_inicio_torneo = ($_POST['fecha_inicio_torneo'])." ". ($_POST['fecha_inicio_torneo_hora']);
    $ufecha_fin_torneo = ($_POST['fecha_fin_torneo'])." ". ($_POST['fecha_fin_torneo_hora']);
    $uarbitro =   htmlspecialchars($_POST['arbitro']);
    $ucondicion=$_POST['condicion'];
    $umodalidad=$_POST['modalidad'];
    
    //NUEVO
    $ucategoriaplana=  implode(explode(",",$ucategoria));
    $uano = $_POST['anotorneo'];
    $unumero =   htmlspecialchars($_POST['numtorneo']);
    $uentidad =   htmlspecialchars(strtoupper($_POST['entidad']));
    $ucodigo=$uano.$unumero.$utipo.$ucategoriaplana.$uentidad;
    $ucodigo_unico=$uano.$unumero.$utipo.$ucategoriaplana;
   
    $ok=2;
    if ($torneo_id==0){
        $objeto = new Crud();
        $objeto->table_name="torneo";
        $objeto->insertInto="torneo";
        $objeto->insertColumns="codigo,nombre,monto,iva,estatus,categoria,fechainicio,fechacierre,"
                . "fecharetiros,fecha_inicio_torneo,fecha_fin_torneo,tipo,empresa_id,arbitro,"
                . "condicion,modalidad,ano,numero,entidad,codigo_unico";

        $objeto->insertValues="'$ucodigo','$unombre','$umonto','$uiva','$uestatus','$ucategoria','$ufechainicio',"
                . "'$ufechacierre','$ufecharetiros','$ufecha_inicio_torneo','$ufecha_fin_torneo',"
                . "'$utipo',$empresa_id,'$uarbitro','$ucondicion','$umodalidad','$uano','$unumero',"
                . "'$uentidad','$ucodigo_unico'";
        
        

        $objeto->Create();
        echo $objeto->mensaje;
        $torneo_id= $objeto->id;
        if ($objeto->operacionExitosa) {
            $ok=0;

        }else{
            $ok=1;
        }
        
    }  else {
        
        //Cargamos los campos para verificar cambios de propiedades en el objeto instanciado
        $objeto = new Crud();
        $objeto->table_name="torneo";
        $objeto->select="*";
        $objeto->from="torneo";
        $objeto->condition="torneo_id=$torneo_id";
        $objeto->Read();
        $records = $objeto->rows;
        $objeto->fields_change('codigo', $ucodigo);
        $objeto->fields_change('nombre', $unombre);
        $objeto->fields_change('monto', $umonto);
        $objeto->fields_change('iva', $uiva);
        $objeto->fields_change('estatus', $uestatus);
        $objeto->fields_change('tipo', $utipo);
        $objeto->fields_change('categoria', $ucategoria);
        $objeto->fields_change('fechainicio', $ufechainicio);
        $objeto->fields_change('fechacierre', $ufechacierre);
        $objeto->fields_change('fecharetiros', $ufecharetiros);
        $objeto->fields_change('fecha_inicio_torneo', $ufecha_inicio_torneo);
        $objeto->fields_change('fecha_fin_torneo', $ufecha_fin_torneo);
        $objeto->fields_change('arbitro', $uarbitro);
        $objeto->fields_change('condicion', $ucondicion);
        $objeto->fields_change('modalidad', $umodalidad);
        $objeto->fields_change('disponibilidad', $udisponibilidad);
        $objeto->fields_change('entidad', $uentidad);
        
        
        if ($objeto->isDirty()) {
            $objetoup = new Crud();
            $objetoup->update="torneo";

            $objetoup->set="codigo='$ucodigo',nombre='$unombre',monto='$umonto',iva='$uiva',estatus='$uestatus',asociacion=''"
                    . ",tipo='$utipo',categoria='$ucategoria',fechainicio='$ufechainicio'"
                    . ",fechacierre='$ufechacierre',fecharetiros='$ufecharetiros',fecha_inicio_torneo='$ufecha_inicio_torneo'"
                    . ",fecha_fin_torneo='$ufecha_fin_torneo',arbitro='$uarbitro'"
                    . ",condicion='$ucondicion',modalidad='$umodalidad',disponibilidad='$udisponibilidad',entidad='$uentidad'";

            $objetoup->condition="torneo_id=$torneo_id";
            $objetoup->Update();
            $mensaje .="UPDATE Torneos :". $objetoup->mensaje;
            if ($objetoup->operacionExitosa){
                $ok=0;
                
            }else{
                
                $ok=1;
                

            }
        }
    }
    
    
    $objFiles = new Crud();
    $objFiles->table_name="torneo_archivos";
    $objFiles->select="*";
    $objFiles->from="torneo_archivos";
    $objFiles->condition="torneo_id=$torneo_id";
    $objFiles->Read();
    $rsArchivos = $objFiles->rows;
    
    $subir = count($_FILES);
    $subidos = 0;
    $fssize = $_FILES["fsheet"]["size"][0];
    $fsname = $_FILES["fsheet"]["name"][0];
    $fstmpName = $_FILES['fsheet']['tmp_name'][0];
    $fsheet_type = $_FILES["fsheet"]["type"][0];
    $maximobytes = 800000;

    if ($fssize > 0) {

        foreach ($rsArchivos as $rsRow) {
            if ($rsRow['documento'] == "fsheet") {
                $objfs = new Crud();
                $objfs->deleteFrom = "torneo_archivos";
                $objfs->condition = "id=" . $rsRow['id'];
                $objfs->Delete();
                $operacionExitosa = $objfs->operacionExitosa;
            }
        }
        $fsbinario = Contenido_Blob($fstmpName);
        $objfs = new Crud();
        $objfs->insertInto = "torneo_archivos";
        $objfs->insertColumns = "torneo_id,contenido,tipo,documento";
        $objfs->insertValues = "$torneo_id,'$fsbinario','$fsheet_type','fsheet'";
        $objfs->Create();
        $subidos++;
    }
    
    

    //Subimos draw de singles
    $drsize = $_FILES["fsheet"]["size"][1];
    $drname = $_FILES["fsheet"]["name"][1];
    $drtmpName = $_FILES['fsheet']['tmp_name'][1];
    $draw_type = $_FILES["fsheet"]["type"][1];

    if ($drsize > 0 && $drsize <= $maximobytes) {
        $mensaje.="entrando a draw delete";
        foreach ($rsArchivos as $rsRow) {
            if ($rsRow['documento'] == "draw") {
                $objdr = new Crud();
                $objdr->deleteFrom = "torneo_archivos";
                $objdr->condition = "id=" . $rsRow['id'];
                $objdr->Delete();
                $operacionExitosa = $objdr->operacionExitosa;
            }
        }
        //$draw = mysql_real_escape_string(file_get_contents($_FILES['draw']['tmp_name']));
        //Cargamos Draw
        $drbinario = Contenido_Blob($drtmpName);
        $objdr = new Crud();
        $objdr->insertInto = "torneo_archivos";
        $objdr->insertColumns = "torneo_id,contenido,tipo,documento";
        $objdr->insertValues = "$torneo_id,'$drbinario','$draw_type','draw'";
        $objdr->Create();

        $objdr = NULL;
        $subidos++;
        
        
    }
    //Subimos draw de dobles
    $drsize = $_FILES["fsheet"]["size"][2];
    $drname = $_FILES["fsheet"]["name"][2];
    $drtmpName = $_FILES['fsheet']['tmp_name'][2];
    $draw_type = $_FILES["fsheet"]["type"][2];

    if ($drsize > 0 && $drsize <= $maximobytes) {
        $mensaje.="entrando a draw delete";
        foreach ($rsArchivos as $rsRow) {
            if ($rsRow['documento'] == "drawd") {
                $objdr = new Crud();
                $objdr->deleteFrom = "torneo_archivos";
                $objdr->condition = "id=" . $rsRow['id'];
                $objdr->Delete();
                $operacionExitosa = $objdr->operacionExitosa;
            }
        }
        //$draw = mysql_real_escape_string(file_get_contents($_FILES['draw']['tmp_name']));
        //Cargamos Draw
        $drbinario = Contenido_Blob($drtmpName);
        $objdr = new Crud();
        $objdr->insertInto = "torneo_archivos";
        $objdr->insertColumns = "torneo_id,contenido,tipo,documento";
        $objdr->insertValues = "$torneo_id,'$drbinario','$draw_type','drawd'";
        $objdr->Create();

        $objdr = NULL;
        $subidos++;
        
        
    }
    
     //Subimos lista de aceptacion
    $drsize = $_FILES["fsheet"]["size"][3];
    $drname = $_FILES["fsheet"]["name"][3];
    $drtmpName = $_FILES['fsheet']['tmp_name'][3];
    $draw_type = $_FILES["fsheet"]["type"][3];

    if ($drsize > 0 && $drsize <= $maximobytes) {
        $mensaje.="entrando a lista delete";
        foreach ($rsArchivos as $rsRow) {
            if ($rsRow['documento'] == "lista") {
                $objdr = new Crud();
                $objdr->deleteFrom = "torneo_archivos";
                $objdr->condition = "id=" . $rsRow['id'];
                $objdr->Delete();
                $operacionExitosa = $objdr->operacionExitosa;
            }
        }
        //$draw = mysql_real_escape_string(file_get_contents($_FILES['draw']['tmp_name']));
        //Cargamos Draw
        $drbinario = Contenido_Blob($drtmpName);
        $objdr = new Crud();
        $objdr->insertInto = "torneo_archivos";
        $objdr->insertColumns = "torneo_id,contenido,tipo,documento";
        $objdr->insertValues = "$torneo_id,'$drbinario','$draw_type','lista'";
        $objdr->Create();

        $objdr = NULL;
        $subidos++;
        
        
    }
    if ($subidos>0){
        $ok=0;
    }
    if ($ok!=2){
        if ($ok>0){
            echo "1";
        }else{
            echo "0";
        }
        
    }else{
        echo "Invalid data";
    
    }
    

}
       

?>
