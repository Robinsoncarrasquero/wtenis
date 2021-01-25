
<?php
    $directorio="uploadimagenes/";
    $imagenes=  glob($directorio."*.*");
    
    foreach ($imagenes as $image){
                    echo $image;
                    echo "</br>";
    }
?>
<!DOCTYPE html>
<!-- release v4.4.5, copyright 2014 - 2017 Kartik Visweswaran -->
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Krajee JQuery Plugins - &copy; Kartik</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="../themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="../js/plugins/sortable.js" type="text/javascript"></script>
    <script src="../js/fileinput.js" type="text/javascript"></script>
    <script src="../js/locales/fr.js" type="text/javascript"></script>
    <script src="../js/locales/es.js" type="text/javascript"></script>
    <script src="../themes/explorer/theme.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<div class="container kv-main">
    <div class="page-header">
        <h1>Bootstrap File Input Example
            <small><a href="https://github.com/kartik-v/bootstrap-fileinput-samples"><i
                    class="glyphicon glyphicon-download"></i> Download Sample Files</a></small>
        </h1>
    </div>
    <form enctype="multipart/form-data">
        
        <label>Spanish Input</label>
        <input id="file-es" class="file-preview-image" name="imagenes[]" type="file" multiple>
        <br>
        
        <button type="reset" class="btn btn-default">Reset</button>
    </form>
   
   
   
    <br>
</div>

</body>
<script>
    
    $('#file-es').fileinput({
        language: 'es',
        uploadUrl: 'upload.php',
        allowedFileExtensions: ['jpg', 'png', 'gif'],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFileSize: 10000,
        maxFilesNum: 10,
//        initialPreview: [
//            "http://lorempixel.com/1920/1080/transport/1",
//            "http://lorempixel.com/1920/1080/transport/2",
//            "http://lorempixel.com/1920/1080/transport/3"
//        ],
        initialPreview:[<?php foreach ($imagenes as $image){
                    
                    echo "'$image',";
                    
                }
                ?>
        ],
// initialPreview: [
//            "uploadimagenes/ft1.jpg",
//            "uploadimagenes/ft2.jpg"
//            
//        ],
        
//        initialPreviewConfig: [
//            {caption: "ft1.jpg", size: 329892, width: "120px", url: "borrar.php", key: "ft2.jpg"},
//            {caption: "ft2.jpg", size: 872378, width: "120px", url: "borrar.php", key: 2},
//            {caption: "ft3.png", size: 632762, width: "120px", url: "borrar.php", key: 3}
//        ]
        
        initialPreviewConfig:[
            <?php 
                $i=0;
                foreach ($imagenes as $image2){
                    $infoImagenes= explode("/", $image2);
                    $i++;
//                    echo $image2;
//                    echo "</br>";
                    if ($i<count($imagenes)){
                        $linea='{caption: "'.$infoImagenes[1] .'", width:"120x", url:"borrar.php", key:"'.$infoImagenes[1].'"},';
                    }else{
                        $linea='{caption: "'.$infoImagenes[1] .'", width :"120x", url:"borrar.php", key:"'.$infoImagenes[1].'"}';

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