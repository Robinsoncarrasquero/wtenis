<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Torneos_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Modalidad_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Funciones_cls.sphp';


if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../Login.php');
    exit;
}
if ($_SESSION['niveluser'] > 0) {
    header('Location: ../sesion_inicio.php');
    exit;
}

$afiliado = $_SESSION['afiliado'];
$sweb = $_SESSION['SWEB'];
//print_r("AFILIADO --> :".$afiliado);

//Validamos que la afiliacion sea confirmada
$atleta_id = $_SESSION['atleta_id'];
if ($_SESSION['niveluser'] == 1) {
    $nombre = "(** " . $_SESSION['nombre'] . " **)";
}

//Buscamos atleta
$objAtleta = new Atleta();
$objAtleta->Find($atleta_id);


//Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
$objAfiliado = new Afiliaciones();
$objAfiliado->Find_Afiliacion_Atleta($objAtleta->getID(),date("Y"));

$deshabilitado = $objAfiliado->getPagado() > 0 ? FALSE : TRUE;

$cedulaid = $objAtleta->getCedula();
//  echo '<pre>';
//  var_dump($objAfiliado);
//  echo '</pre>';
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscripcion</title>
    <link rel="stylesheet" href="../css/master_page.css">
    <link rel="shortcut icon" href="<?php echo $_SESSION['favicon'] ?> " />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        
        thead {

            font-size: 10px;

        }

        .bbtn-guardar {
            margin: 0;
            float: left;
        }



        .loader {

            background-image: url("images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 100px;
        }

        nav.navbar {
            background-color: #000;
        }

        .jumbotron {
            background-color: <?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color: <?php echo $_SESSION['color_jumbotron'] ?>;
        }


        .table-head {
            background-color: <?php echo $_SESSION['bgcolor_jumbotron'] ?>;
            color: <?php echo $_SESSION['color_jumbotron'] ?>;
        }

    

        .glyphicon  {
            /* font-size: 12px;
            margin-bottom: 2px; */
            color: #f4511e;
        }
        /* td  {
            font-size: 12px;
        
        }
         */

        /* .fechas  {
            font-size: 12px;
            position: relative; 
        } 
        */
 
/* .container-fluid {
  position: relative;
  padding-left: 2px;
  margin-bottom: 1px;
  cursor: pointer;
  font-size: 12px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
} */


 /* Create a custom checkbox */
.apuntar  {
  height: 25px;
  width: 25px;
  background-color: #eee;
  display: block;
  
}

/* Style the checkmark/indicator */
.apuntar:after {
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

    </style>

</head>

<body>

    <?php
    //Container

    echo '<div class="container-fluid">';

    //Menu de usuario
    require '../Template/Layout_NavBar_User.php';

    //Presentar un Usuario
    echo '<br>';
    echo '<div class="col-xs-12">';
    echo '<hr>';
    echo '<h4>Inscripciones</h4>';
    echo '<h6 class="titulo-name" >Bienvenido :' . $_SESSION['nombre'] . '</h6>';
    echo '</div>'; //Container    

    $strhead = '
    
    <div class="col-xs-12 col-sm-8">
  
    <form action="bsInscripcionChange.php" method="post" >
    <div class="table">
        <table class="table">
                 <thead>
                <tr class="table-head" >
                <th>Status</th>
                <th>Ent</th>
                <th>Grado</th>
                <th>Cat</th>
                <th>Mod.</th>
                <th>Accion</th>
                <th>Fecha</th>
                <th>Li</th>
             </tr>
       
            </thead>
                                           
 ';
    echo $strhead;
    $consulta_mysql = "SELECT * FROM atleta WHERE cedula='" . $cedulaid . "' ";
    //$result_atleta = $conn>query($consulta_mysql); mysqli
    //while($fila = $result_atleta->fetch_assoc()) mysqli
    $result_atleta = mysqli_query($conn,$consulta_mysql);
    $nrtorneos = 0; //Cuenta los torneos disponible para el usuario
    
    while ($fila = mysqli_fetch_assoc($result_atleta)) {
        $atleta_id = $fila["atleta_id"];

        $cedula = $fila["cedula"];
        $nombre = $fila["nombres"];
        $apellido = $fila["apellidos"];
        $fechan = $fila["fecha_nacimiento"];
        $mi_ano_Nacimiento = anodeFecha($fechan); // ANO DE NACIMIENTO
        $atleta_estado = $fila["estado"]; // Asociacion o Entidad Federal
        if (($_SESSION['niveluser'] == 1)) {
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
        } else {
            $consulta_mysql2 = "SELECT * FROM torneo WHERE  estatus='A' "
                . " && condicion='C' "
                . " && fechacierre>= now() "
                . " order by fechacierre,empresa_id";
        }

        $result_torneo = mysqli_query($conn,$consulta_mysql2);
        $record_encontrados = 0;
        while ($filator = mysqli_fetch_assoc($result_torneo)) {
            
            $torneo_id = $filator["torneo_id"];
            $codigo_torneo = $filator["codigo"];
            $codigo_unico = $filator["codigo_unico"];
            $grado_torneo = $filator["tipo"];
            $nombre_torneo = $filator["nombre"];
            $categoria_torneo = trim($filator["categoria"]);
            $modal_torneo = $filator["modalidad"];
            $condicion = $filator["condicion"];
            $entidad = $filator["entidad"];
            $numero = $filator["numero"];
            $fechadecierre = $filator["fechacierre"]; //fecha que se presenta en la pantalla
            
            $fecha_inicio_torneo = $filator["fecha_inicio_torneo"]; //fecha que se presenta en la pantalla

            $fecha_retiros = $filator["fecharetiros"]; //fecha que se presenta en la pantalla
            $estatus = "Inscrito";
            $date_hoy = date_create(); // fecha del servidor 
            $fecha_hoy = date_timestamp_get($date_hoy);
            $date_bd = date_create($filator["fechacierre"]); // fecha cierre de inscripciones 
            $fecha_cierre = date_timestamp_get($date_bd);

            $date_bd = date_create($filator["fechainicio"]); // fecha inicio de inscripciones
            $fecha_inicio = date_timestamp_get($date_bd);

            if ($_SESSION['niveluser'] == 1) {
                $fhoy = date_create();
                $fhoy = date_format($fhoy, "Y-m-d");
                $fecha_cierre = Fecha_Cierre_Admin($fecha_inicio_torneo);
                $fecha_inicio = Fecha_Inicio_Admin($fhoy);
            } else {
                $fecha_inicio = Fecha_Apertura_Calendario($filator["fechacierre"], $filator["tipo"]);
            }

            $dias_diferencia = intval(($fecha_hoy - $fecha_cierre) / 86400);

            $array_Categoria = explode(',', trim($filator["categoria"]));
            $array_ranking = NULL;
            for ($x = 0; $x < count($array_Categoria); $x++) {
                //Tomamos la categoria de la subcategoria(12B)
                $rk_categoria =  substr($array_Categoria[$x], 0, 2);

                $sqlrk = "SELECT rknacional,fecha_ranking FROM ranking  "
                    . "WHERE atleta_id=$atleta_id AND categoria='" . $rk_categoria . "'"
                    . " ORDER BY fecha_ranking DESC LIMIT 1";
                $result_rkn = mysqli_query($conn,$sqlrk);
                $recordRanking = mysqli_fetch_array($result_rkn);
                if ($recordRanking) {
                    $rkn = $recordRanking["rknacional"];
                } else {
                    $rkn = 999;
                }
                $array_ranking[] = $rkn;
            }
            //Combinamos el arreglo de ranking y categoria como clave
            $array_ranking_categoria = array_combine($array_ranking, $array_Categoria);



            //Buscamos ranking de la categoria Natural
            $la_categoria_natural = categoria_natural(($mi_ano_Nacimiento));
            $sqlrk = "SELECT rknacional,fecha_ranking FROM ranking  "
                . "WHERE atleta_id=$atleta_id AND categoria='" . $la_categoria_natural . "'"
                . " ORDER BY fecha_ranking DESC LIMIT 1";
            $result_rkn = mysqli_query($conn,$sqlrk);
            $recordRanking = mysqli_fetch_array($result_rkn);
            if ($recordRanking) {
                $rkn = $recordRanking["rknacional"];
            } else {
                $rkn = 999;
            }
            //Categoria de juego
            $array_Categoria = explode(',', trim($filator["categoria"])); //Array de categoria
            $array_Ano_Nacidos = explode('-', $filator["anodenacimiento"]); // Array Ano de Nacimiento permitido en el torneo
            $array_Ano_Categoria = array_combine($array_AnodeNacimiento, $array_Categoria); // une dos arreglos y devuelve uno asociativo
            $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 

            if ($array_Ano_Nacidos[0] != Null && count($array_Ano_Nacidos) > 0) {
                $contador = $array_Ano_Nacidos[1] - $array_Ano_Nacidos[0];
                if ($contador > 0 && $contador < 99) {
                    for ($x = 0; $x <= $contador; $x++) {
                        $array_ano_nacimiento[] =  strval($array_Ano_Nacidos[0] + $x);
                        $array_ano_categoria[] =  (count($array_Categoria) < $contador ? $array_Categoria[0] : $array_Categoria[$x]);
                    }
                    $array_Ano_Categoria = array_combine($array_ano_nacimiento, $array_ano_categoria); // une dos arreglos y devuelve uno asociativo

                    $mi_Categoria_Estricta = trim($array_Ano_Categoria[$mi_ano_Nacimiento]); // Devuelve la categoria del arreglo asociativo 

                }

                if (in_array($mi_ano_Nacimiento, $array_ano_nacimiento, true)) { // buscamos un string en el arreglo
                    $puedeInscribir = true;
                } else {
                    $puedeInscribir = false;
                }
            } else {
                // Evalua por categoria natural y grado
                //$mis_Categoria=categoria_Torneo($mi_ano_Nacimiento);
                $mis_Categoria =  Categoria_Grado_Torneo($mi_ano_Nacimiento, $array_ranking_categoria, $grado_torneo, $rkn,$numero);
                $array_mi_Categoria = explode(',', $mis_Categoria);
                $mi_Categoria_Estricta = NULL;


                $puedeInscribir = false;
                for ($x = 0; $x < count($array_Categoria); $x++) {
                    if (in_array($array_Categoria[$x], $array_mi_Categoria, true)) {
                        $puedeInscribir = true;
                    }
                }
            }

            //Los torneos Nacionales o Regionales estan permitidos solo para los afiliados
            //y los estadales para todos los atletas del pais.
            $empresa_id = $_SESSION['empresa_id'];

            //idempre del Administrador de la asociaicon con clave master
            $empresa_id_admin = $_SESSION['empresa_id_admin'];



            $torneo_permitido = true;
            //El afiliado tiene solicitado el servicio pero aun no la ha pagado
            //por tanto se le permite ver las inscripciones de forma inhabilitado


            //Busca el estado que oferta los torneos G4
            if ($torneo_permitido) {
                //ACTIVAR CUADO HAY NUEVAS ASOCIACIONES
                $sql2 = "SELECT estado FROM empresa WHERE  empresa_id=" . $filator["empresa_id"];

                $result2 = mysqli_query($conn,$sql2);
                $row = mysqli_fetch_array($result2);
                if ($row) {
                    $asociacion = $row["estado"];
                } else {
                    $asociacion = "N/A";
                }
            }
            if ($fecha_hoy > $fecha_inicio &&  $fecha_hoy < $fecha_cierre && $puedeInscribir && $torneo_permitido) {
                $nrotorneos++;

                $record_encontrados++;
                $consulta_mysql = "SELECT modalidad,categoria,torneoinscrito_id,pagado FROM torneoinscritos "
                    . "WHERE torneo_id=$torneo_id AND atleta_id=$atleta_id";
                $resultado_SQL_inscritos = mysqli_query($conn,$consulta_mysql);

                $row = mysqli_fetch_array($resultado_SQL_inscritos);

                $array_modalidad = NULL;
                if ($row) {
                    $flaginscrito = true;
                    $array_modalidad =  explode(",", $row["modalidad"]);
                    $categoriainscrita = $row["categoria"];
                    $torneo_inscrito_id = $row["torneoinscrito_id"];
                    $torneopagado = $row["pagado"];
                } else {
                    $flaginscrito = false;

                    $torneo_inscrito_id = 0;
                    $categoriainscrita = ($mi_Categoria_Estricta != NULL) ? $mi_Categoria_Estricta : NULL;
                    $torneopagado = 0;
                    $array_modalidad[] = 'SS';
                }

                if ($flaginscrito) {
                    $estatus = "Ok";
                    $chk = "checked";
                    $chkinscribe = "disabled";
                    $chkdesinscribe = " ";
                    if ($torneopagado > 0) {
                        $chkdesinscribe = "disabled";
                        $estatus = "Confirmado";
                    }
                    if ($_SESSION['niveluser'] == 1) {
                        $chkinscribe = " ";
                    }
                } else {
                    $estatus = "Open";
                    $chk = " ";
                    $chkinscribe = " ";
                    $chkdesinscribe = "disabled";
                }


                //Devuelve un arreglo con los iconos a imprimir relacionados con el estatus
                $array_tr = Funciones::Estatus_Inscripcion($estatus);

                //Determina el estatus del torneo(Factorizado)
                $estatus_torneo =  Torneo::Estatus_Torneo($fechadecierre, $fecha_inicio_torneo, $grado_torneo, $condicion);

                //$deshabilitado= $_SESSION['niveluser']==1 ? FALSE :  $_SESSION['deshabilitado'];
                //Verifica que el atleta este Federado 
                if ($deshabilitado) {
                    //Validamos si la afiliacion esta confirmada
                    $estatus = "Inactivo";
                    $chk = "";
                    $chkinscribe = "disabled";
                    $chkdesinscribe = "disabled";
                    $array_tr = Funciones::Estatus_Inscripcion($estatus, "");
                    echo $array_tr[0]; //echo '<tr class=" " >';
                    echo $array_tr[1]; //echo "<td><p class='glyphicon glyphicon-lock'></p></td>";

                } else {
                    if ($flaginscrito) {
                        if ($torneopagado > 0) {
                            $array_tr = Funciones::Estatus_Inscripcion($estatus, "");
                            echo $array_tr[0]; //echo '<tr class="warning"  >  ';
                            echo $array_tr[1]; //echo "<td><p class='glyphicon glyphicon-usd'></p></td>";
                        } else {
                            $array_tr = Funciones::Estatus_Inscripcion($estatus, "");
                            echo $array_tr[0]; //'<tr class="success"  >  ';
                            echo $array_tr[1]; //'<td><p class=" glyphicon glyphicon-ok"  ></p></td>  ';
                        }
                    } else {
                        //                    echo '<tr class=" " >';
                        //                    echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";
                        //Estatus abierto
                        $array_tr = Funciones::Estatus_Inscripcion($estatus, "");
                        echo $array_tr[0]; //echo '<tr class=" " >';
                        echo $array_tr[1]; //echo "<td><p class='glyphicon glyphicon-pencil'></p></td>";

                    }
                }



                //LLENAMOS LA LINEA CON LOS DATOS
                if ($modal_torneo == "TDP") {
                    $modalidad = "Tenis de Playa";
                } else {
                    $modalidad = "Tenis de Campo";
                }

                //            echo "<td data-toggle='tooltip' data-placement='auto' title='Estatus'>$estatus_torneo</td>";
                echo "<td data-toggle='tooltip' data-placement='auto' title='Entidad o Estado'>$entidad</td>";
                echo "<td data-toggle='tooltip' data-placement='auto' title='Grado'>$numero-$grado_torneo</td>";


                //            echo "<td data-toggle='tooltip' data-placement='auto' title='Torneo'>$nombre_torneo</td>";
                //            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Cierre'>$fechadecierre</td>";
                //            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Retiro'>$fecha_retiros</td>";
                //            echo "<td data-toggle='tooltip' data-placement='auto' title='Fecha Inicio'>$fecha_inicio_torneo</td>";

                echo '<td data-toggle="tooltip" data-placement="auto" title="Categoria">';
                //echo "$numero-$grado_torneo<br>";
                
                $readonly = 'readonly';
                //Aqui imprimimos el Select para las opciones
                echo "<select id='Categoria$torneo_id' $chkinscribe name='" . $torneo_id . "'>";
                if ($mi_Categoria_Estricta != NULL) {

                    // Caso Estricto cuando los atletas deben jugar una categoria segun el ano de nacimiento
                    // manejado en el caso de un Master que son solo los nacidos en un ano(2000(26) 2002(14) y 2004(12)
                    // se deshabilita las opciones para que el usuario no puede cambiar la categoria que es por defecto
                    // definida en la carga.
                    for ($x = 0; $x < count($array_Categoria); $x++) { // vamos a imprimir las categorias en el elemento select
                        if ($array_Categoria[$x] != $categoriainscrita) {
                            echo "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        } else {
                            echo "<option selected value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        }
                    }
                } else {


                    // Caso no estricto el usuario puede seleccionar cualquier categoria de juego.
                    // solo se pone en default la que ya ha seleccionado.
                    //                for ($x=0; $x < count($array_Categoria); $x++){ // vamos a imprimir las categorias en el elemento select
                    //                    $selectedx= ($array_Categoria[$x]!=$categoriainscrita ? " " :" selected  ");
                    //                    echo "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                    //                }

                    for ($x = 0; $x < count($array_Categoria); $x++) { // vamos a imprimir las categorias en el elemento select

                        if (in_array($array_Categoria[$x], $array_mi_Categoria, true)) {
                            $selectedx = ($array_Categoria[$x] != $categoriainscrita ? " " : " selected  ");
                            echo "<option $selectedx value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        } else {
                            echo "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                        }
                    }
                }
                $dato = $torneo_id . "," . $atleta_id . "," . $torneo_inscrito_id . "," . $categoriainscrita . ",INS," . $codigo_unico;
                echo '</select>';
                echo "</td>";


                //Controlamos la modalidad de juego(single,doble,mixto)
                //Aqui se toma una categoria cualquiera. Considerando que las categorias
                //siempre juegan las mismas modalidades.
                //El solo hecho que una categoria tenga una modalidad definida
                //para la inscripcion;todas la asumen por defecto.

                //Tomamos la categoria en la posicion inicial[0] de $array_Categoria[0]
                //segun lo definido anteriormente.
                $rsmodalidades = NULL;
                $rsmodalidades =  Modalidad::ReadByCategoria($array_Categoria[0]);
                echo '<td data-toggle="tooltip" data-placement="auto" title="Ctrl + Click">';
                echo '<select id="Modalidad' . $torneo_id . '" multiple name="M' . $torneo_id . '[]" >';

                foreach ($rsmodalidades as $value) {
                    $select = " ";
                    if (in_array($value['modalidad'], $array_modalidad, true)) {
                        $select = " selected ";
                    }
                    echo '<option class="miselect"  ' . $select . 'value="' . $value['modalidad'] . '">' . $value['descripcion'] . '</option>';
                }

                echo '</select>';
                echo "</td>";


                echo '<td>';
                if ($flaginscrito) {
                    echo "<p class='glyphicon glyphicon-trash'><input class='apuntar' id=\"$torneo_id\" data-id=\"$dato\"type=\"checkbox\"  name=\"chkeliminar[]\" value=\"$dato\" $chkdesinscribe ></p> ";
                } else {
                    echo "<p class='glyphicon glyphicon-pencil'><input class='apuntar' id=\"$torneo_id\" data-id=\"$dato\"type=\"checkbox\"  name=\"chkinscribir[]\" value=\"$dato\" $chk $chkinscribe></p>";
                }
                echo '</td>';

                //Fechas del Torneo
                echo "<td class='fechas' data-toggle='tooltip' data-placement='auto' title='Fechas'>"
                    . ""
                    . "<p class='ffechacierre'>Cierre: ". date_format(date_create($fechadecierre),"d-M  H:i")."</p>"
                    . "<p class='ffecharetiro'>Retiro: ".date_format(date_create($fecha_retiros),"d-M  H:i")."</p>"
                    . "<p class='ffechainicio'>Inicio: ".date_format(date_create($fecha_inicio_torneo),"d-M  H:i")."</p>"
                    . ""
                    . "</td>";

                if (!$deshabilitado) {
                    echo "<td><a href='../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t=" .
                        urlencode(Encrypter::encrypt($codigo_torneo)) . "' target='_blank'</a>Ver</td>";
                } else {
                    echo "<td><a  target='_blank'</a>Ver</td>";
                }

                echo '</tr>';
            }
            
        }
    }


    //mysqli_close($conn);mysqli
    mysqli_close($conn);
    
    echo "      </table>";
    
    echo "</div>";
        if ($nrotorneos > 0) {
            echo '
                <div class="col-xs-12">
                    <input  type="submit" name="btnProcesar" value="Guardar" class="btn btn-primary btn-guardar" > 
                </div> ';
        } else {
    
            echo '<h5 class="alert alert-warning">' . Bootstrap_Class::texto("Mensaje :") . '
            <br><br> No hay Torneos disponibles en este momento.</h5>';
        }
    echo "</form>";


    //Fin lado izquierdo
    echo "</div>";

    //Inicio Lado derecho
    echo '<div class="col-xs-12 col-sm-4">';
    
    
        echo '<div class="notas-left ">';
        echo '<h5 class="alert alert-warning">' . Bootstrap_Class::texto("Excepcion :", "success") . ''
            . '<br><br>'
            . 'Solo est&aacute permitido inscribir un evento en la misma fecha del calendario.</h5>';


        echo '<h5 class="alert alert-info">' . Bootstrap_Class::texto("Inscripcion :", "success") . '
                        <br><br>
                        1. Seleccione la Categoria y la Accion.<br>
                        2. Pulse el boton (Guardar).<br>
                        3. Asegurate que el torneo seleccionado sea de color verde agua.</h5>';
        echo '</div>';
        


    //Fin lado derecho
    echo '</div>';

    ?>




    <script>
        //var myVar = setInterval(myTimer, 1000);

        function myTimer() {
            var d = new Date();
            document.getElementById("hora").innerHTML = "Fecha: " + myfecha(0) + " - " + "Hora: " + d.toLocaleTimeString();
            //document.getElementById("hora").innerHTML = myfecha()+"</br>"+d.toDateString() +"</br>"+"HORA: " + d.toLocaleTimeString();
        }

        function myfecha(conMeses) {
            var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            var f = new Date();
            if (conMeses === 1) {
                return (f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
            } else {
                return (f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear());
            }
        }


        function xApuntarme() {

            var myid = $(this).attr("id");

            var selectModalidad = $("#Modalidad" + myid).val() || [];
            $("#resultadoValue").text(selectModalidad);
            // Obtener el texto del las opciones selecionadas

            var selectCategoria = $("#Categoria" + myid).val() || [];
            $("#resultadoValueCategoria").text(selectCategoria);

            var datos = $(this).attr("data-id");
            var Id = $(this).attr("data-id");
            var chkimprime = Id.substr(0, 3);

            var url = "bsInscripcionChangeAjax.php";

            {
                $.ajax({
                        method: "POST",
                        url: url,
                        data: {
                            datos: datos,
                            modalidad: selectModalidad,
                            categoria: selectCategoria
                        }
                    })
                    .done(function(data) {
                        $("#mensaje").html(data.Mensaje);
                        if (data.Success) {
                            alert("Operacion Realizada exitosamente");
                        } else {
                            alert("Error: Operacion no fue exitosamente");
                        }
                        location.reload();



                    })
                    .fail(function(xhr, status, errorThrown) {
                        alert("Sorry, there was a problem!");
                      
                    });
            }
        }

        $("input[type=checkbox]").on("click", Apuntarme);


        $('.miselect').change(function() {
            alert("miselect");
            // Obtener valor del las opciones selecionadas
            var selectValue = $("#miselect").val() || [];
            $("#resultadoValue").text(selectValue);
            // Obtener el texto del las opciones selecionadas
            var selectText = $("#miselect option:selected").map(function() {
                return $(this).text();
            }).get().join(',');
            $('#resultadoTexto').text(selectText);

        });
    </script>
</body>

</html>