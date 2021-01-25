<?php
session_start();
require_once '../clases/Afiliaciones_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Afiliacion_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../funciones/funcion_email.php';
require_once '../sql/ConexionPDO.php';

if (isset($_SESSION['asociacion'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $txt_id=$_POST['txt_id'];
        $txt_cedula = trim($_POST['txt_cedula']);
        $txt_nombres=$_POST['txt_nombres'];
        $txt_apellidos=$_POST['txt_apellidos'];
        $txt_sexo=$_POST['txt_sexo'];
        $txt_fechaNacimiento=$_POST['txt_fechaNacimiento'];
        $txt_biografia='';
        $txt_cedularep=$_POST['txt_cedularep'];
        $txt_nombrerep=$_POST['txt_nombrerep'];
        $txt_direccion=$_POST['txt_direccion'];
        $txt_telefonos=$_POST['txt_telefonos'];
        $txt_email=$_POST['txt_email'];
        $txt_asociacion=$_POST['txt_asociacion'];
        $txt_nacionalidad_id = $_POST['txt_nacionalidad'];
        $txt_disciplina = $_POST['txt_disciplina'];
        $txt_lugar_nac=$_POST['txt_lugar_nac'];
        $txt_celular=$_POST['txt_celular'];
        $txt_lugar_trabajo=$_POST['txt_lugar_trabajo'];
        
        $ok=FALSE;
        {
            //Instanciamos el objeto empresa para traer los datos
            $obj = new Atleta();
            $obj->setCedula($txt_cedula);
            $obj->setNombres($txt_nombres);
            $obj->setApellidos($txt_apellidos);
            $obj->setSexo($txt_sexo);
            $obj->setFechaNacimiento($txt_fechaNacimiento);
            $obj->setBiografia($txt_biografia);
            $obj->setCedulaRepresentante($txt_cedularep);
            $obj->setNombreRepresentante($txt_nombrerep);
            $obj->setDireccion($txt_direccion);
            $obj->setTelefonos($txt_telefonos);
            $obj->setEmail($txt_email);
            $obj->setEstado($txt_asociacion);
            $obj->setNacionalidadID($txt_nacionalidad_id);
            $obj->setCategoria(2);
            $obj->setDisciplina($txt_disciplina);
            $obj->setCelular($txt_celular);
            $obj->setLugarNacimiento($txt_lugar_nac);
            $obj->setLugarTrabajo($txt_lugar_trabajo);
            $obj->setContrasena($txt_cedula);
            $obj->setClaveDefault(1);
            
            $obj->create();
            $operacion=$obj->mensaje;
            
            if ($obj->Operacion_Exitosa()){
                
                //Instanciamos la clase empresa para obtener la empresa_id
                //de la asociacion registrada
                $objEmpresa= new Empresa();
                $objEmpresa->Fetch($txt_asociacion);
                if ($objEmpresa->Operacion_Exitosa()){
                    
                    //Instanciamos la clase afiliados para obtener los montos
                    //de las afiliaciones
                    $objAfiliacion = new Afiliacion();
                    $objAfiliacion->Fetch($objEmpresa->get_Empresa_id());
                    $monto_aso=$objAfiliacion->getAsociacion();
                    $monto_fvt=$objAfiliacion->getFVT();
                    $monto_sis=$objAfiliacion->getSistemaWeb();
                    
                    //Aqui colocamos el ano de afiliacion que cambiara cada ano
                    $anoafiliacion=$objAfiliacion->getAno();
          
                    $objAfiliaciones = new Afiliaciones();
                    $objAfiliaciones->setAno($anoafiliacion);
                    $objAfiliaciones->setAtleta_id($obj->getID());
                    $objAfiliaciones->setSexo($txt_sexo);
                    $objAfiliaciones->setCategoria($obj->categoria_natural($anoafiliacion));
                    $objAfiliaciones->setAsociacion($monto_aso);
                    $objAfiliaciones->setFVT($monto_fvt);
                    $objAfiliaciones->setModalidad($txt_disciplina);
                    $objAfiliaciones->setAfiliacion_id($objAfiliacion->get_ID());
                    $objAfiliaciones->setAceptado(1);
                    $objAfiliaciones->setAfiliarme(1);
                    
                    $objAfiliaciones->create();
                    $ok=TRUE;
                    
                    //Datos para el correo
                    $email_empresa=$objEmpresa->getEmail();
                    $email =  $obj->getEmail();
                    $cedulax=$obj->getCedula();
                    $nombre_atleta=$obj->getNombres();
                    $apellido_atleta=$obj->getApellidos();
                    $banco=$objEmpresa->getBanco();
                    $cuenta = $objEmpresa->getCuenta();
                    $url=$objEmpresa->getURL();
                    $nombre_empresa= $objEmpresa->getNombre();
                    //Notificaccion via email
                    if ($email !=NULL){ // enviamos correo
                        email_notificacion("Pre-Afiliacion", $cedulax);
                    }
                      
                }
              
            }
            $obj= NULL;
        }

        if ($ok) {
            echo 'registered';
            // echo $operacion;
        } else {
           echo '1';
           //  echo $operacion;
        }
    }
}else{
    echo 'Por favor ingrese desde la pagina de inicio';
}

?>