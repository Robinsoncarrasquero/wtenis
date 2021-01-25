
<?php
session_start();
if ($_SESSION['niveluser'] <8) {

    header('Location: ../sesion_inicio.php');
    exit;
}

//$directorio="bsUploadImagenes/uploadimagenes";
//$imagenes=  glob($directorio."*.*");

//$directorio ="../".$_SESSION['url_fotos_torneos']; 

$torneo_id= htmlspecialchars($_GET['tid']);
$folder ="../uploadFotos/torneos/".$torneo_id."/";
    

$imagenes=  glob($folder."*.*");
if (!is_dir($folder)){
    mkdir($folder, 0711);
}


?>
<!DOCTYPE html>
<!-- release v4.4.5, copyright 2014 - 2017 Kartik Visweswaran -->
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <!-- <title>Cargar Imagenes al Portal Krajee JQuery Plugins - &copy; Kartik</title> -->
    <title>Cargar Imagenes Galeria</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrapInputFile/master/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../bootstrapInputFile/master/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../bootstrapInputFile/master/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="../bootstrapInputFile/master/js/fileinput.js" type="text/javascript"></script>
    <script src="../bootstrapInputFile/master/js/locales/fr.js" type="text/javascript"></script>
    <script src="../bootstrapInputFile/master/js/locales/es.js" type="text/javascript"></script>
    <script src="../bootstrapInputFile/master/themes/explorer/theme.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
    
<!-- Content Section -->
<div class="container">
   
        <div class="col-xs-12">
            <h3>Fotos Galeria de Torneos</h3>
              <?php
            //Para generar las miga de pan mediante una clase estatica
            require_once '../clases/Bootstrap2_cls.php';
            echo Bootstrap::breadCrumFotosGaleria();

            ?>
            <div class="pull-right">
<!--                <button class="btn btn-success edit-record"  data-id="0" id="New">Add New</button>-->
            </div>
        </div>
    
</div>
<div class="container kv-main">
    <div class="page-header">
        <h1>Subir Galeria de Imagenes
            <small><a href="#">
                    <i class="glyphicon glyphicon-upload"></i></a></small>
        </h1>
    </div>
    <form id="<?php echo $torneo_id ;?>" enctype="multipart/form-data">
        
        <label>Seleccionar Imagenes</label>
        <input id="file-es" class="file-preview-image" name="imagenes[]" type="file" multiple>
      
        
        <br>
<!--        <button  type="submit" class="btn btn-primary">Recargar</button>-->
        <button type="reset" class="btn btn-default">Resetear</button>
    </form>
   
   
   
    <br>
</div>

</body>
<script>
    var forder_id=$("form").attr("id");
    $('#file-es').fileinput({
       
        language: 'es',
        uploadUrl: 'upload.php',
        uploadExtraData: {forder_id: forder_id},
       
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFileSize: 2000,
        maxFilesNum: 8,
   
        initialPreview:
                [<?php foreach ($imagenes as $image){
                    
                    echo "'$image',";
                    
                }
                ?>
        ],

        
        initialPreviewConfig:[
            <?php 
                $i=0;
                
                $dir="/".$torneo_id."/";
                foreach ($imagenes as $image2){
                    $infoImagenes= explode($dir, $image2);
                    $indkey = count($infoImagenes,1) -1 ; //El ultimo elemento es el key[Nombre del file]
                    $key=$folder.$infoImagenes[$indkey];
                   
                    $i++;
//                    echo $image2;
//                    echo "</br>";
                    list($width, $height, $type, $attr) = getimagesize($image2);
                    $size= filesize($image2);
                    $url = 'borrar.php';
                   
                    if ($i<=count($imagenes)){
                        $linea='{caption: "'.$key.'", filetype:"'.$type.'", size:"'.$size. '", height:"'.$height.'", width:"'.$width.'", url:"'.$url.'", key:"'.$key.'"},';
                    }else{
                        $linea='{caption: "'.$key.'", filetype:"'.$type.'", size:"'.$size. '", height:"'.$height.'", width:"'.$width.'", url:"borrar.php", key:"'.$key.'"}';
                    }
                    echo $linea;
            
                } 
            ?>
        ]
        
    });
   
    
    
    
</script>
</html>