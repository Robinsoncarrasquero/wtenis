<?php



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Incripcion_cls
 *
 * @author robinson
 */
class Inscripcion_cls {
    //put your code here
    
    
    
public static function inscripcion_reload($cedulaid) {
        
  $strHTML=' ';

  $consulta_mysql = "SELECT * FROM atleta WHERE cedula='".$cedulaid."'";
  //$result_atleta = $conn>query($consulta_mysql); mysqli
  //while($fila = $result_atleta->fetch_assoc()) mysqli
  $result_atleta = mysqli_query($consulta_mysql);
  $nrtorneos=0;//Cuenta los torneos disponible para el usuario
  while ($fila = mysql_fetch_assoc($result_atleta )) 
                
    {
      $atleta_id=$fila["atleta_id"];
      $cedula=$fila["cedula"];
      $nombre= $fila["nombres"];
      $apellido= $fila["apellidos"];
      $fechan= $fila["fecha_nacimiento"];
      $mi_ano_Nacimiento = anodeFecha($fechan); // ANO DE NACIMIENTO
      $atleta_estado=$fila["estado"]; // Asociacion o Entidad Federal
    
      if (($_SESSION['niveluser']==1)){
        //$consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' and  ADDDATE(fechacierre, INTERVAL 5 DAY)>= Now()  order by fechacierre";
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A'
                            and condicion IS NULL
                            and  ADDDATE(fecha_inicio_torneo, INTERVAL 30 DAY)>= now()
                            and  ADDDATE(NOW(), INTERVAL 30 DAY)>= fecha_fin_torneo 
                            order by fecha_inicio_torneo";
        
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A'"
                . " && (condicion='C' || condicion IS NULL)"
                . " &&  ADDDATE(fecha_inicio_torneo, INTERVAL 10 DAY)>= Now()  "
                . " &&  ADDDATE(NOW(), INTERVAL 40 DAY)>= fecha_fin_torneo "
                . " order by fechacierre,empresa_id";
       
      }else{
        $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' "
                . " && condicion='C' "
                . " && fechacierre>= now() "
                . " order by fechacierre,empresa_id";
      }
      
      $result_torneo = mysql_query($consulta_mysql2);
      $record_encontrados=0;
      while($filator = mysql_fetch_assoc($result_torneo)){
       
        $torneo_id=$filator["torneo_id"];
        $codigo_torneo=$filator["codigo"];
        $codigo_unico=$filator["codigo_unico"];
        $grado_torneo=$filator["tipo"];
        $nombre_torneo=$filator["nombre"];
        $categoria_torneo=trim($filator["categoria"]);
        $modal_torneo=$filator["modalidad"];
        $condicion=$filator["condicion"];
        $entidad=$filator["entidad"];
        $numero=$filator["numero"];
        $fechadecierre= $filator["fechacierre"]; //fecha que se presenta en la pantalla
        
        $fecha_inicio_torneo= $filator["fecha_inicio_torneo"]; //fecha que se presenta en la pantalla
        
        $fecha_retiros= $filator["fecharetiros"]; //fecha que se presenta en la pantalla
        $estatus="Inscrito";
        $date_hoy=date_create(); // fecha del servidor 
        $fecha_hoy= date_timestamp_get($date_hoy);
        $date_bd = date_create($filator["fechacierre"]); // fecha cierre de inscripciones 
        $fecha_cierre =date_timestamp_get($date_bd);
        
        $date_bd= date_create($filator["fechainicio"]); // fecha inicio de inscripciones
        $fecha_inicio =date_timestamp_get($date_bd);
       
       if ($_SESSION['niveluser']==1){
            $fhoy= date_create();
            $fhoy= date_format($fhoy,"Y-m-d");
            $fecha_cierre = Fecha_Cierre_Admin($fecha_inicio_torneo);
            $fecha_inicio = Fecha_Inicio_Admin($fhoy);
          
        }else{
            $fecha_inicio = Fecha_Apertura_Calendario($filator["fechacierre"],$filator["tipo"]);
        }
        
        $dias_diferencia=intval(($fecha_hoy-$fecha_cierre)/86400);
       
        $array_Categoria= explode(',',trim($filator["categoria"]));
        $array_ranking=NULL;
        for($x=0;$x<count($array_Categoria);$x++){
            //Tomamos la categoria de la subcategoria(12B)
            $rk_categoria=  substr($array_Categoria[$x],0,2);
            
            $sqlrk="SELECT rknacional,fecha_ranking FROM ranking  "
                . "WHERE atleta_id=$atleta_id AND categoria='".$rk_categoria."'"
                ." ORDER BY fecha_ranking DESC LIMIT 1";
            $result_rkn = mysql_query($sqlrk);
            $recordRanking = mysql_fetch_array($result_rkn);
            if ($recordRanking){
                $rkn = $recordRanking["rknacional"];
            }else{
                $rkn=999;
            }
            $array_ranking[]=$rkn;
        }
        //Combinamos el arreglo de ranking y categoria como clave
        $array_ranking_categoria = array_combine( $array_ranking,$array_Categoria);
        
//        echo  "<pre>";
//        var_dump("TORNEO: $torneo_id CATEGORIA :".trim($filator["categoria"]));
//        echo "</pre>";
//        echo  "<pre>";
//        var_dump($array_Categoria);
//        var_dump($array_ranking);
//        var_dump($array_ranking_categoria);
//        echo "</pre>";
//        
//        $clave=array_search("12B",$array_ranking_categoria);
//        
//        echo  "<pre>";
//        var_dump("EXISTE 12B ? ".$clave);
//        echo "</pre>";
        
        
        //Buscamos ranking de la categoria Natural
        $la_categoria_natural= categoria_natural(($mi_ano_Nacimiento));
        $sqlrk="SELECT rknacional,fecha_ranking FROM ranking  "
                . "WHERE atleta_id=$atleta_id AND categoria='".$la_categoria_natural."'"
                ." ORDER BY fecha_ranking DESC LIMIT 1";
        $result_rkn = mysql_query($sqlrk);
        $recordRanking = mysql_fetch_array($result_rkn);
        if ($recordRanking){
            $rkn = $recordRanking["rknacional"];
        }else{
            $rkn=999;
        }
        //Categoria de juego
        $array_Categoria= explode(',',trim($filator["categoria"])); //Array de categoria
        $array_Ano_Nacidos = explode ('-', $filator["anodenacimiento"]); // Array Ano de Nacimiento permitido en el torneo
        $array_Ano_Categoria= array_combine ($array_AnodeNacimiento , $array_Categoria ); // une dos arreglos y devuelve uno asociativo
        $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 
    
        if ($array_Ano_Nacidos[0]!=Null && count($array_Ano_Nacidos)>0 ){
            $contador= $array_Ano_Nacidos[1]-$array_Ano_Nacidos[0];
            if ($contador>0 && $contador<99){
                for ($x=0;$x<=$contador;$x++){
                    $array_ano_nacimiento[]=  strval($array_Ano_Nacidos[0] + $x);
                    $array_ano_categoria[]=  (count($array_Categoria)<$contador ? $array_Categoria[0] : $array_Categoria[$x]);
                    
                    
                }
                $array_Ano_Categoria= array_combine ($array_ano_nacimiento , $array_ano_categoria ); // une dos arreglos y devuelve uno asociativo
       
                $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 
        
            }
           
            if (in_array($mi_ano_Nacimiento , $array_ano_nacimiento,true)) { // buscamos un string en el arreglo
                $puedeInscribir=true;
            }else{
                $puedeInscribir=false;
            }
            
        } else{
            // Evalua por categoria natural y grado
            //$mis_Categoria=categoria_Torneo($mi_ano_Nacimiento);
            $mis_Categoria=  Categoria_Grado_Torneo($mi_ano_Nacimiento, $array_ranking_categoria, $grado_torneo, $rkn);
            $array_mi_Categoria=explode(',',$mis_Categoria);
            $mi_Categoria_Estricta=NULL;

            
            $puedeInscribir=false;
            for ($x=0 ; $x < count($array_Categoria); $x++){
                if (in_array($array_Categoria[$x],$array_mi_Categoria,true)){
                    $puedeInscribir=true;
                }
            }
        }
        
        //Los torneos Nacionales o Regionales estan permitidos solo para los afiliados
        //y los estadales para todos los atletas del pais.
        $empresa_id=$_SESSION['empresa_id'];
        
        //idempre del Administrador de la asociaicon con clave master
        $empresa_id_admin=$_SESSION['empresa_id_admin'];
        
        
            
        $torneo_permitido=true;
        //El afiliado tiene solicitado el servicio pero aun no la ha pagado
        //por tanto se le permite ver las inscripciones de forma inhabilitado
        
      
        //Busca el estado que oferta los torneos G4
        if ($torneo_permitido){
           //ACTIVAR CUADO HAY NUEVAS ASOCIACIONES
           $sql2 = "SELECT estado FROM empresa WHERE  empresa_id=".$filator["empresa_id"]; 
          
           $result2 = mysql_query($sql2);
           $row = mysql_fetch_array($result2);
            if ($row){
                $asociacion=$row["estado"];
            }else{
                $asociacion="N/A";
            }
           
        }
   
        if ( $fecha_hoy>$fecha_inicio &&  $fecha_hoy <$fecha_cierre && $puedeInscribir && $torneo_permitido){
          $nrotorneos++;
            
            $record_encontrados ++;
            $consulta_mysql = "SELECT modalidad,categoria,torneoinscrito_id,pagado FROM torneoinscritos "
                    . "WHERE torneo_id=$torneo_id AND atleta_id=$atleta_id";
            $resultado_SQL_inscritos = mysql_query($consulta_mysql);

            $row = mysql_fetch_array($resultado_SQL_inscritos);
            
            $array_modalidad=NULL;
            if ($row){
                $flaginscrito=true;
                $array_modalidad=  explode(",",$row["modalidad"]);
                $categoriainscrita=$row["categoria"];
                $torneo_inscrito_id=$row["torneoinscrito_id"];
                $torneopagado = $row["pagado"];
               
                
            }else{
                 $flaginscrito=false;
                 
                 $torneo_inscrito_id=0;
                 $categoriainscrita=($mi_Categoria_Estricta!=NULL) ? $mi_Categoria_Estricta : NULL;
                 $torneopagado = 0;
                 $array_modalidad[]='SS';
                
                
            }
            
            if ($flaginscrito){
               $estatus="Ok";
               $chk="checked";
               $chkinscribe="disabled";
               $chkdesinscribe=" ";
                if ($torneopagado>0){
                    $chkdesinscribe="disabled";
                    $estatus = "Confirmado";
                }
                if ($_SESSION['niveluser']==1){
                    $chkinscribe=" ";
                }
            }else{
               $estatus="Open";
               $chk=" ";
               $chkinscribe=" ";
               $chkdesinscribe="disabled";
            }
            
           
            //Devuelve un arreglo con la table row a imprimir
            $array_tr= Torneo::Estatus_Inscripcion($estatus);

            //Determina el estatus del torneo(Factorizado)
            $estatus_torneo=  Torneo::Estatus_Torneo($fechadecierre, $fecha_inicio_torneo, $grado_torneo, $condicion);
            
            $deshabilitado= $_SESSION['niveluser']==1 ? FALSE : $_SESSION['deshabilitado'];
            if ($deshabilitado){
                //Validamos si la afiliacion esta confirmada
                $estatus = "Inactivo";
                $chk = "";
                $chkinscribe = "disabled";
                $chkdesinscribe = "disabled";
                $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                $strHTML .= $array_tr[0];//echo '<tr class=" " >';
                $strHTML .= $array_tr[1];//echo "<td><p class='glyphicon glyphicon-lock'></p></td>";
                
            }else{
                if  ($flaginscrito) {
                    if ($torneopagado>0){
                        $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                        $strHTML .= $array_tr[0];//echo '<tr class="warning"  >  ';
                        $strHTML .= $array_tr[1];//echo "<td><p class='glyphicon glyphicon-usd'></p></td>";
                    }else {
                        $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                        $strHTML .= $array_tr[0];//'<tr class="success"  >  ';
                        $strHTML .= $array_tr[1];//'<td><p class=" glyphicon glyphicon-ok"  ></p></td>  ';
                    }
                    
                }else{
//                    echo '<tr class=" " >';
//                    echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";
                   //Estatus abierto
                   $array_tr= Torneo::Estatus_Inscripcion($estatus,"");
                   $strHTML .= $array_tr[0];//echo '<tr class=" " >';
                   $strHTML .= $array_tr[1];//echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";
                   
                }
            }
                
                
            
            //LLENAMOS LA LINEA CON LOS DATOS
            if ($modal_torneo=="TDP"){
               $modalidad="Tenis de Playa" ;
            }else{
               $modalidad="Tenis de Campo" ;
            }
            
//            echo "<td data-toggle='tooltip' data-placement='auto' title='Estatus'>$estatus_torneo</td>";
            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Entidad o Estado'>$entidad</td>";
            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Grado'>$numero-$grado_torneo</td>";
            
             $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha Cierre'>"
            . ""
            . "<p class='fechacierre'>Cierre: $fechadecierre</p>"
            . "<p class='fecharetiro'>Retiro: $fecha_retiros</p>"
            . "<p class='fechainicio'>Inicio: $fecha_inicio_torneo</p>"
            . ""
            . "</td>";
           
//            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Torneo'>$nombre_torneo</td>";
//            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha Cierre'>$fechadecierre</td>";
//            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha Retiro'>$fecha_retiros</td>";
//            $strHTML .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha Inicio'>$fecha_inicio_torneo</td>";

            $strHTML .= '<td data-toggle="tooltip" data-placement="auto" title="Categoria">';
            $readonly='readonly';
            //Aqui imprimimos el Select para las opciones
            $strHTML .= "<select id='Categoria$torneo_id' $chkinscribe name='".$torneo_id."'>";
            if ($mi_Categoria_Estricta!=NULL){
                    
                 // Caso Estricto cuando los atletas deben jugar una categoria segun el ano de nacimiento
                 // manejado en el caso de un Master que son solo los nacidos en un ano(2000(26) 2002(14) y 2004(12)
                 // se deshabilita las opciones para que el usuario no puede cambiar la categoria que es por defecto
                 // definida en la carga.
                 for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
                    if ($array_Categoria[$x]!=$categoriainscrita){
                       $strHTML .= "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                    }else{
                       $strHTML .= "<option selected value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                    }
                }
                
             }else{
                    
                 
                // Caso no estricto el usuario puede seleccionar cualquier categoria de juego.
                // solo se pone en default la que ya ha seleccionado.
//                for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
//                    $selectedx= ($array_Categoria[$x]!=$categoriainscrita ? " " :" selected  ");
//                    $strHTML .= "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
//                }
                
                for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
               
                    if (in_array($array_Categoria[$x],$array_mi_Categoria,true)){
                       $selectedx= ($array_Categoria[$x]!=$categoriainscrita ? " " :" selected  ");
                       $strHTML .= "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                       
                    }else{
                        $strHTML .= "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        
                       
                    }
                }
            }
            $dato=$torneo_id.",".$atleta_id.",".$torneo_inscrito_id.",".$categoriainscrita.",INS,".$codigo_unico;
             $strHTML .= '</select>';
            $strHTML .= "</td>";
           
            
            //Controlamos la modalidad de juego(single,doble,mixto)
            //Aqui se toma una categoria cualquiera. Considerando que las categorias
            //siempre juegan las mismas modalidades.
            //El solo h$strHTML .= que una categoria tenga una modalidad definida
            //para la inscripcion;todas la asumen por defecto.
            
            //Tomamos la categoria en la posicion inicial[0] de $array_Categoria[0]
            //segun lo definido anteriormente.
            $rsmodalidades=NULL;
            $rsmodalidades =  Modalidad::ReadByCategoria($array_Categoria[0]);
            $strHTML .= '<td data-toggle="tooltip" data-placement="auto" title="Ctrl + Click">';
            $strHTML .= '<select id="Modalidad'.$torneo_id.'" multiple name="M'.$torneo_id.'[]" >';
            
            foreach ($rsmodalidades as $value) {
                $select=" ";
                if (in_array($value[modalidad],$array_modalidad,true)){
                   $select=" selected ";
                }
                $strHTML .= '<option class="miselect"  '. $select .'value="'.$value[modalidad].'">'.$value[descripcion].'</option>';
            }
             
            $strHTML .= '</select>';
            $strHTML .= "</td>";
            
            //Check de Apuntar y Borrar
            $strHTML .= '<td>';
            if($flaginscrito){
                $strHTML .= "<p class='borrar'>Borrar<input class='apuntar' id=\"$torneo_id\" data-id=\"$dato\"type=\"checkbox\"  name=\"chkeliminar[]\" value=\"$dato\" $chkdesinscribe ></p> ";
            }else{
                $strHTML .= "<p class='apuntar'>Apuntar<input class='apuntar' id=\"$torneo_id\" data-id=\"$dato\"type=\"checkbox\"  name=\"chkinscribir[]\" value=\"$dato\" $chk $chkinscribe></p> ";
            
            }
            $strHTML .= '</td>';
           
            if (!$deshabilitado){
                $strHTML .= "<td><a href='../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t=".
                        urlencode(Encrypter::encrypt($codigo_torneo)). "' target='_blank'</a>Ver</td>";
            }else{
                $strHTML .= "<td><a  target='_blank'</a>Ver</td>";
            }
                
            $strHTML .= '</tr>';
     
        }
      }
    
  }
  
//mysqli_close($conn);mysqli
mysql_close($conn);

$strHTML .= " </table>";

 if ($nrotorneos>0){
//$strHTML .= '<div class="col-xs-12">
//         <input  type="submit" name="btnProcesar" value="Guardar" class="btn btn-primary btn-guardar" > 
//      </div> ';

}else{

   $strHTML .= '<p class="alert alert-warning">'.Bootstrap_Class::texto("Mensaje :").' No hay Torneos disponibles en este momento.</P>';

} 
$strHTML .= "</div>";
//$strHTML .= "</form>";
return $strHTML;

        
}
    
    
}
