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
    <title>Exportacion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-with,initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <style >
        .loader{
            background-image: url("../images/ajax-loader.gif");
            background-repeat: no-repeat;
            background-position: center;
            height: 80px;
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
                <h3>Exportacion de Datos</h3>  
            </div>
        
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabverificar" aria-controls="tabverificar" role="tab" data-toggle="tab">Verificar</a></li>
                <li role="presentation" ><a href="#tabexportar" aria-controls="tabexportar" role="tab" data-toggle="tab">Exportar XML</a></li>
               <li role="presentation" ><a href="#tabdesexportar" aria-controls="tabdesexportar" role="tab" data-toggle="tab">Reversar Exportados</a></li>
             </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                
                <!--Tab Home --->
                <div role="tabpanel" class="tab-pane fade in active" id="tabverificar">
                    
                        <div id="div_verificar" class=" col-sx-12 col-md-12">
                            
                           <div  class="col-sx-12 col-md-6 ">
                                <select id="cmbafiliacion" name="cmbafiliacion" class="form-control col-md-6"> 

                                </select>
                           </div>
                            
                            <div class="col-sx-12 col-md-6">
                            
                                <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                                <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                                </button>
                            
                            </div>
                        </div> 
                    
                </div>
                
                 <!--Tab profile --->
                <div role="tabpanel" class="tab-pane fade" id="tabexportar">
                        <div id="div_exportar" class="col-sx-12 col-md-12">
               
                            <div class="col-sx-12 col-md-12">
                                <button type="button" class="btn btn-success" name="btn-xml" id="btn-xml-buscar">
                                 <span class="glyphicon glyphicon-file" ></span> &nbsp; Buscar
                                </button>
                           
                                <a class="btn btn-primary" href="ExportacionXML_Download_File.php?chkExportar=OK" role="button">Descargar</a>
                            
                                <button type="button" class="btn btn-warning" name="btn-xml-marcar" id="btn-xml-marcar">
                                 <span class="glyphicon glyphicon-file" ></span> &nbsp; Procesar
                                </button>
                            </div>
                                                      
                            
                        </div>


                </div> 

                <!--Tab profile --->
                <div role="tabpanel" class="tab-pane fade" id="tabdesexportar">
                    
                    <div id="div_desexportar" class="col-sx-12 ">
                            
                        <div  class="col-sx-12 col-md-6 ">
                          <select id="cmbfilexml" name="cmbfilexml" class="form-control">

                          </select>
                        </div>
                           
                        <div class=" col-sx-12 col-md-6">
                            <button type="button" class="btn btn-warning" name="btn-buscar-exp" id="btn-buscar-exp">
                            <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                            </button>
                        </div>
                    </div>

                </div> 
        </div>
         
        <div class="col-sx-12 col-md-12" id="mensaje">

        </div>

        <div class="list col-sx-12 col-md-12" id="list">

        </div>

        <div class="col-sx-12 col-md-12" id="results">

        </div>
         
    </div>
   
<script>

$(document).ready(function() {
  
//    verificar_show();
    fillCombo();
      
    function fillCombo()
    {
        $.ajax({
        method: "POST",
        url: "ExportacionXML_Datos_Combo.php", 
        data: { op:"sweb"}
        })
        .done(function( data, textStatus, jqXHR ) {
           //Empresa o Estados
            var ecount = Object.keys(data.Empresa).length;
            var empresa = document.getElementById("cmbafiliacion");
           
            for(var i=0;i<ecount;i++){
               empresa.options[i] = new Option(data.Empresa[i].estado,data.Empresa[i].id);
            }
            
            //Filexml
            var ecount = Object.keys(data.XML).length;
            var cmbfilename = document.getElementById("cmbfilexml");
//            console.log(ecount);
//            console.log(data.XML);
            for(var i=0;i<ecount;i++){
                cmbfilename.options[i] = new Option(data.XML[i].texto[0],data.XML[i].texto[0]);
            }
            
        });
     
     }
     
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          e.target; // newly activated tab
          e.relatedTarget;// previous active tab
          
          fillCombo();
          message();
    });
        
         
    function message(){
        
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
  // Manejamos la busqueda del combo 
  // y cargamos la lista
  
    $('#btn-buscar').click(function(e){
        var id = $("#cmbafiliacion").val();
      
        var chkFiltro=0;
        if ($('#chkEnviar').is(':checked')){
            chkFiltro=1;
        }else{
            chkFiltro=0;
        }
        e.preventDefault();
        
        $('#results').html('');
            
        if ($("#results").has("alert alert-success")){
            $("#results").removeClass("alert alert-success");
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
        
        $.ajax({
        method: "POST",
        url: "ExportacionXML_LoadLista.php", 
        data: { id:id,chkFiltro:chkFiltro,op:"sweb"}
        })
        .done(function( data, textStatus, jqXHR ) {
            if (data.Sucess){
                $('#list').removeClass('loader');
                $("#mensaje").addClass("alert alert-success");
                $("#mensaje").html("<b>Datos para verificar para la exportacion</b>");
                $("#list").html(data.html);
             }else{
                $('#list').html('');
                $('#list').removeClass('loader');
                $("#mensaje").addClass("alert alert-info");
                $("#mensaje").html("No hay Registros pendientes para Verificar...");
               
            }
           
        });
      });
    
    function Confirmar($mensaje) {
        var result=confirm($mensaje);
        
      return result;
    }
    
    //Generar xml
    $('#btn-xml-buscar,#btn-xml-marcar').click(function(e){
       
        var chkExportar=0;
        
        switch ($(this).attr('id')){
                
            case 'btn-xml-marcar':
                if (Confirmar("Esta Seguro de Marcar los Registros como Exportados??")){
                    chkExportar=1;
                }
                break;
            case 'btn-xml-buscar':
                 chkExportar=0;
        }   
         e.preventDefault();
        $('#list').html('');
        $('#list').addClass('loader'); 
        $('#results').html('');
        $('#mensaje').html('');
         
        if ($("#mensaje").has("alert alert-success")){
            $("#mensaje").removeClass("alert alert-success");
        }
        $.ajax({
        method: "POST",
        url: "ExportacionXML_Procesar.php", 
        data: { chkExportar:chkExportar}
        })
        .done(function( data, textStatus, jqXHR ) {
//            if ( console && console.log ) {
//                console.log( "La solicitud se ha completado correctamente." );
//            }
            if (data.Sucess){
              
                $('#list').removeClass('loader');
                if ( $("#mensaje").has("alert alert-warning")){
                    $("#mensaje").removeClass("alert alert-warning");
                }
                $("#mensaje").addClass("alert alert-info");
                $("#mensaje").html("<b>Descargue el archivo XML antes de Exportar... </b>");
                $("#list").html(data.html);
                       
            }else{
                
                $('#list').html('');
                $('#list').removeClass('loader');
                if ( $("#results").has(".alert alert-info")){
                    $("#results").removeClass("alert alert-info");
                }
                $("#results").addClass("alert alert-warning");
                $("#results").html("Parece que no hay datos Verificados para Exportar...."+data.html);
               
            }
//            if ( console && console.log ) {
//                console.log( "La solicitud se ha completado correctamente." );
//            }
        });
        
    });
    
    
     //Buscar los registros del lote de xml exportado para deshacer la exportaciones
    $('#btn-buscar-exp').click(function(e){
        var id = $("#cmbfilexml").val();
                
        e.preventDefault();
        
        $('#list').html('');
        $('#list').addClass('loader'); 
        $('#results').html('');
        $('#reservada').html('');
         
        if ($("#reservada").has("alert alert-success")){
            $("#reservada").removeClass("alert alert-success");
        }
        $.ajax({
        method: "POST",
        url: "ExportacionXML_Exportados.php", 
        data: { id:id}
        })
        .done(function( data, textStatus, jqXHR ) {
//            if ( console && console.log ) {
//                console.log( "La solicitud se ha completado correctamente." );
//            }
            if (data.Sucess){
               
                $('#list').removeClass('loader');
                if ( $("#mensaje").has("alert alert-warning")){
                    $("#mensaje").removeClass("alert alert-warning");
                }
                $("#mensaje").addClass("alert alert-info");
                $("#mensaje").html("Registros que han sido Exportados");
                $("#list").html(data.html);
               
                       
            }else{
                
                $('#list').html('');
                $('#list').removeClass('loader');
                if ( $("#mensaje").has(".alert alert-info")){
                    $("#mensaje").removeClass("alert alert-info");
                }
                $("#mensaje").addClass("alert alert-warning");
                $("#mensaje").html("No hay registros Exportados en este LOTE");
                
            }
//            if ( console && console.log ) {
//                console.log( "La solicitud se ha completado correctamente." );
//            }
        });
    });
    
    
    //Manipulamos el checkbox de verificacion para actualizar el estatus
    $(".list").on( 'click', '.edit-record',function(e) {
      
        var id =$(this).attr('data-id');
      
        if( $(this).is(':checked') ) {
            chkOK=1;
        } else {
            chkOK=0;
        }
        var op=id.substr(0,3);
       
        switch(op) {
          case 'opv':
            pro='Verificado';
            break;
          case 'ope':
            pro='Exportado';
            break;
          default:
            pro='';
        }
        var id_id=id.substr(3);
       
        var url="ExportacionXML_Update.php";
        {
            $.ajax({
            method: "POST",
            url: url, 
            data: { id:id_id, chkOK: chkOK, proceso:pro}
            })
            .done(function( data, textStatus, jqXHR ) {
               
                //console.log(data.Mensaje);
               
            })
            .fail(function( xhr, status, errorThrown ) {
                alert( "Sorry, there was a problem!" );
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
                console.dir( xhr );
            });
        }   
    });
    
    
     //Buscar los registros del lote de xml exportado para deshacer la exportaciones
    $('.edit-href').click(function(e){
        alert();
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


    
