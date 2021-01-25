

<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datos Basicos Continuacion</title>

<!-- Bootstrap 3.3.7 y jquery 3.1.1 -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
<!--    <script type="text/javascript" src="js/jquery/1.15.0/lib/jquery-1.11.1.js"></script>-->
    <script type="text/javascript" src="../js/jquery/1.15.0/dist/jquery.validate.js"></script>
    


<script type="text/javascript">
$('document').ready(function()
{ 
	window.setTimeout(function(){
									
//		window.location.href = "../bsPanel.php";
                window.close();
										
	}, 100);
	
	
	$("#back").click(function(){
		window.location.href = "../bsPanel.php";
	});
});
</script>

</head>

<body>


    
<div class="container">

    <div class="container">

        <div class="col-lg-12">
            <button class=" btn btn-primary" id="back">
                <span class="glyphicon glyphicon-chevron-right"></span> &nbsp; Continuar .....
            </button>
        </div>


    </div>

</div>

</body>
</html>
