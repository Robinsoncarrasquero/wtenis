<?php
session_start();

require_once '../sql/ConexionPDO.php';
require_once '../sql/Crud.php';
require_once '../funciones/funciones.php';
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Empresa_cls.php';

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
        $clave=$record['contrasena'];
              
//        echo '<pre>';
//        var_dump($email);
//        var_dump($estado);
//        echo '</pre>';
           
    }
    
    
}
else
{
   header('Location: atletaRead.php');
   exit;
}

if  ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['update']) || isset($_POST['cancelar'])))
{
    if($_POST['cancelar']=="Cancelar")
    {
        header('Location: atletaRead.php');
        exit;
    }
    //tomamos los valores de los campos del formulario
    $atleta_id =  htmlspecialchars($_POST['atleta_id']);
    $ucedula=   htmlspecialchars(strtoupper($_POST['cedula']));
    $unombres = htmlspecialchars(strtoupper( $_POST['nombres']));
    $uapellidos = htmlspecialchars(strtoupper( $_POST['apellidos']));
    $usexo = htmlspecialchars($_POST['sexo']);
    $ufecha_nacimiento = htmlspecialchars($_POST['fecha_nacimiento']);
    $uestado= htmlspecialchars($_POST['estado']);
    $uemail= htmlspecialchars($_POST['email']);
    
    //Cargamos los campos para verificar cambios de propiedades en el objeto instanciado
    $objeto->fields_change('cedula', $ucedula);
    $objeto->fields_change('nombres', $unombres);
    $objeto->fields_change('apellidos', $uapellidos);
    $objeto->fields_change('sexo', $usexo);
    $objeto->fields_change('fecha_nacimiento', $ufecha_nacimiento);
    $objeto->fields_change('estado', $uestado);
    $objeto->fields_change('email', $uemail);
        
    //Reiniciamos la variables locales con los valores de los campos post del formulario
    //para setear los valores al recargar la pagina
   
    $cedula =   htmlspecialchars(strtoupper($_POST['cedula']));
    $nombres = htmlspecialchars(strtoupper( $_POST['nombres']));
    $apellidos = htmlspecialchars(strtoupper( $_POST['apellidos']));
    $sexo =   htmlspecialchars(strtoupper($_POST['sexo']));
    $fecha_nacimiento = htmlspecialchars($_POST['fecha_nacimiento']);
    $estado= htmlspecialchars($_POST['estado']);
    $email= htmlspecialchars($_POST['email']);
    $clave= htmlspecialchars($_POST['contrasena']);
    //Actualizamos de haber algun campo modificado

    $dirty=TRUE;
    if ($dirty){  
      
        $objetoup = $objeto;
        $objetoup->update="atleta";

        $objetoup->set="cedula='$ucedula',nombres='$unombres',apellidos='$uapellidos',sexo='$usexo',fecha_nacimiento='$ufecha_nacimiento',estado='$uestado',email='$uemail'";
      
        $objetoup->condition="atleta_id=$atleta_id";
        $objetoup->Update();
        $mensaje=$objetoup->mensaje;
        
        if ($objetoup->operacionExitosa){
            
            $objetoup->table_name="atleta";
            $objetoup->select="*";
            $objetoup->from="atleta";
            $objetoup->condition="atleta_id=$atleta_id";
            $objetoup->email_notification("Registro");
            $mensaje .=" <a href='atletaRead.php'>La clave fue reseteada, Presiones para continuar</a>";
            //htmlcloseWindow(); 
            header('Location: atletaRead.php');
            exit;       
            
        }else{
            $mensaje .="<a href='atletaRead.php'>No hubo cambio, Presiones para Abandonar</a>";
            header('Location: atletaRead.php');
            exit;
            
        }
         
    }else{
        
        //htmlcloseWindow();
        header('Location: atletaRead.php');
        exit;
       
        
    }

             
        
    
    
} 
?>

<html
    
    <head>
    <meta http-equiv="Context-type" content="text/html; charset=UTF-8"/>
       
    <a href="sesion_usuario.php"> <img id="Logo" src="../images/logo/fvtlogo.png" width="200"  ></a>
    <link rel="StyleSheet" href="../css/inscribe.css" type="text/css">
    </head>
    <body>
    <div class="contenedor">
   
    <div class="frminscripcion">   
   
       
        
        
        <form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
            <h1>MODIFICAR DATOS DE ATLETA</h1>   
            <fieldset>
            <label for="codigo">CEDULA:</label>
            <input type="text" name="cedula" maxlength="20" placeholder="cedula" required value="<?php echo $cedula;?>">
             <br><br>
            <label for="nombre">NOMBRES:</label>
            <input type="text" name="nombres" maxlength="50" placeholder="nombres" required value="<?php echo $nombres;?>"> 
            <br><br>
            <label for="apellidos">APELLIDOS:</label>
            <input type="text" name="apellidos" maxlength="50" placeholder="apellidos" required value="<?php echo $apellidos;?>"> 
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
            <br><br>
           
            
            <label for="fecha_nacimiento">FECHA DE NACIMIENTO:</label>
            <input type="date" name="fecha_nacimiento" required value="<?php echo $fecha_nacimiento;?>">
            <br><br>
            <label for="estado">ESTADO:</label>
            <input type="text" name="estado" value="<?php echo $estado;?>">
            <br> <br>
            
            <label for="email">EMAIL:</label>
            <input type="email" name="email" maxlength="100" placeholder="example@gmail.com" value="<?php echo $email;?>"> 
            <br> <br>
            <label for="clave">Clave:</label>
            <input type="text" name="clave" maxlength="20" placeholder="clave" required value="<?php echo $clave;?>">

            </fieldset>
                      
            <input type="hidden" name="update">
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


