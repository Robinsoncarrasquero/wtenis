<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>Krajee JQuery Plugins - &copy; Kartik</title>

<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="../bootstrap/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="../bootstrap/fileinput/js/fileinput.min.js" type="text/javascript"></script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>



</head>
<body>

<input id="archivos" type="file" class="file" name="imagenes[]" multiple=true class="file-loading">

<?php
    $directorio="imagenes_/";
    $imagenes=  glob($directorio."*.*");
?>
</body>
<script>
$("#archivos").fileinput({
uploadUrl: "upload.php",
uploadAsync:false,
minFileCount:1,
maxFileCount:8,
showUpload:true,
showRemove:false,
initialPreview:[<?php foreach ($images as $image){
                    echo "<img src='".$image. "' height='120px' class='file-preview-image'>";
                }
                ?>
                        ],
                
initialPreviewConfig:[<?php foreach ($images as $image2){
    $infoImagenes= explode("/", $image2);

?>

{caption : "<?php echo $infoImagenes[1];?>", height: "120px" , url : "borrar.php", key :"<?php echo $infoImagenes[1]; ?>"},
<?php } ?>]
});
</script>

&nbsp;

</html>    