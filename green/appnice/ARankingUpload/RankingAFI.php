<?PHP

session_start();
require_once '../funciones/funcion_monto.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

 if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<99){
    header('Location: ../sesion_inicio.php');
    exit;
}

//Tomamos la empresa actual que es la Principal Jerarquica(FVT)
$empresa_id=$_SESSION['empresa_id'];

//Instanciamos la clase empresa para obtener la empresa_id
//de la asociacion registrada
$objEmpresa= new Empresa();
$objEmpresa->Find($empresa_id);
if ($objEmpresa->Operacion_Exitosa()){
    $objAfiliacion = new Afiliacion();
    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
    $monto_aso=$objAfiliacion->getAsociacion();
    $monto_fvt=$objAfiliacion->getFVT();
    $monto_sis=$objAfiliacion->getSistemaWeb();

    //Aqui colocamos el ano de afiliacion que cambiara cada ano
    $ano_afiliacion=$objAfiliacion->getAno();
    $Afiliacion_id=$objAfiliacion->get_ID();
}

$empresa_id=0; //Empresa 0 para representar que son todas las
$rsAfiliacion_empresa = Afiliacion::ReadByCiclo($empresa_id, $ano_afiliacion, 1);


//En caso de haber afiliaciones formalizadas se le presenta al usuario para que gestione la tarea de confirmacion   
if ($rsAfiliacion_empresa)
{ 
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <title>Procesar Ranking</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style>
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 180px;
        }
            
    </style>
    
    </head>
    
    <body>
    <div class="container-fluid">
        
            <?php  
                //Menu de usuario
                include_once '../Template/Layout_NavBar_Admin.php';
                echo '<br><hr>';
            ?>
            
            <div class="col-xs-12 " >
                <h3>Procesar Ranking </h3>  
            </div>
        
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabfiltrar" aria-controls="tabfiltrar" role="tab" data-toggle="tab">Filtro</a></li>
                <li role="presentation" ><a href="#tabsubir" aria-controls="tabsubir" role="tab" data-toggle="tab">Subir Arhivo</a></li>
                <li role="presentation" ><a href="#tabprocesar" aria-controls="tabprocesar" role="tab" data-toggle="tab">Procesar</a></li>
    
            </ul>
            <form class="form-signin"  id="register-form" enctype="multipart/form-data">
                <!-- Tab panes -->
                <div class="tab-content ">
             
                    <!--Tab Filtrar --->
                    <div role="tabpanel" class="tab-pane fade in active" id="tabfiltrar">
                    
                        <div id="div_tabfiltrar" class="col-xs-12">
                    
                            <div class="col-xs-12  col-md-4 ">
                                <b>Disciplina</b>

                                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-4"> 

                                 </select>
                            </div>
                           
                            <div class="col-xs-12  col-md-4 ">
                                <b>Categoria</b>

                                 <select id="cmbcategoria" name="cmbcategoria" class="form-control col-md-4"> 

                                 </select>
                            </div>
                            
                           
                            <div class="col-xs-12 col-md-4">
                               
                                <b>Fecha Ranking</b>
                                <input type="date" class="form-control"  name="fecha_rk" id="fecha_rk" value="<?php echo date("Y-m-d")?>">
                                 
                            </div>
                     
                        </div>
                   
                    </div>
                
                    <!--Tab Subir --->
                    <div role="tabpanel" class="tab-pane fade" id="tabsubir">
                       <div id="div_tabsubir" class="col-sx-12 col-md-12 ">
                            <div class="col-xs-12  col-md-4 ">
                                <b>Sexo</b>

                                 <select id="cmbsexo" name="cmbsexo" class="form-control col-md-4"> 

                                 </select>
                            </div>
                    
                            <div class="form-group col-xs-12 col-md-12 ">
                                <label for="frankink">Archivo Ranking:</label>
                                <input type="hidden" class="form-control" name="MAX_FILE_SIZE" value="16000000">
                                <input type="file" class="form-control"  name="franking[]"  >
                                <p class="help-block">Suba un archivo aqui.</p>
                            </div>
                            
                            <div class="form-group col-xs-12 col-md-12">
                                <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">
                                <span class="glyphicon glyphicon-search" ></span> &nbsp; Subir 
                                </button>
                            </div>                           
                            
                        </div>

                    </div>
               
                    <!--Tab procesar --->
                    <div role="tabpanel" class=" tab-pane fade" id="tabprocesar">
                        <div id="div_tabprocesar" class="col-xs-12 col-md-12 ">
                    
                            <div class=" col-sx-12 col-md-6">
                                <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                                <span class="glyphicon glyphicon-search" ></span> &nbsp; Ver Archivos
                                </button>
                            </div>
                            <div class=" col-sx-12 col-md-6">
                                <button type="button" class="btn btn-danger" name="btn-procesar" id="btn-procesar">
                                <span class="glyphicon glyphicon-fast-forward" ></span> &nbsp; Procesar
                                </button>
                            </div>
                        </div>
                    
                    </div>
             
       
                </div>
        </form>         
        <div class="col-xs-12 col-md-12" id="mensaje">

        </div>

        <div class="list col-xs-12 col-md-12" id="list">
           
        </div>

        <div class="col-xs-12 col-md-12" id="results">

        </div>
         
    </div> 
   
<script>

$(document).ready(function() {
  
//    verificar_show();
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('categoria');
    fillCombo('sexo');
      
    function fillCombo(tabla){
        var latabla=tabla;
        $.ajax({
        method: "POST",
        url: "RankingAFI_Datos_Combo.php", 
        data: { tabla:latabla}
        })
        .done(function( data, textStatus, jqXHR ) {
           //Empresa o Estados
            var ecount = Object.keys(data.tabla).length;
            var datalistbox = document.getElementById("cmb"+latabla);
            console.log(ecount);
            console.log(data);
            for(var i=0;i<ecount;i++){
               datalistbox.options[i] = new Option(data.tabla[i].texto,data.tabla[i].value);
            }
        });
     
     }
     
    
    $("#register-form").on('click','#btn-submit', function(e){
        e.preventDefault();
        
        $("#mensaje").html("");
        $("#mensaje").addClass("loader");
        $("#mensaje").removeClass("alert alert-info").removeClass("alert alert-danger");
        var data = new FormData(document.getElementById("register-form"));
        $.ajax({
        url: "RankingAFI_UploadFile.php",
        type: "post",
        data: data,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false
        })
        .done(function(data){
            if (data.Success){
                $("#mensaje").addClass("alert alert-info");
                $("#mensaje").html("Archivo Subido exitosamente: " + data.Mensaje);
             }else{
                $("#mensaje").addClass("alert alert-danger");
                $("#mensaje").html("Error Archivo no fue Subido : " + data.Mensaje);
            }
            $("#mensaje").removeClass("loader");
         });
    });  
   
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target; // newly activated tab
        e.relatedTarget;// previous active tab
        clearmessage();
        var x=$(e.target).text();
        if (x==="Procesar"){
          $('#btn-buscar').click();
        }
          
    });
    
           
   
    //
    $('#btn-buscar').click(function(e){
      
        var fecha_rk = $("#fecha_rk").val();
        var categoria = $("#cmbcategoria").val();
        var sexo = $("#cmbsexo").val();
        var disciplina = $("#cmbdisciplina").val();
        e.preventDefault();
        $('#results').html('');
        if ($("#list").has("alert alert-success")){
            $("#list").removeClass("alert alert-success");
        }
        if ($("#results").has("alert alert-info")){
            $("#results").removeClass("alert alert-info");
        }
        if ($("#results").has("alert alert-warning")){
            $("#results").removeClass("alert alert-warning");
        }
        $('#list').html('');
        $('#list').addClass('loader');
       
        $('#mensaje').html('');
        $('#mensaje').removeClass('alert alert-success');
        
        $.ajax({
        method: "POST",
        url: "RankingAFI_LoadFecha.php", 
        data: { fecha_rk:fecha_rk,categoria:categoria,disciplina:disciplina,sexo:sexo}
        })
        .done(function( data) {
           
            if (data.Success){
                $("#list").html(data.html);
             }else{
                
                $("#mensaje").html(data.html);
            }
          
            $('#list').removeClass('loader');
         });
      });
      
    $('#btn-procesar').click(function(e){
        
        var fecha_rk = $("#fecha_rk").val();
        var sexo = $("#cmbsexo").val();
        var categoria = $("#cmbcategoria").val();
        var disciplina = $("#cmbdisciplina").val();
        //$('#results').html('');
        //$('#list').html('');
        if (Confirmar("Esta Seguro de Procesar el Ranking "+fecha_rk +" Categoria "+categoria +" Disciplina "+disciplina)){

            if ($("#mensaje").has("alert alert-success")){
                $("#mensaje").removeClass("alert alert-success");
            }
            if ($("#mensaje").has("alert alert-danger")){
                $("#mensaje").removeClass("alert alert-danger");
            }
            //$(".list").attr("disabled");
            $('#list').addClass('loader');
            $.ajax({
            method: "POST",
            url: "RankingAFI_Procesar.php", 
            data: { fecha_rk:fecha_rk,categoria:categoria,disciplina:disciplina,sexo:sexo}
            })
            .done(function( data ) {
                if (data.Success){
                    $("#mensaje").addClass("alert alert-success");
                    $("#mensaje").html(data.Mensaje);
                 }else{
                    $("#mensaje").addClass("alert alert-danger");
                    $("#mensaje").html(data.Mensaje);
                }
                $('#list').removeClass('loader');
             });
        }
    });
    
    
    function Confirmar($mensaje) {
        var result=confirm($mensaje);
        
      return result;
    }
    
    //Manipulamos el checkbox de verificacion para actualizar el estatus
    $(".list").on( 'click', '.delete-record',function(e) {
        
        var id =$(this).attr('data-id');
              
        var pro=id.substr(0,3);
        var id_id=id.substr(3);
        if (Confirmar("Esta Seguro de Borrar el Ranking ")){
             e.preventDefault();
            
            var url="RankingAFI_Delete.php";
        
            $.ajax({
            method: "POST",
            url: url, 
            data: { id:id_id}
            })
            .done(function( data ) {
            if (data.Success){
                //$("#mensaje").addClass("alert alert-success");
                $("#mensaje").html(data.Mensaje);
                
                alert("Registro Eliminado :"+data.Mensaje)
             }else{
               // $("#mensaje").addClass("alert alert-danger");
                $("#mensaje").html(data.Mensaje);
                alert("Ocurrio un error ..."+data.Mensaje)
            }
            
            $('#list').html('');
            
            $('#btn-buscar').click();
            });
            
        }   
    });
    
     function clearmessage(){
        
        $('#results').html('');
        $('#list').html('');
        $('#mensaje').html('');
        if ($("#results").has("alert alert-success")){
            $("#results").removeClass("alert alert-success");
        }
        if ($("#results").has("alert alert-info")){
            $("#results").removeClass("alert alert-info");
        }
        if ($("#results").has("alert alert-warning")){
            $("#results").removeClass("alert alert-warning");
        }
            
        if ($("#mensaje").has("alert alert-success")){
            $("#mensaje").removeClass("alert alert-success");
        }
        if ($("#mensaje").has("alert alert-info")){
            $("#mensaje").removeClass("alert alert-info");
        }
        if ($("#mensaje").has("alert alert-warning")){
            $("#mensaje").removeClass("alert alert-warning");
        }
    }
    
     //Buscar los registros del lote de xml exportado para deshacer la exportaciones
    $('.edit-href').click(function(e){
       
        var id =$(this).attr('data-id');
        var data_id=id.substr(1);      
        e.preventDefault();
        $url="FichaEdit.php?"+data_id;
        window.open($url);
     });
    
    
           
});
	
</script>
    
</body>

    
    

</html>
<?php
}
else {
    $error_login=true;
    $mensaje="<p>NO HAY DATOS PARA LA INFORMACION SOLICITADA</p>";
    
    header("Location: ../sesion_usuario_admin.php ");
  
    exit;
   
}



?>


    
