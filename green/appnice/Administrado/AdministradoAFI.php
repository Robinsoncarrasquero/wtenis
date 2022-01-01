<?PHP

session_start();
require_once '../funciones/funcion_monto.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Helper_cls.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<"9"){
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

//$empresa_id=0; //Empresa 0 para representar que son todas las
$rsAfiliacion_empresa = Afiliacion::ReadByCiclo($empresa_id, $ano_afiliacion, 1);


//En caso de haber afiliaciones formalizadas se le presenta al usuario para que gestione la tarea de confirmacion   
if ($rsAfiliacion_empresa)
{ 
    
    ?>
    <!DOCTYPE HTML>
    <html lang="es">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php Helper::get_stylesheet();?>

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
             <div>
                <h3>Afiliaciones Administradas  </h3>  
            </div>
        
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabfiltrar" aria-controls="tabfiltrar" role="tab" data-toggle="tab">Filtro</a></li>
<!--                <li role="presentation" ><a href="#tabbuscar" aria-controls="tabbuscar" role="tab" data-toggle="tab">Buscar Datos</a></li>-->
<!--                <li role="presentation" ><a href="#tabmafiliamasiva" aria-controls="tabmafiliamasiva" role="tab" data-toggle="tab">Afilia Masiva</a></li>
    -->
            </ul>

            <!-- Tab panes -->
            <div class=" row tab-content ">
                
                <!--Tab Home --->
                <div role="tabpanel" class="tab-pane fade in active" id="tabfiltrar">
                    
                        <div id="div_tabfiltrar" class="col-md-12">
                           <div class="col-md-2 ">
                                <b>Asociacion</b>
                                <select id="cmbempresa" name="cmbempresa" class="form-control col-md-4"> 

                                </select>
                           </div>
                            
                             <div class=" col-md-2 ">
                                <b>Disciplina</b>

                                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-4"> 

                                 </select>
                            </div>
                           
                            <div class="  col-md-2">
                                <b>Categoria</b>

                                 <select id="cmbcategoria" name="cmbcategoria" class="form-control col-md-4"> 

                                 </select>
                            </div>
                            
                        
                            <div class="col-md-12 ">
                            <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                            <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                            </button>
                            
                                                      
                            </div>
                        </div>

                </div>
                
                 <!--Tab buscar --->
<!--                <div role="tabpanel" class="tab-pane fade" id="tabbuscar">
                        <div id="div_tabbuscar" class="col-sx-12 col-md-12 ">
               
                            <div class=" col-sx-12 col-md-12">
                            <button type="button" class="btn btn-primary" name="btn-buscar" id="btn-buscar">
                            <span class="glyphicon glyphicon-search" ></span> &nbsp; Buscar
                            </button>
                            
                                                      
                            </div>
                        </div>


                </div> -->
                 
                 
                              
                                
        </div>
       
     
       
        <div class="col-md-12 " id="mensaje">

        </div>

        <div class="list col-md-12 " id="list">

        </div>

        <div class="col-md-12"  id="results">

        </div>
         <div class="col-md-12 text text-center" id="paginacion">

        </div>
         
    </div>
   
<script>

$(document).ready(function() {
  
//    verificar_show();
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('empresa');
    fillCombo('categoria');
      
    function fillCombo(tabla){
        
        
        var latabla=tabla;
        $.ajax({
        method: "POST",
        url: "AdministradoAFI_Datos_Combo.php", 
        data: { tabla:latabla}
        })
        .done(function( data, textStatus, jqXHR ) {
           //Empresa o Estados
            var ecount = Object.keys(data.tabla).length;
            var datalistbox = document.getElementById("cmb"+latabla);
//            console.log(ecount);
//            console.log(data);
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
        
         
    function xmessage(){
        
        $('#list').html('');
        $('#mensaje').html('');
            
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
        var id = $("#cmbempresa").val();
       
        var categoria = $("#cmbcategoria").val();
        
        var disciplina = $("#cmbdisciplina").val();
       
        
        e.preventDefault();
        
           
        if ($("#mensaje").has("alert alert-success")){
            $("#mensaje").removeClass("alert alert-success");
        }
        if ($("#mensaje").has("alert alert-info")){
            $("#mensaje").removeClass("alert alert-info");
        }
        if ($("#mensaje").has("alert alert-warning")){
            $("#mensaje").removeClass("alert alert-warning");
        }
        
        $('#list').html('');
        $('#list').addClass('loader');
        $('#paginacion').html('');
        $('#mensaje').html('');
        
        $.ajax({
        method: "POST",
        url: "AdministradoAFI_LoadLista.php", 
        data: { id:id,categoria:categoria,disciplina:disciplina,pagina:0}
        })
        .done(function( data ) {
           
            if (data.Success){
                $('#list').removeClass('loader');
                $("#list").html(data.html);
                $('#paginacion').html(data.pagination);
             }else{
                $('#list').html('');
                $('#list').removeClass('loader');
                $("#mensaje").addClass("alert alert-warning");
                $("#mensaje").html(data.html);
            }
           
        });
      });
    
    function Confirmar($mensaje) {
        var result=confirm($mensaje);
        
      return result;
    }
   
    
    //Manipulamos el checkbox de verificacion para actualizar el estatus
    $(".list").on( 'click', '.edit-record',function(e) {
        var id =$(this).attr('data-id');
        if( $(this).is(':checked') ) {
           chkOK=1;
        } else {
           chkOK=0;
        }
        var pro=id.substr(0,3);
        
        var id_id=id.substr(3);
        
        var url="AdministradoAFI_Update.php";
       
        {
            $.ajax({
            method: "POST",
            url: url, 
            data: { id:id_id, chkOK: chkOK, proceso:pro}
            })
            .done(function( data ) {
                if (data.Success){
                    alert(data.Mensaje);
                }else{
                   alert("Error "+data.Mensaje);
                }
               
            
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
     
     //Paginando Ranking
    $(document).on('click','.page-link',function(e)  {
        var id = $("#cmbempresa").val();
       
        var categoria = $("#cmbcategoria").val();
        
        var disciplina = $("#cmbdisciplina").val();
       
        var page = $(this).attr('data-id');
       
        $('#list').html('');
        $('#results').html('');
        $('#paginacion').html('');
        $.ajax({
            method: "POST",
            url: "AdministradoAFI_LoadLista.php", 
            data: { id:id,categoria:categoria,disciplina:disciplina,pagina:page}
        })
        .done(function( data) {
          // $('#mensaje').removeClass('loader');
           $('#list').html(data.html);
           $('#paginacion').html(data.pagination);
          // console.log(data.pagination);
        });
                  
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


    
