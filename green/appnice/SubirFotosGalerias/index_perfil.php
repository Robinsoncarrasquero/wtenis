
<?php
session_start();
//if ($_SESSION['niveluser'] <8) {
//
//    header('Location: ../sesion_inicio.php');
//    exit;
//}

//$directorio="bsUploadImagenes/uploadimagenes";
//$imagenes=  glob($directorio."*.*");

$directorio ="../".$_SESSION['url_foto_perfil']; 
$directorio ="../uploadFotos/perfil/";
$filenamePerfil="ft28472989.jpg";
$filenameDefault="ftdefault.jpg";

if (file_exists($directorio.$filenamePerfil)){
    
    $imagenes=  glob($directorio.$filenamePerfil);
}else{
    $imagenes=  glob($directorio.$filenameDefault);
    
}

//var_dump($directorio.$filenamePerfil);
//  echo "</br>";
//    foreach ($imagenes as $image){
//                    echo $image;
//                    echo "</br>";
////                    echo filesize($image);
////                    echo "</br>";
//                     $infoImagenes= explode("/", $image);
//                     $indice_key= count($infoImagenes,1) ; //El ultimo elemento es el key[Nombre del file]
//                     echo $indice_key;
//                     echo "</br>";
//                     for ($i=0;$i<$indice_key;$i++){
////                         echo "</br>";
////                         echo $infoImagenes[$i];
//                         
//                         
//                     }
//                     
//                   
//    }
?>
<!DOCTYPE html>
<!-- release v4.4.5, copyright 2014 - 2017 Kartik Visweswaran -->
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Krajee JQuery Plugins - &copy; Kartik</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrapInputFile/master/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../bootstrapInputFile/master/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../../bootstrapInputFile/master/js/plugins/sortable.js" type="text/javascript"></script>
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
            <h3>Panel de Fotos Portal</h3>
              <?php
            //Para generar las miga de pan mediante una clase estatica
            require_once '../clases/Bootstrap2_cls.php';
            echo Bootstrap::breadCrumFotosPortal();

            ?>
            <div class="pull-right">
<!--                <button class="btn btn-success edit-record"  data-id="0" id="New">Add New</button>-->
            </div>
        </div>
    
</div>
<div class="container kv-main">
    <div class="page-header">
        <h1>Subir Imagenes de Perfil
            <small><a href="#">
                    <i class="glyphicon glyphicon-upload"></i></a></small>
        </h1>
    </div>
    <form enctype="multipart/form-data">
        
        <label>Subir Imagenes</label>
        <input id="file-perfil" class="file-preview-image" name="imagenes[]" type="file" >
        
        <br>
        <button type="submit" class="btn btn-primary">Recargar</button>
        <button type="reset" class="btn btn-default">Resetear</button>
    </form>
   
   
   
    <br>
</div>

</body>
<script>
    
    $('#file-perfil').fileinput({
        showUpload: true,
        showCaption: false,
        language: 'es',
        uploadUrl: 'upload_perfil.php',
        uploadExtraData: {kvId:" <?php echo $filenamePerfil ?>"},
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFileSize: 2000,
        maxFilesNum: 2,
//        initialPreview: [
//            "http://lorempixel.com/1920/1080/transport/1",
//            "http://lorempixel.com/1920/1080/transport/2",
//            "http://lorempixel.com/1920/1080/transport/3"
//        ],
       
        initialPreview:[<?php foreach ($imagenes as $image){
                    
                    echo "'$image'";
                    
                }
                ?>
        ],
       
        
        

        
        initialPreviewConfig:[
            <?php 
                $i=0;
                foreach ($imagenes as $image2){
                    $infoImagenes= explode("/", $image2);
                    $indkey = count($infoImagenes,1) -1 ; //El ultimo elemento es el key[Nombre del file]
                    $key = $infoImagenes[$indkey];
                    $key = $filenamePerfil;
                    
                    $i++;
//                    echo $image2;
//                    echo "</br>";
                    list($width, $height, $type, $attr) = getimagesize($image2);
                    $size= filesize($image2);
                    $url = 'borrar_perfil.php';
                   
                    if ($i<=count($imagenes)){
                        $linea='{caption: "'.$key.'", filetype:"'.$type.'", size:"'.$size. '", height:"'.$height.'", width:"'.$width.'", url:"'.$url.'", key:"'.$key.'"},';
                    }else{
                        $linea='{caption: "'.$key.'", filetype:"'.$type.'", size:"'.$size. '", height:"'.$height.'", width:"'.$width.'", url:"'.$url.'", key:"'.$key.'"}';
           

                    }
                    echo $linea;
            
                } 
            ?>
        ]
        
    });
   
    $("#file-2").fileinput({
        uploadUrl: 'upload.php', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 10,
        //allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
    
    /*$(".file").on('fileselect', function(event, n, l) {
     alert('File Selected. Name: ' + l + ', Num: ' + n);
     });*/
     
    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-primary btn-lg",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: [
            "http://lorempixel.com/1920/1080/transport/1",
            "http://lorempixel.com/1920/1080/transport/2",
            "http://lorempixel.com/1920/1080/transport/3"
        ],
        initialPreviewConfig: [
            {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
            {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
            {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
        ]
    });
    $("#file-4").fileinput({
        uploadExtraData: {kvId: '10'}
    });
    $(".btn-warning").on('click', function () {
        var $el = $("#file-4");
        if ($el.attr('disabled')) {
            $el.fileinput('enable');
        } else {
            $el.fileinput('disable');
        }
    });
    $(".btn-info").on('click', function () {
        $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
    });
    /*
     $('#file-4').on('fileselectnone', function() {
     alert('Huh! You selected no files.');
     });
     $('#file-4').on('filebrowse', function() {
     alert('File browse clicked for #file-4');
     });
     */
    $(document).ready(function () {
        $("#test-upload").fileinput({
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
        $("#kv-explorer").fileinput({
            'theme': 'explorer',
            'uploadUrl': '#',
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: [
                "http://lorempixel.com/1920/1080/nature/1",
                "http://lorempixel.com/1920/1080/nature/2",
                "http://lorempixel.com/1920/1080/nature/3"
            ],
            initialPreviewConfig: [
                {caption: "nature-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                {caption: "nature-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                {caption: "nature-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
            ]
        });
        /*
         $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
         alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
         });
         */
    });
</script>
</html>