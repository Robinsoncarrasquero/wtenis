

<!DOCTYPE html >
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preafiliacion exitosa</title>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 

<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>

<script type="text/javascript" src="validation.min.js"></script>
<link href="style.css" rel="stylesheet" media="screen">

<script type="text/javascript">
$('document').ready(function()
{ 
	window.setTimeout(function(){
									
		window.location.href = "../sesion_inicio.php";
										
	}, 1000);
	
	
	$("#back").click(function(){
		window.location.href = "../sesion_inicio.php";
	});
});
</script>

</head>

<body>


    
<div class="signin-form">

<div class="container">
    <div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Exito!</strong>  Registro procesado.
    </div>
    
    <button class="btn btn-primary" id="back">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Iniciar Sesion
    </button>
    
</div>

</div>

</body>
</html>
