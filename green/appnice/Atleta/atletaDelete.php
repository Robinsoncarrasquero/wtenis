<?php
session_start();
require '../sql/ConexionPDO.php';
require '../sql/Crud.php';
require '../funciones/funcion_fecha.php';
if (isset($_SESSION['logueado']) && !$_SESSION['logueado']) {
     header('Location: ../sesion_inicio.php');
     exit;
}
if (isset($_SESSION['niveluser']) && $_SESSION['niveluser']<9){
    header('Location: ../sesion_inicio.php');
    exit;
}
$mensaje=null;
if (isset($_REQUEST['atleta_id']))
{
    $atleta_id=  htmlspecialchars($_REQUEST['atleta_id']);
//    echo '<pre>';
//    var_dump($_REQUEST['atleta_id']);
//    echo '</pre>';
    $objeto = new Crud();
    $objeto->table_name="atleta";
    $objeto->select="*";
    $objeto->from="atleta";
    $objeto->condition="atleta_id=$atleta_id";
    $objeto->Read();
    $records = $objeto->rows;
    foreach ($records as $record)
    {
        $cedula= $record['cedula'];
        $nombres= $record['nombres'];
        $apellidos= $record['apellidos'];
        $sexo = $record['sexo'];
        $fecha_nacimiento= $record['fecha_nacimiento'];
        $estado =$record['estado'];
        $email=$record['email'];
       
//        echo '<pre>';
//            var_dump($objeto->rows);
//            
//            echo '</pre>';
           
    }
    
}
else
{
    header("location: atletaRead.php");
}
if (isset($_POST['delete']))
{
    
   if(isset($_POST['cancelar']) && $_POST['cancelar']=="Cancelar")
    {
        header('Location: atletaRead.php');
        exit;
    }
    $atleta_id=  htmlspecialchars($_POST['atleta_id']);

    if (!is_numeric($atleta_id))
        header ("location: atletaRead.php");
    else 
    {
        $objeto = new Crud();
        $objeto->deleteFrom="atleta";
        $objeto->condition="atleta_id=$atleta_id";
        $objeto->Delete();
        $operacionExitosa=$objeto->operacionExitosa;
        $mensaje=$objeto->mensaje;
        if ($operacionExitosa)
        {
            $mensaje .=" <a href='atletaRead.php'>Presiones para continuar</a>";
        }
        else 
        {
            $mensaje .=" <a href='atletaRead.php'>Presiones para Abandonar</a>";
       
        }
    }
}
?>

<html>
    
    <head>
    <meta http-equiv="Context-type" content="text/html; charset=UTF-8"/>
       
    <a href=""> <img id="Logo" src="../images/logofvt.png" width="200"  ></a>
    <link rel="StyleSheet" href="../css/inscribe.css" type="text/css">
    </head>
    <body>
    <div class="contenedor">
   
    <div class="frminscripcion">   
   
            
        
        <form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <h1>MODIFICAR DATOS DE ATLETA</h1>   
            <fieldset>
       
            <label for="codigo">CEDULA:</label>
            <input type="text" name="cedula" maxlength="20" placeholder="123..." required value="<?php echo $cedula;?>">
                          
            <label for="nombre">NOMBRES:</label>
            <input type="text" name="nombres" maxlength="50" placeholder="NICOLAS" required value="<?php echo $nombres;?>"> 
            <br><br>
            <label for="nombre">APELLIDOS:</label>
            <input type="text" name="apellidos" maxlength="50" placeholder="PEREIRA" required value="<?php echo $apellidos;?>"> 
            <br><br>
            <label for="estado">ESTADO:</label>
            <input type="text" name="estado" value="MIR">
            <br><br>
            <label for="sexo">SEXO</label>
            <select name="sexo">
                <?php
                {
                    if ($sexo=="F"){
                        echo '<option selected value="F">Femenino</option>';
                        echo '<option value="M">Masculino</option>';
                    }else{
                        echo '<option value="F">Femenino</option>';
                        echo '<option selected value="M">Masculino</option>';
                    }
                }            
                ?>
            </select>
            <br> <br>
                    
            
                <label for="fecha_nacimiento">FECHA DE NACIMIENTO:</label>
                <input type="date" name="fecha_nacimiento" required value="<?php echo $fecha_nacimiento;?>">
                <br>
                <label for="email">EMAIL:</label>
                <input type="email" name="email" maxlength="50" placeholder="info@gmail.com" value="<?php echo $email;?>"> 
                <br> <br>
            </fieldset>
                
               
            
                      
            <input type="hidden" name="delete">
            <input type="hidden" name="atleta_id" value="<?php echo $atleta_id?>">
            
            <?php 
                if(isset($mensaje)){
                    echo '<input disabled type="hidden" value="Eliminar" formnovalidate="formnovalidate">';
                    echo '<input disabled type="hidden" name="cancelar" formnovalidate="formnovalidate" value="Cancelar">';
                }else{    
                    echo '<input type="submit" value="Eliminar" formnovalidate="formnovalidate">';
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

