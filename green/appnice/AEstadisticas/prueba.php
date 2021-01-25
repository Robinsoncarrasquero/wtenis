<?php
session_start();
require_once '../clases/Empresa_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../sql/ConexionPDO.php';

if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<10){
    header('Location: ../sesion_inicio.php');
    exit;
}

if (isset($_SESSION['empresa_id']) && $_SESSION['empresa_id']==NULL){
    header('Location: ../sesion_inicio.php');
    exit;
}
/*Tomamos la empresa actual que es la Principal Jerarquica(FVT)*/
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


?>
<html>
  <head>
  
    <title>Estadistica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    
    <style>
    table{
        border-color:red !important;
        height:10px;
        font-family:sans-serif;
        font-size: 8px;
        margin-left: 5px;
    }
    body{
        margin: 0;

    }
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
                if(isset($_SESSION['niveluser'])){
                   if($_SESSION['niveluser']>10){
                       include_once '../Template/Layout_NavBar_Admin.php';
                   }else{
                       include_once '../Template/Layout_NavBar_Directivos.php';
                   }
               }else{
                   
               }
                
                echo '<br><hr>';
            ?>
             <h1> Afiliaciones en Transito</h1>
                      
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active"><a href="#tabfiltro" aria-controls="tabfiltro" role="tab" data-toggle="tab">Filtro</a></li>
                <li role="presentation" ><a href="#tabestado" aria-controls="tabestado" role="tab" data-toggle="tab">Estados</a></li>
                <li role="presentation" ><a href="#tabregion" aria-controls="tabregion" role="tab" data-toggle="tab">Regiones</a></li>
                <li role="presentation" ><a href="#tabcategoria" aria-controls="tabcategoria" role="tab" data-toggle="tab">Categorias</a></li>
                <li role="presentation" ><a href="#tabpais" aria-controls="tabpais" role="tab" data-toggle="tab">Paises</a></li>
    
            </ul>
            <form class="form-signin"  id="register-form" >
                <!-- Tab panes -->
                <div class="tab-content">
             
                    <!--Tab Filtrar --->
                    <div role="tabpanel" class="tab-pane fade in active" id="tabfiltro">
                    
                        <div id="div_tabfiltro" class="col-xs-12 col-md-12">
                    
                            <div class="col-xs-12  col-md-4 ">
                                <b>Disciplina</b>

                                 <select id="cmbdisciplina" name="cmbdisciplina" class="form-control col-md-4"> 

                                 </select>
                            </div>
                           
                            <div class="col-xs-12  col-md-4 ">
                                <b>Ano</b>

                                 <select id="cmbano" name="cmbano" class="form-control col-md-4"> 

                                 </select>
                            </div>
                            
                                                 
                        </div>
                   
                    </div>
                
                                   
                    <!--Tab Estado --->
                    <div role="tabpanel" class=" tab-pane fade" id="tabestado">
                        <div id="div_tabestado" class="col-xs-12 col-md-12 ">
                            
                            
                        </div>
                    
                    </div>
                    
                    <!--Tab Regiones --->
                    <div role="tabpanel" class=" tab-pane fade" id="tabregion">
                        <div id="div_tabestado" class="col-xs-12 col-md-12 ">
                    
                            
                        </div>
                    
                    </div>
                    
                    <!--Tab Categoria --->
                    <div role="tabpanel" class=" tab-pane fade" id="tabcategoria">
                        <div id="div_tabcategoria" class="col-xs-12 col-md-12 ">
                    
                            
                        </div>
                    
                    </div>
                    
                    <!--Tab Pais--->
                    <div role="tabpanel" class=" tab-pane fade" id="tabpais">
                        <div id="div_tabpais" class="col-xs-12 col-md-12 ">
                    
                            
                        </div>
                    
                    </div>
             
             
       
                </div>
        </form> 
            
        <!--Div that will hold the pie chart-->
        <div class="col-xs-12" >
            <div class="col-xs-12 col-md-10 "  id="chart_div"></div>
            <div class="col-xs-12 col-md-2" id="tabla"></div> 
        </div>
      
        <div class="col-xs-12 col-md-12" id="mensaje">

        </div>

        
    </div> 
    <script type="text/javascript" src="google/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      //google.charts.setOnLoadCallback(drawChartx);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChartx(strDataRow) {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Estado');
        data.addColumn('number', 'Afiliados');
        //data.addRows(strDataRow);
        data.addRows([
          ['Miranda', 399],
          ['Carabobo', 290],
          ['DC', 99],
          ['Lara', 220],
          ['Aragua', 120]
        ]);
        
        // Set chart options
        var options = {'title':'Afiliados  Por Estado',
            'is3D':true,
            'vAxis': {'title': 'Estados'},
            'width':900,
            'height':550,
             colors: ['#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
             };
          
                      
                            
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        
        
      }
    </script>   
<script>

$(document).ready(function() {
  
    //Cargamos las tablas en en list box
    fillCombo('disciplina');
    fillCombo('ano');
      
    function fillCombo(tabla){
        var latabla=tabla;
        $.ajax({
        method: "POST",
        url: "Data_Combo_List.php", 
        data: { tabla:latabla}
        })
        .done(function( data, textStatus, jqXHR ) {
           //Empresa o Estados
            var ecount = Object.keys(data.tabla).length;
            var datalistbox = document.getElementById("cmb"+latabla);           
            for(var i=0;i<ecount;i++){
               datalistbox.options[i] = new Option(data.tabla[i].texto,data.tabla[i].value);
            }
        });
     
     }
     
          
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target; // newly activated tab
        e.relatedTarget;// previous active tab
        clearmessage();
        
        var x=$(e.target).text();
        $('#mensaje').addClass('loader');

        $('#chart_div').html('');
        $('#tabla').html('');
        
        if (x==="Estados"){
          GenGoogleChartBar("edo");
        }
        if (x==="Regiones"){
          GenGoogleChartBar('reg');
        }
        if (x==="Categorias"){
          GenGoogleChartBar('cat');
        }
        if (x==="Paises"){
          GenGoogleChartBar('pai');
        }
        $('#mensaje').removeClass('loader');

          
    });
    
    
    function GenGoogleChartBar(opt)
    {
        var ano = $("#cmbano").val();
        var disciplina = $("#cmbdisciplina").val();
        $('#results').html('');
        $('#list').html('');
        //if (Confirmar("Esta Seguro de Procesar "+ ano + " Disciplina "+disciplina))
        {
            $.ajax({
            method: "POST",
            url: "Procesar.php", 
            data: { ano:ano,disciplina:disciplina,opt:opt,glbempresa:'glb',proceso:'tra'}
            })
            .done(function( jsdata ) {
                // Create the data table.
                var data = new google.visualization.DataTable();
                addColumn(data, 'string',"DATA");
                addColumn(data, 'number',"INFO");
                
                
                var ecount = Object.keys(jsdata.DataInfo).length;
                data.addRows(ecount);
                
                var strDataRow ="[";
                var total=0;
                var table="<div id='mi-tabla'><table class='table table-responsive table-condensed table-stripped table-bordered'><thead><th>Data</th><th>##</th></thead>";
                for(var i=0;i<ecount;i++){
                    table +="<tr><td>"+jsdata.DataInfo[i].lestado+"</td><td>"+jsdata.DataInfo[i].total+"</td></tr>";
                    total += parseInt(jsdata.DataInfo[i].total);
                    //data.addRow([jsdata.Estados[i].estado,jsdata.Estados[i].total]);
                    // row = {estado:jsdata.Estados[i].estado, afiliados:jsdata.Estados[i].total};
                    // data.addRow(row.estado,row.afiliados);
                    data.setCell(i, 0, jsdata.DataInfo[i].lestado);
                    data.setCell(i, 1,jsdata.DataInfo[i].total);
                }
                document.getElementById("tabla").innerHTML =table+"<tr><td>TOTAL</td><td>"+total+"</td></tr></table></div>";
                strDataRow +="]";
                

                if (opt==="edo")
                {
                    // Set chart options
                    var mcolors=['#669900','#800080','#000080','#0000ff'];
                    var options =SetChartOptions("Afiliaciones",'ESTADOS', '#669900',mcolors);
                
                }
                if (opt==="reg")
                {
                    // Set chart options
                    var mcolors=['#FF9900','#0000ff','#800080','#0000ff'];
                    var options =SetChartOptions("Afiliaciones",'REGIONES', '#FF9900',mcolors);
                }
                
                if (opt==="cat")
                {
                    // Set chart options
                    var mcolors=['#6600FF','#800080','#0000ff','#FF9900'];
                    var options =SetChartOptions("Afiliaciones",'CATEGORIAS', '#6600FF',mcolors);
                }
                
                if (opt==="pai")
                {
                    // Set chart options
                    var mcolors=['#800080','#0000ff','#800080','#0000ff'];
                    var options =SetChartOptions("Afiliaciones",'PAISES', '#FF9900',mcolors);
                }
                //$('#mensaje').RemoveClass('loader');

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);
                
            });
             
                 
        }
    }
    
    
    
    function addColumn(data,strTipo,strColumna){
        {
            data.addColumn(strTipo, strColumna);
            
        }
    
    }

    function SetChartOptions(titleHead,axisTitle,color,colors){
        
                {
                    // Set chart options
                    var options = {'title':titleHead,
                        'is3D':true,
                        'vAxis': {'title': axisTitle,titleTextStyle: {color: color}},
                        'width':600,
                        'height':400,
                        colors: [colors[1],colors[2],colors[3],colors[4]]
                    };
                }
                return options;
    }
    
    function Confirmar(mensaje) {
        var result=confirm(mensaje);
        return result;
    }
    
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