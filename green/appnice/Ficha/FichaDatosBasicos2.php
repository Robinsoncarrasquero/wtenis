<?php
session_start();
require_once __DIR__.'/../clases/Atleta_cls.php';
require_once __DIR__.'/../sql/ConexionPDO.php';
require_once __DIR__.'/../clases/Nacionalidad_cls.php';
require_once __DIR__.'/../clases/Empresa_cls.php';
require_once __DIR__.'/../clases/Afiliaciones_cls.php';
require_once __DIR__.'/../clases/Afiliacion_cls.php';
require_once __DIR__.'/../clases/Bootstrap_Class_cls.php';
require_once __DIR__.'/../clases/Bootstrap2_cls.php';
require_once __DIR__.'/../clases/Disciplina_cls.php';
require_once __DIR__.'/../clases/Encriptar_cls.php';
require_once __DIR__.'/../funciones/bsTemplate.php';
require_once  __DIR__.'/../clases/Torneos_cls.php';
require_once  __DIR__.'/../clases/Torneos_Inscritos_cls.php';

if (!isset($_SESSION['niveluser']) || !isset($_SESSION['logueado'])){
    header("Location:../Login.php");
}
$hidden="";
if ($_SESSION['niveluser']==9){
    $readonly="readonly";
    $disabled="disabled";
    $atleta_id = htmlentities($_GET['id']);
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar="hidden";
}
if ($_SESSION['niveluser']>9){
    $readonly=" ";
    $disabled=" ";
    $atleta_id = htmlentities($_GET['id']);
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
}
if ($_SESSION['niveluser']==0){
    if ($_SESSION['deshabilitado']){
        $readonly=" ";
        $disabled=" ";
   
    }else{
        $readonly="readonly ";
        $disabled="disabled";
    }
    $atleta_id = $_SESSION['atleta_id'];
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
   
}

$ObjAtleta = new Atleta();
$ObjAtleta->Find($atleta_id);
if ($ObjAtleta->edad()<19){
    $junior=TRUE;
    $hidden_datos_representante="";
}else{
    $junior=FALSE;
    $hidden_datos_representante="hidden";
}
//Obtenemos los datos de la empresa o asociacion del atleta
//para verificar si puede ver la clave del afiliado de la asociacion
$objEmpresa = new Empresa();
$objEmpresa->Fetch($ObjAtleta->getEstado());
if ($_SESSION['niveluser']>=99 || ($_SESSION['niveluser']>=9 && $objEmpresa->get_Empresa_id()==$_SESSION['empresa_id'])){
    $puedeverclave=true;
}else{
    $puedeverclave=false;
}

//Obtenemos la afiliacion del atleta del ano para que pueda afiliar y aceptar la afiliacion
$objAfiliado = new Afiliaciones();
$objAfiliado->Find_Afiliacion_Atleta($ObjAtleta->getID(),date("Y"));

$deshabilitado = $objAfiliado->getPagado() > 0 ? FALSE : TRUE;
if ($_SESSION['niveluser']==9 && $deshabilitado){
    $readonly=" ";
    $disabled=" ";
    $hidden_btn_regresar=" ";
    $hidden_btn_guardar=" ";
}

$objAfiliaciones = new Afiliaciones();
$objAfiliaciones->Atleta($atleta_id);//Se busca la ultima afiliacion registrada 
$nacion_id=$ObjAtleta->getNacionalidadID();
$rsNaciones= Nacionalidad::ReadAll();

//Llenamos una recordset con las entidades para hacer seleccion en listbox

$estado=$ObjAtleta->getEstado();
$array_entidades=Empresa::Entidades();

$indice = array_search($estado, array_column($array_entidades, 'estado'));

if ($indice >= 0 ) {
    if ($_SESSION['niveluser']<99) {
        $rsEntidades[] = $array_entidades[$indice];
    } else {
        $rsEntidades = $array_entidades;

    }
} else {
    $rsEntidades = $array_entidades;
}

//Carga la disciplina de juego
$array_disciplina= Disciplina::ReadAll();
$indice = array_search($ObjAtleta->getDisciplina(), array_column($array_disciplina, 'disciplina'));
if ($indice >= 0) {
    if ($_SESSION['niveluser']<99) {
       $rsDisciplina[] = $array_disciplina[$indice];
    } else {
       $rsDisciplina = $array_disciplina;
    }
} else {
    $rsDisciplina = $array_disciplina;
}
//Header pagina
echo bsTemplate::header('Ficha',$_SESSION['nombre']);
echo bsTemplate::aside();
$main = [];
$dmain =["opcion"=>"Ficha de Atleta","icono"=>"glyphicon glyphicon-user","href"=>""];
array_push($main, $dmain);

echo  bsTemplate::main_content('Ficha de Atleta',$main);

//Mensaje de cambios de la ficha
$objAtleta= $ObjAtleta;
if ($objAtleta->getCelular()==NULL || $objAtleta->getLugarNacimiento()==NULL || 
    $objAtleta->getCedulaRepresentante()==NULL || $objAtleta->getNombreRepresentante()==NULL ||
    $objAtleta->getDireccion()==NULL){
        if ($objAtleta->edad()<19){
            $texto =' '
            . 'Los datos del Representante del Atleta menor no estan actualizados.'
            . 'Llene la informacion de contacto de su representante, padres o responsables.';
            $notaspanel = bsTemplate::panel('Informacion',$texto,'alert alert-danger','col-xs-12');
            echo $notaspanel;    
        }
             
}else{
    $texto =' '
    .'Los datos del atleta parecen estar completos y actualizados en la Fecha :'.$objAtleta->getFechaModificacion();
    //$notaspanel = bsTemplate::panel_texto('Informacion',$texto,'alert alert-success','col-xs-12');
   // echo $notaspanel;    
}



?>

    <div class="signin-form">
        
        
        <form class="form-signin " method="post" id="register-form" >
                    
            <div class="form-group col-xs-12 col-sm-6">
                <label for="txt_asociacion">Estado</label>
                <select  name="txt_asociacion" class="form-control">
                <?php
                // Recorremos todas las lineas del archivo
                foreach ($rsEntidades as $value) {
                    if ($value['estado']==$estado){
                        echo  '<option selected value="'.$value['estado'].'">'.ucwords($value['entidad']).'</option>'; 
                    }else{
                        echo  '<option value="'.$value['estado'].'">'.ucwords($value['entidad']).'</option>'; 
                    }
                    
                }
                ?>
                    

                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <label for="txt_disciplina">Disciplina</label>
                <select   name="txt_disciplina" class="form-control">
                                        
                <?php
                // Recorremos todas las lineas del archivo
                foreach ($rsDisciplina as $record) {
                    
                    if ($ObjAtleta->getDisciplina()==$record['disciplina']){
                        echo  '<option selected value="'.$record['disciplina'].'">'.$record['descripcion'].'</option>';
                    }else{
                        echo  '<option  value="'.$record['disciplina'].'">'.$record['descripcion'].'</option>';
            
                    }
                }
                ?>
                
                </select>
                </div>
    
            <div class="form-group col-xs-12 col-sm-4 ">
            <label for="txt_cedula">Cedula</label>
            <input <?php echo $readonly?>  type="text" class="form-control" lenght="20" id="txt_cedula" name="txt_cedula" value="<?php echo $ObjAtleta->getCedula()?>" >
            </div>
            
                <div class="form-group col-xs-12 col-sm-4">
                <label for="txt_nombres">Nombre</label>
                <input <?php echo $readonly?>   type="text" class="form-control" lenght="50" id="txt_nombres" name="txt_nombres" value="<?php echo $ObjAtleta->getNombres()?>"  >
            </div>
            
            
            <div class="form-group col-xs-12 col-sm-4">
                <label for="txt_apellidos">Apellido</label>
                <input <?php echo $readonly?>  type="text" class="form-control" lenght="50" id="txt_apellidos" name="txt_apellidos"value="<?php echo $ObjAtleta->getApellidos()?>"  >
            </div>
            
            <div class="form-group col-xs-12 col-sm-4">
                <label for="txt_fechaNacimiento">Fecha Nacimiento</label>

                <input <?php echo $readonly?> type="date" class="form-control"  id="txt_fechaNacimiento" name="txt_fechaNacimiento" value="<?php echo $ObjAtleta->getFechaNacimiento()?>">

            </div>
    
            <div class="form-group col-xs-12 col-sm-4">
            <label for="txt_sexo">Sexo</label>
                <select   name="txt_sexo" class="form-control">
                <?php
                if ($ObjAtleta->getSexo()=='F'){
                    echo '<option selected value="F">Femenino</option>';
                    echo '<option value="M">Masculino</option>';
                }else{
                    echo '<option value="F">Femenino</option>';
                    echo '<option selected value="M">Masculino</option>';
                }     
                ?>
            </select>
                </div>
            <div class="form-group  col-xs-12 col-sm-4 hidden">
                <label for="txt_id">Atleta</label>
                <input  readonly type="text" class="form-control" id="txt_id" name="txt_id" value="<?php echo $ObjAtleta->getID()?> ">
            </div>
            
                <div class="form-group col-xs-12 col-sm-4">
            <label for="txt_nacionalidad">Nacionalidad</label>
            <select  name="txt_nacionalidad" class="form-control">
            <?php
            // Recorremos todas las lineas del archivo
            foreach ($rsNaciones as $record) {
                $pais=$record['pais'];
                $id=$record['id'];
                if ($id==$nacion_id){
                    echo  '<option selected value="'.$record['id'].'">'.$pais.'</option>';
                }else{
                    echo  '<option  value="'.$record['id'].'">'.$pais.'</option>';
                }
            }
            ?>
            </select>
            </div>
            
            <div class="form-group col-xs-12 col-sm-6">
                <label for="txt_lugar_nac">Lugar de Nacimiento</label>
                <input  type="text" class="form-control" lenght="20" placeholder="Lugar de nacimiento" id="txt_lugar_nac" lenght="30" name="txt_lugar_nac" value="<?php echo $ObjAtleta->getLugarNacimiento()?>" >
            </div>
        
            <div class="form-group col-xs-12 col-sm-6  <?php echo $hidden_datos_representante?>">
            <label for="txt_cedularep">Cedula Representante</label>
            <input  type="text" class="form-control" lenght="20" placeholder="Cedula del Representante" id="txt_cedularep" name="txt_cedularep" value="<?php echo $ObjAtleta->getCedulaRepresentante()?>">
            </div>

            <div class="form-group col-xs-12 col-sm-6  <?php echo $hidden_datos_representante?>">
            <label for="txt_nombrerep">Nombre Representante</label>
            <input  type="text" class="form-control" lenght="50" placeholder="Nombre del Representante" id="txt_nombrerep" name="txt_nombrerep" value="<?php echo $ObjAtleta->getNombreRepresentante()?>">
            </div>
                
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_lugar_trabajo">Lugar de Trabajo o Empresa</label>
                <input type="text" class="form-control" lenght="20" id="txt_lugar_trabajo" lenght="40" placeholder="Lugar de Trabajo" name="txt_lugar_trabajo" value="<?php echo $ObjAtleta->getLugarTrabajo()?>" >
            </div>
                
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_celular">Celular</label>
                <input  type="text" class="form-control" lenght="20" id="txt_celular" lenght="20" placeholder="Celular" name="txt_celular" value="<?php echo $ObjAtleta->getCelular()?>" >
            </div>
            
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_telefonos">Telefono</label>
                <input   type="text" class="form-control" lenght="45" placeholder="Telefono" id="txt_telefonos" name="txt_telefonos" value="<?php echo $ObjAtleta->getTelefonos()?>" >
            </div>

            <div class="form-group col-xs-12">
                <label for="txt_direccion">Direccion</label>
                <textarea   class="form-control" rows="2" lenght="150" placeholder="Direcccion" id="txt_direccion" name="txt_direccion" placeholder="Direccion"><?php echo $ObjAtleta->getDireccion()?></textarea>
            </div>

            <div class="form-group col-xs-12">
                <label for="txt_email">Email</label>
                <input <?php echo $readonly?> type="email" class="form-control" lenght="100" id="txt_email" name="txt_email" value="<?php echo $ObjAtleta->getEmail()?>" >
            </div>
            
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_talla">Estatura</label>
                <input  type="text" class="form-control" lenght="5" id="txt_talla"  placeholder="1.80" name="txt_talla" value="<?php echo $ObjAtleta->getTalla()?>" >
            </div>
            
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_peso">Peso</label>
                <input  type="number" class="form-control" lenght="3" id="txt_peso"  placeholder="50" name="txt_peso" value="<?php echo $ObjAtleta->getPeso()?>" >
            </div>
            
            <div class="form-group col-xs-12 col-sm-6 col-md-4">
                <label for="txt_inicio">Fecha Inicio</label>
                <input   type="date" class="form-control"  placeholder="fecha inicio" id="txt_inicio" name="txt_inicio" value="<?php echo $ObjAtleta->getInicio()?>" >
            </div>
            
            <div class="form-group col-xs-12 col-sm-6 col-md-6">
            <label for="txt_hand">Jugador</label>
            <select   name="txt_hand" class="form-control">
                <?php
                if ($ObjAtleta->getHand()=='Derecho'){
                    echo '<option selected value="Derecho">Derecho</option>';
                    echo '<option value="Zurdo">Zurdo</option>';
                }else{
                    echo '<option value="Derecho">Derecho</option>';
                    echo '<option selected value="Zurdo">Zurdo</option>';
                }     
                ?>
            </select>
          </div>
            <div class="form-group col-xs-12 col-sm-6 col-md-6">
                <label for="txt_nickname">Nick Name</label>
                <input   type="text" class="form-control" lenght="10" placeholder="NickName" id="txt_nickname" name="txt_nickname" value="<?php echo $ObjAtleta->getNickName()?>" >
            </div>
            <?php
            
            if ($puedeverclave){
                echo '<div class="form-group col-xs-12">';
                echo ' <label for="txt-clave">Clave</label>';
                echo ' <input type="text" class="form-control" lenght="100" id="txt_clave" name="txt_clave" value="'.$ObjAtleta->getContrasena().'" >';
                echo '</div>';
            }
            
            ?>

                
                
            
            <div class="form-group col-xs-6 <?php echo $hidden_btn_guardar ?>  ">
                <button  type="submit" class="btn btn-primary" name="btn-save" id="btn-submit">
                <span ></span> &nbsp; Guardar
            </div>
            <div id="results" class='col-xs-6 '>
                <!-- error will be showen here ! -->
            </div>
         
            
        </form>
             
    </div>
        
<?php echo bsTemplate::footer();?>

<script>

$(document).ready(function (){
    
    // $.validator.addMethod("alfanumerico", function(value, element) {
    //     return /^[a-z0-9]*$/i.test(value);
    // }, "Ingrese sólo letras o números.");
    
    // $.validator.addMethod("formatoEmail", function(value, element) {
    //     return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    // }, "Ingrese un Email Valido.");
    
   
    $('#register-form').on('submit',function(e){
        //var ok=confirm("Esta Seguro de Modificar Los Datos");
        //var data = new FormData(document.getElementById("myform"));
        //formData.append("operacion", op);
        //formData.append(f.attr("name"), $(this)[0].files[0]);
        var data = $("#register-form").serialize();
        $.ajax({
            url: "FichaDatosBasicosSave2.php",
            type: "POST",
            data:data,
            // beforeSend: function()
            // {	
            //     $("#error").fadeOut();
            //     $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
            // },
            success :  function(data)
                {						
                    if(data.Success===false){
                
                        $("#results").addClass("alert alert-danger").html(data.Mensaje);
                        
                        $("#btn-submit").html('Guardar');
                        

                    }else{
                        
                        $("#results").addClass("alert alert-success").html(data.Mensaje);
                        
                        $("#btn-submit").addClass("glyphicon glyphicon-ok");
     
                     //   setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("FichaDatosBasicosSuccess.php"); }); ',2000);
                    
                    }
                    
                }
        });
        return false;
    });
    
});

</script>
 
</body>
</html>
