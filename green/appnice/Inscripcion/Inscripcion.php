<?php
session_start();
require_once '../conexion.php';
require_once '../clases/Torneos_cls.php';
require_once '../clases/Torneos_Inscritos_cls.php';
require_once '../clases/Ranking_cls.php';
require_once '../funciones/funcion_fecha.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Modalidad_cls.php';
require_once '../clases/Encriptar_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../funciones/bsTemplate.php';
require_once '../clases/Funciones_cls.php';

if (!isset($_SESSION['logueado']) || !isset($_SESSION['niveluser'])) {
    //Si el usuario no está logueado redireccionamos al login.
    header('Location: ../Login.php');
    exit;
}
if ($_SESSION['niveluser'] > 0) {
    header('Location: ../sesion_inicio.php');
    exit;
}


$atleta_id = $_SESSION['atleta_id'];

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
$atleta_id=$_SESSION['atleta_id'];

 echo bsTemplate::header('Inscripcion',$_SESSION['nombre']);
 echo bsTemplate::aside();
 //Main content
 $main = [];
 $dmain =["opcion"=>"Inscripcion","icono"=>"icon_document","href"=>""];
 array_push($main, $dmain);
 echo  bsTemplate::main_content('Inscripcion',$main);

$thead = [];
$thead +=["."=>"glyphicon glyphicon-time"];
$thead +=[" "=>"glyphicon glyphicon-map-marker"];
$thead +=["Grado"=>"glyphicon glyphicon-cog"];
$thead +=["Categoria"=>"glyphicon glyphicon-signal"];
$thead +=["Modalidad"=>"glyphicon glyphicon-road"];
$thead +=["Accion"=>"glyphicon glyphicon-flash"];
$thead +=["Fecha"=>"glyphicon glyphicon-calendar"];
$thead +=["Lista"=>"glyphicon glyphicon-list-alt"];
$table_head= bsTemplate::table_head("Inscripcion",$thead);

$table_footer='
                   </tbody>
                </table>
            </section>
        </div>
    </div>';

?>
    <div class="col-md-8">
    <form  method="post"  action="InscripcionChange.php" >
        <div id="error">
                <!-- error will be showen here ! -->
        </div>
        <?php echo $table_head;?>

<?php
    

$nrtorneos = 0; //Cuenta los torneos disponible para el usuario
    
    
$mi_ano_Nacimiento = $objAtleta->anoFechaNacimiento(); // ANO DE NACIMIENTO

//Buscamos los torneos abiertos
$rsTorneos= Torneo::Torneos_Open();
foreach ($rsTorneos as $filator)
 {       
    $torneo_id = $filator["torneo_id"];
    $codigo_torneo = $filator["codigo"];
    $codigo_unico = $filator["codigo_unico"];
    $categoria_torneo = trim($filator["categoria"]);
    $modal_torneo = $filator["modalidad"];
    $condicion = $filator["condicion"];
    $entidad = $filator["entidad"];
    $numero = $filator["numero"];
    $grado_torneo = $filator["tipo"];
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

    //$fecha_inicio = Fecha_Apertura_Calendario($filator["fechacierre"], $filator["tipo"]);
    $fecha_inicio = Torneo::Fecha_Apertura_Calendario($filator["fechacierre"], $filator["tipo"]);
    
    $array_Categoria = explode(',', trim($filator["categoria"]));
    $array_ranking =[];
    for ($x = 0; $x < count($array_Categoria); $x++) {
        //Tomamos la categoria de la subcategoria(12B)
        $rk_categoria =  substr($array_Categoria[$x], 0, 2);
        $objRanking = new Ranking();
        $objRanking->Find($objAtleta->getID(),$rk_categoria);
        if ($objRanking->Operacion_Exitosa()) {
            $rkn = $objRanking->getRknacional();
        } else {
            $rkn = 999;
        }
        $array_ranking[] = $rkn;
    }
    //Combinamos el arreglo de ranking y categoria como clave
    $array_ranking_categoria = array_combine($array_ranking, $array_Categoria);

    //Buscamos el ranking de la categoria Natural
    $la_categoria_natural = categoria_natural($mi_ano_Nacimiento);
    $objRanking->Find($objAtleta->getID(),$la_categoria_natural);
    if ($objRanking->Operacion_Exitosa()) {
        $rkn = $objRanking->getRknacional();
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
   
    if (Torneo::Fecha_Apertura_Calendario($filator['fechacierre'],$filator['tipo']) <= Torneo::Fecha_Hoy() 
    && Torneo::Fecha_Create($filator['fechacierre']) > Torneo::Fecha_Hoy()
    && $puedeInscribir) {

    //if ($fecha_hoy > $fecha_inicio &&  $fecha_hoy < $fecha_cierre && $puedeInscribir) {
        $nrotorneos++;
        $record_encontrados++;
        $objTorneoInscritos = new TorneosInscritos();
        $row= TorneosInscritos::TorneosByAtletaId($filator['torneo_id'],$objAtleta->getID());
        
        $array_modalidad = NULL;
        if ($row){
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
        } else {
            $estatus = "Open";
            $chk = " ";
            $chkinscribe = " ";
            $chkdesinscribe = "disabled";
        }

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
        echo "<td class =' ' data-toggle='tooltip' data-placement='auto' title='Entidad o Estado'>$entidad</td>";
        echo "<td class =' ' data-toggle='tooltip' data-placement='auto' title='Grado'>$numero-$grado_torneo</td>";
        echo "<td class =' ' data-toggle='tooltip' data-placement='auto' title='Categoria'>";
        //echo "$numero-$grado_torneo<br>";
        
        $readonly = 'readonly';
        //Aqui Select de Categoria
        echo "<select id='Categoria$torneo_id' $chkinscribe name='" . $torneo_id . "'>";
        if ($mi_Categoria_Estricta != NULL) {
            // Caso Estricto cuando los atletas deben jugar una categoria segun el ano de nacimiento
            // manejado en el caso de un Master que son solo los nacidos en un ano(2000(26) 2002(14) y 2004(12)
            // se deshabilita las opciones para que el usuario no puede cambiar la categoria que es por defecto
            // definida en la carga.
            for ($x = 0; $x < count($array_Categoria); $x++) {
                // vamos a imprimir las categorias en el elemento select
                if ($array_Categoria[$x] != $categoriainscrita) {
                    echo "<option disabled value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                } else {
                    echo "<option selected value=' $array_Categoria[$x]'>$array_Categoria[$x]</option>";
                }
            }
        } else {
            for ($x = 0; $x < count($array_Categoria); $x++) { 
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
        //echo '<select id="Modalidad' . $filator['torneo_id']. '" multiple name="M' . $filator['torneo_id'] . '[]" >';
        echo '<select id="Modalidad' . $torneo_id . '" multiple name="M' . $torneo_id . '[]" >';

        foreach ($rsmodalidades as $value) {
            $select = " ";
            if (in_array($value['modalidad'], $array_modalidad, true)) {
                $select = " selected ";
            }
            echo '<option class="miselect"  ' . $select . 'value="' . $value['modalidad'] . '">' . $value['descripcion'] . '</option> ';
        }

        echo '</select>';
        echo "</td>";


        echo '<td>';
        if ($flaginscrito) {
            echo "<p class='glyphicon glyphicon-trash'><input class='apuntar' 
            id=\"$torneo_id\" data-id=\"$dato\" type=\"checkbox\"  name=\"chkeliminar[]\" value=\"$dato\" $chkdesinscribe ></p> ";
        } else {
            echo "<p class='glyphicon glyphicon-pencil'><input class='apuntar'
             id=\"$torneo_id\" data-id=\"$dato\" type=\"checkbox\"  name=\"chkinscribir[]\" value=\"$dato\" $chk $chkinscribe></p>";
        }
        echo '</td>';

        //Fechas del Torneo
        echo "<td class=' small italic fechas' data-toggle='tooltip' data-placement='auto' title='Fechas'>"
            . ""
            . "<p class='ffechacierre'>Cierre: ". date_format(date_create($fechadecierre),"d-M  H:i")."</p>"
            . "<p class='ffecharetiro'>Retiro: ".date_format(date_create($fecha_retiros),"d-M  H:i")."</p>"
            . "<p class='ffechainicio'>Inicio: ".date_format(date_create($fecha_inicio_torneo),"d-M  H:i")."</p>"
            . ""
            . "</td>";

        if (!$deshabilitado) {
           // echo "<td><a href='../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t=" .
            echo "<td><a href='../Torneo/ListadoInscritos.php?t=" .
                urlencode(Encrypter::encrypt($codigo_torneo)) . "' target='_blank'</a>Ver</td>";
        } else {
            echo "<td><a  target='_blank'</a>Ver</td>";
        }

        echo '</tr>';
    }
}

    echo $table_footer;

if ($nrotorneos>0){
    echo '
        <div class="">
            <input  type="submit" name="btnProcesar" id="btn-submit" value="Guardar" class="btn btn-primary" > 
        </div>
    ';
}else{
    $mensaje=''
    . 'No hay torneos disponibles para inscribir en este momento.';
    echo bsTemplate::mensaje_alerta('Informacion ',$mensaje,'alert alert-success','col-xs-12');
}
echo "</form>";
echo "</div>";

    
    //echo "</div>";
    //Fin lado izquierdo
 
    //Inicio Lado derecho
    
    if ($nrotorneos>0){
 
    $texto=' '
    . 'Solo est&aacute permitido inscribir un evento del mismo grado en la misma fecha del calendario.';
     echo bsTemplate::panel('<i class="glyphicon glyphicon-plus label label-warning"></i>Inscribir',$texto,
     ' alert alert-info','hidden-xs- hidden-sm  col-md-4');
  
    $texto=' '
    .'1. Seleccione la Categoria <br>'
    .'2. Seleccione la Modalidad <br>'
    .'3. Seleccione la Accion <br>'
    .'4. Pulse el boton (Guardar) <br>'
    .'5. Asegurate que el torneo seleccionado sea de color verde agua';
     echo bsTemplate::panel('<i class="glyphicon glyphicon-hdd label label-warning"></i>Guardar',$texto,
     ' alert alert-info','hidden-xs- hidden-sm  col-md-4');
  
    //Fin lado derecho

    }
 
?>

<?php echo bsTemplate::footer();?>

<script>
 
    const chkEliminar = document.querySelector('.apuntar');

    chkEliminar.addEventListener('click',chkApuntar);


    function chkApuntar(){
        swal({
        title: "Presiona guardar cuando hayas seleccionado todas tus opciones",
        text: "Inscribir o Borrar en un solo paso",
        timer: 3000,
        showConfirmButton: false
        });
    }
 


$('#register-form').on('submit',function(e){
    var ok=confirm("Esta Seguro de Modificar Los Datos");
    var data = $("#register-form").serialize();
    var data = $("#register-form :input").serializeArray();
    //var data = JSON.stringify(frmdata);

    $.ajax({
    type : 'POST',
    url  : 'InscripcionChange2.php',
    data : {data:data},
    beforeSend: function()
    {	
        $("#error").html('').fadeOut(100);
        $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Procesando ...');
    },
    success :  function(data)
        {						
            if(!data.success){
                // $("#error").fadeIn(1000, function(){
                //     $("#error").html('<div class="alert alert-danger">'
                //     +'<span class="glyphicon glyphicon-circle"></span>'+data.msg+'</div>');
                // });
            
                swal('Exito !',data.msg,'success');
    
            }else{
                swal('Error !',data.msg,'warning');
                $("#error").fadeIn(1000, function(){
                    $("#error").html('<div class="alert alert-success"><span class="glyphicon glyphicon-thumbs-up">'
                    +'</span> &nbsp;'+data.msg+'</div>');
                    $("#btn-submit").html('<span class="glyphicon glyphicon-ok"></span> &nbsp; Guardar');
                });
                dJSON= data.Retirados;
                $.each(dJSON, function(i,item){
                    $("#"+dJSON[i].retiro).prop("disabled","disabled");
                	//document.write("<br>"+i+" - "+miJSON[i].retiro);
        		});
                
     
            }
        }
    });
    return false;
})

    </script>

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