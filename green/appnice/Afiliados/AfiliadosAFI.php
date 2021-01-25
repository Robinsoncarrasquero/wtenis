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
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}


$por_post = ($_SERVER['REQUEST_METHOD'] == 'POST');

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
    <title>Afiliados Activos</title>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style >
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
        
            
            <div >
                <h3>Afiliados Activos</h3>  
            
            </div>
            
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabfiltrar" aria-controls="tabfiltrar" role="tab" data-toggle="tab">Filtro</a></li>
<!--                <li role="presentation" ><a href="#tabbuscar" aria-controls="tabbuscar" role="tab" data-toggle="tab">Buscar Datos</a></li>-->
             </ul>

            <!-- Tab panes -->
            <div class="tab-content ">
                
                <!--Tab Home --->
                <div role="tabpanel" class="tab-pane fade in active" id="tabfiltrar">
                    
                        <div id="div_tabfiltrar" class="col-md-12">
                           <div class="col-md-2 ">
                                <b>Afiliacion</b>
                                <select id="cmbafiliacion" name="cmbafiliacion" class="form-control col-md-6"> 

                                </select>
                           </div>
                            
                             <div class="col-md-2 ">
                                <b>Disciplina</b>

                                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-6"> 

                                 </select>
                            </div>
                           
                           
                            <div class=" col-md-2">
                                <b>Categoria</b>

                                 <select id="cmbcategoria" name="cmbcategoria" class="form-control col-md-6"> 

                                 </select>
                            </div>
                            <div class="col-md-2 ">
                                <b>Apellidos</b>

                                 <input id="txtapellidos" name="txtapellidos" class="form-control col-md-6"> 

                                 
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                                <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                                </button>
                            </div> 
                    
                    </div>
                
            </div>
        
     
       
            <div class="col-md-12" id="mensaje">

            </div>

            <div class="list col-md-12 " id="list">

            </div>

            <div class="col-md-12 " id="results">

            </div>

            <div class="col-md-12 text text-center" id="paginacion">

            </div>
        </div>
    
    </div>
        
   
<script>

$(document).ready(function() {
  
//    verificar_show();
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('afiliacion');
    fillCombo('categoria');
      
    function fillCombo(tabla){
        var latabla=tabla;
        $.ajax({
        method: "POST",
        url: "AfiliadosAFI_Datos_Combo.php", 
        data: { tabla:latabla}
        })
        .done(function( data) {
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
     
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          e.target; // newly activated tab
          e.relatedTarget;// previous active tab
         
          xmessage();
    });
        
         
    
  // Manejamos la busqueda del combo 
  // y cargamos la lista
  
    $('#btn-buscar').click(function(e){
        var id = $("#cmbafiliacion").val();
        var categoria = $("#cmbcategoria").val();
        var disciplina = $("#cmbdisciplina").val();
        var apellidos = $("#txtapellidos").val();
        if (apellidos!==''){
            url="AfiliadosAFI_Lista_Apellidos.php";
            
        }else{
            url="AfiliadosAFI_LoadLista.php";
        }
        e.preventDefault();
        
        xmessage();
        $("#paginacion").html('');
        $('#results').html('');
        $('#mensaje').html('');
        $('#list').html('');
        $('#list').addClass('loader');
        $.ajax({
        method: "POST",
        url: url, 
        data: { id:id,categoria:categoria,disciplina:disciplina,apellidos:apellidos,pagina:0}
        })
        .done(function( data) {
            
            if (data.Success){
                $('#list').removeClass('loader');
                $("#list").html(data.html);
                $("#paginacion").html(data.pagination);
             }else{
                $('#list').removeClass('loader');
                $('#list').html('');
                $("#mensaje").addClass("alert alert-warning");
                $("#mensaje").html(data.html);
                $("#paginacion").html('');
            }
           
        });
    });
    //Paginando Ranking
    $(document).on('click','.page-link',function(e)  {
        var id = $("#cmbafiliacion").val();
        var categoria = $("#cmbcategoria").val();
        var disciplina = $("#cmbdisciplina").val();
        var apellidos = $("#txtapellidos").val();
        if (apellidos!==''){
            url="AfiliadosAFI_Lista_Apellidos.php";
            
        }else{
            url="AfiliadosAFI_LoadLista.php";
        }
        
        e.preventDefault();
        
        $('#list').html('');
        $('#paginacion').html('');
        $('#results').html('');
        
        var page = $(this).attr('data-id');
        
        $.ajax({
        method: "POST",
        url: url, 
        data: { id:id,categoria:categoria,disciplina:disciplina,apellidos:apellidos,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#list').html(data.html);
           $('#paginacion').html(data.pagination);
          // console.log(data.pagination);
        });
                  
    });
    
    function Confirmar($mensaje) {
        var result=confirm($mensaje);
        
      return result;
    }
   
    
    //Manipulamos el checkbox de verificacion para actualizar el estatus
    $(".list").on( 'click', '.edit-record',function(e) {
      
        var id =$(this).attr('data-id');
        var chkOK=$(this).is(':checked');
        var op=id.substr(0,3);
        var id_id=id.substr(3);
       
        var url="AfiliadosAFI_Update.php";
        {
            $.ajax({
            method: "POST",
            url: url, 
            data: { id:id_id, chkOK: chkOK, proceso:op}
            })
            .done(function( data, textStatus, jqXHR ) {
       
                
            })
            .fail(function( xhr, status, errorThrown ) {
                alert( "Sorry, there was a problem!" );
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
                console.dir( xhr );
            });
        }   
    });
    
    
    function xmessage(){
        
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


    
