<?php
session_start();

require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';
if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}

$mensaje=null;

if (isset($_POST['create']))
{
    if(isset($_POST['cancelar']))
    {
        if ($_POST['cancelar']=='Cancelar'){
            header('Location: atletaRead.php');
            exit;
        }
    }
     //tomamos los valores de los campos del formulario
    $atleta_id =  htmlspecialchars($_POST['atleta_id']);
    $cedula=   htmlspecialchars($_POST['cedula']);
    $nombres = htmlspecialchars(strtoupper( $_POST['nombres']));
    $apellidos = htmlspecialchars(strtoupper( $_POST['apellidos']));
    $sexo = htmlspecialchars($_POST['sexo']);
    $fecha_nacimiento = htmlspecialchars($_POST['fecha_nacimiento']);
    $estado= htmlspecialchars($_POST['estado']);
    $email= htmlspecialchars($_POST['email']);
//  
//            echo'<pre>';
//            echo "var_dump($fechacierre)".'</br>';
//            echo '</pre>';
//            die("ERRROR inscribiendo");
    $objeto = new Crud();
    $objeto->insertInto="atleta";
    $objeto->insertColumns="cedula,nombres,apellidos,sexo,fecha_nacimiento,estado,email,contrasena,nacionalidad_id";
    $objeto->insertValues="'$cedula','$nombres','$apellidos','$sexo','$fecha_nacimiento','$estado','$email','$cedula',1";
    $objeto->Create();
    $mensaje=$objeto->mensaje;
    if ($objeto->operacionExitosa){
       
            $objeto->table_name="atleta";
            $objeto->select="*";
            $objeto->from="atleta";
            $objeto->condition="cedula='$cedula'";
            //$objeto->email_notification("Registro");
            $mensaje .=" <a href='atletaRead.php'>Presiones para continuar</a>";
    }else{
        $mensaje .=" <a href='atletaRead.php'>Presiones para Abandonar</a>";

    }
    

    
           
}

?>

<html>
    
    <head>
    <meta http-equiv="Context-type" content="text/html; charset=UTF-8"/>
       
   
    <link rel="StyleSheet" href="../css/inscribe.css" type="text/css">
    </head>
    <body>
    <div class="contenedor">
   
    <div class="frminscripcion">   
   
       
        
        <form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <h1>CREAR DATOS DE ATLETA</h1>   
            <fieldset>
                <label for="codigo">CEDULA:</label>
                <input type="text" name="cedula" maxlength="20" placeholder="cedula" required>
                               
                <label for="nombre">NOMBRES:</label>
                <input type="text" name="nombres" maxlength="50" placeholder="nombres" required> 
                <br> <br>

                <label for="nombre">APELLIDOS:</label>
                <input type="text" name="apellidos" maxlength="50" placeholder="apellidos" required> 
                <br> <br>

                <label for="estado">ESTADO:</label>
                <input type="text" name="estado" required value="LAR" placeholder="LAR">
                <br> <br><br>
                <label for="sexo">SEXO</label>
                <select name="sexo">
                    <option selected value="F">Femenino</option>
                    <option value="M">Masculino</option>
                </select>
                <br><br>
                <label for="fecha_nacimiento">FECHA DE NACIMIENTO:</label>
                <input type="date" name="fecha_nacimiento" required value="<?php echo date("Y-m-d");?>">
                <br>
                <label for="email">EMAIL:</label>
                <input type="email" name="email" maxlength="50" placeholder="email" required> 
                <br> <br>
            </fieldset>

            
                      
            <input type="hidden" name="create">
            <input type="hidden" name="atleta_id" value="<?php echo $atleta_id?>">
            <?php 
                if(isset($mensaje)){
                    echo '<input disabled type="hidden" value="Guardar" formnovalidate="formnovalidate">';
                    echo '<input disabled type="hidden" name="cancelar" formnovalidate="formnovalidate" value="Cancelar">';
                }else{    
                    echo '<input type="submit" value="Guardar" formnovalidate="formnovalidate">';
                    echo '<input type="submit" value="Cancelar" formnovalidate="formnovalidate" name="cancelar">';
                }
            ?>
            
        </form>
       
         <div class="msgerror" >
            <?php if(isset($mensaje)): ?>
              <spam> <?php echo "<br><br>".$mensaje ?></spam>
            <?php endif; ?>
        </div>
        </div>
    </div>
    </body>
</html>

