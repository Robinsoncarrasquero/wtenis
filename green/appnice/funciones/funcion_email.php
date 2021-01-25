<?php
require_once 'funcion_fecha.php';
require_once '../conexion.php';

/* 
 * Utilizamos esta funcion para hacer el envion de correo de cualquier moovimiento tales 
 * como Inscripcion, eliminacion de inscripcion, retiros.
 */
function email_inscripcion($tipodeoperacion,$torneoid,$atleta_id,$categoria){
    $email_empresa= $_SESSION['email_empresa'];
    if (isset($_SESSION['email_envio'])){
        $email_from= $_SESSION['email_envio'];
    }else{
        $email_from="info@fvtenis.com.ve";
    }
    $fileTemplate="Template_Torneo_Notificacion.html";
    switch ($tipodeoperacion){
        case "ELI": //Eliminacion
            $movimiento="Eliminacion de Inscripcion";
            break;
        case "RET": //Retiro
            $movimiento="Retiro de Inscripcion";
            break;
        case "Dat": //Modificacion de datos
            $movimiento="Modificacion de Datos";
            break;
        
        default:
             $fileTemplate="Template_Torneo_Inscripcion.html";
             $movimiento="Inscripcion";
            
   } 
   
   // Aqui hacemos una descripcion de categoria(12,14,16,PN,PV)
    switch ($categoria){
        case "PV": // Categoria PV
            $titcategoria="Pelota Verde";
            break;
        case "PN": // Categoria PN
            $titcategoria="Pelota Naranja";
            break;
      
        default:
            $titcategoria=$categoria; // Las categoria por defecto
   } 
    
    //Datos del torneo 
    $sql="SELECT modalidad,asociacion,entidad,fechacierre,fecharetiros,"
            . "fecha_inicio_torneo,codigo,nombre,empresa_id,tipo "
            . "FROM torneo "
            . "WHERE torneo_id=$torneoid";
    
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row){
        $codigo_torneo=$row["codigo"];
        $nombre_torneo=$row["nombre"];
        $empresa_id=$row["empresa_id"];
        $grado=$row["tipo"];
        $fechacierre=$row["fechacierre"];
        $fecharetiro=$row["fecharetiros"];
        $fechainicio=$row["fecha_inicio_torneo"];
        $categoria_torneo=$row['categoria'];
        $entidad_torneo=$row["entidad"];
        
        $disciplina = $row['modalidad'];
         
        //Datos del Atleta
        $sql="SELECT cedula,fecha_nacimiento,sexo,nombres,apellidos,email,estado "
                . "FROM atleta "
                . "WHERE atleta_id=$atleta_id ";
        
        $result=mysql_query($sql);
        $row = mysql_fetch_array($result);
        
        $nombre_atleta=$row["nombres"];
        $apellido_atleta=$row["apellidos"];
        $email=$row["email"];
        $estado=$row["estado"];
        $sexo=$row["sexo"];
        $cedula=$row["cedula"];
        $fechanacimiento=  fecha_date_dmYYYY($row["fecha_nacimiento"]);
        $categoria_natural = categoria_natural(anodeFecha($row["fecha_nacimiento"]));
        
        //Buscamos los datos Banciarios en la Tabla Empresa o asociacion
        //$sqlEmp="SELECT telefonos,entidad,cuenta,banco,rif,nombre,email FROM empresa WHERE empresa_id=" .$empresa_id;
        $sqlEmp="SELECT telefonos,entidad,cuenta,banco,rif,nombre,email "
                . "FROM empresa "
                . "WHERE estado='$entidad_torneo'";
        
        $result2=mysql_query($sqlEmp);
        $rsempresa= mysql_fetch_assoc($result2);
        if ($rsempresa){
            $banco_empresa =$rsempresa['banco'];
            $cuenta_empresa =$rsempresa['cuenta'];
            $rif_empresa =$rsempresa['rif'];
            $nombre_empresa =$rsempresa['nombre'];
            $email_empresa=$rsempresa['email'];
            $telefonos_empresa=$rsempresa['telefonos'];
        }else{
            $banco_empresa ="desconocido";
            $cuenta_empresa ="desconocida";
            $rif_empresa ="desconocido";
            $nombre_pago ="desconocida";
            $email_empresa="desconocido";
            $telefonos_empresa='desconocido';
        }
      
        $strMensaje = "Estimado(a) Atleta($estado) $nombre_atleta, $apellido_atleta, le informamos que su solicitud de $movimiento al Torneo: "
                . "$nombre_torneo Categoria($titcategoria) "
                . "fue procesada exitosamente.";
        if ($tipodeoperacion == "INS") {
            $strMensaje .= "<br><br>NOTA:";
            $strMensaje .= "Solo debe pagar al momento de la firma del Torneo Grado : $grado";
        }
        //Obtenemos la Plantilla HTML
        $file_template= file_get_contents("../Email_Template/". $fileTemplate);
       
        //Creamos los paramentros de la plantila HTML
        $campos=['@@OPERACION','@@SOLICITUD','@@CEDULA','@@NOMBRES','@@APELLIDOS','@@FECHANACIMIENTO','@@SEXO',
            '@@ASOCIACION','@@CATEGORIANATURAL','@@CODIGO','@@NOMBRE_TORNEO','@@ENTIDAD','@@GRADO','@@CATEGORIA','@@FECHACIERRE','@@FECHARETIRO','@@FECHAINICIO',
            '@@DISCIPLINA','@@TELEFONOS','@@BANCO','@@CUENTA','@@RIF','@@BENEFICIARIO','@@EMAIL_PAGO'];
        
        $valores=[$movimiento,$strMensaje,$cedula,$nombre_atleta,$apellido_atleta,$fechanacimiento,$sexo,
            $estado,$categoria_natural,$codigo_torneo,$nombre_torneo,$entidad_torneo,$grado,$categoria,$fechacierre,
           $fecharetiro,$fechainicio,$disciplina,$telefonos_empresa,$banco_empresa,$cuenta_empresa,$rif_empresa,$nombre_empresa,$email_empresa];
        
        //Reemplazamos los parametros con los valores del Template
        $body = html_template($campos, $valores, $file_template);
        
        //Enviamos el Correo
        {
            $nombre_remitente='fvtenis.com.ve';
            $to = $email; //"robinson.carrasquero@gmail.com";
            $subject = "$movimiento al torneo:($codigo_torneo)";
            
            if ($atleta_id==487){ // Prueba de usuario
                $from = "From: fvtenis.com.ve<info@fvtenis.com.ve>"
                    . "\r\n" ."BCC:atenismiranda@gmail.com";
            }else{
                $from = "From: $nombre_remitente<".$email_from.">" 
                    . "\r\n" ."BCC:atenismiranda@gmail.com,$email_empresa";
            }
            email_smtp($to,$subject,$body,$from);
        }
    }
    return;
}


//Utilizamos esta funcion para enviar un correo cuando se hacen modifican datos
//de correos, cambio de clave, ingreso al sitio, etc. En este caso la plantilla
//de mensaje es distinta.
function email_notificacion($tipoNotificacion,$cedulax,$nota=NULL){
       
    
    $email_empresa= $_SESSION['email_empresa'];
    $empresa_id=$_SESSION['empresa_id'];
    if (isset($_SESSION['email_envio'])){
        $email_from= $_SESSION['email_envio'];
    }else{
        $email_from="info@fvtenis.com.ve";
    }
    
    //Datos del atleta
    $sql="SELECT lugarnacimiento,cedula,sexo,fecha_nacimiento,nombres,apellidos,"
            . "email,contrasena,estado,atleta_id,disciplina "
            . "FROM atleta "
            . "WHERE cedula=$cedulax";
    
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    $atleta_id=$row['atleta_id'];
    $nombre_atleta=trim($row["nombres"]);
    $apellido_atleta=trim($row["apellidos"]);
    $disciplina=trim($row["disciplina"]);
    $email=$row["email"];
    $estado=$row["estado"];
    $sexo=$row["sexo"];
    $cedula=$row["cedula"];
    $fechanacimiento=  fecha_date_dmYYYY($row["fecha_nacimiento"]);
    $categoria_natural = categoria_natural(anodeFecha($row["fecha_nacimiento"]));
    $lugarnacimiento=$row["lugarnacimiento"];
    
    $notificacion2="fue procesada exitosamente.";
    $BCC="BCC:atenismiranda@gmail.com";
    
    //Datos Bancarios
    $sqlEmp="SELECT entidad,telefonos,cuenta,banco,rif,nombre,email "
            . " FROM empresa "
            . " WHERE empresa_id=$empresa_id";
    
    $resultemp=mysql_query($sqlEmp);
    $rsempresa = mysql_fetch_array($resultemp);
    if ($rsempresa) {
        $banco_empresa = $rsempresa['banco'];
        $cuenta_empresa = $rsempresa['cuenta'];
        $rif_empresa = $rsempresa['rif'];
        $nombre_empresa = $rsempresa['nombre'];
        $email_empresa = $rsempresa['email'];
        $entidad_asociacion = $rsempresa['entidad'];
        $estado_asociacion = $rsempresa['estado'];
        $telefonos_empresa = $rsempresa['telefonos'];
    } else {
        $banco_empresa ="desconocida";
        $cuenta_empresa = "desconocida";
        $rif_empresa = "desconocido";
        $email_empresa = "desconocido";
        $entidad_asociacion = 'desconocido';
        $telefonos_empresa = 'desconocido';
    }
    $fileTemplate="Template_Notificacion.html";
    switch ($tipoNotificacion){
       case "Email": //Ingreso de Email
           $asunto="Actualizacion de correo";
           $notificacion="la actualizacion de correo";
           $notificacion2="fue procesada exitosamente.";
           $fileTemplate="Template_Notificacion.html";
           break;
       case "Clave": //Modificacion de clave
           $asunto="Cambio de clave";
           $notificacion="su nueva clave es :".$row["contrasena"];
           $notificacion2=" ";
            $fileTemplate="Template_Clave.html";
           break;
       case "RecuperarClave": //Recuperacion de clave
           $asunto="Recuperacion de clave";
           $notificacion="su nueva clave es :".$row["contrasena"];
           $notificacion2=" ";
            $fileTemplate="Template_Clave.html";
           break;
       case "Afiliacion": //Afiliacion 
            $asunto="Afiliacion";
            $notificacion="La Solicitud de Afiliacion,";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="fue procesada exitosamente.\r\n";
            $notificacion2.="Nota: Recuerde realizar el pago correspondiente y enviarlo a la brevedad para formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Afiliacion.html";
            break;
        case "DesAfiliacion": //Afiliacion anual
           $asunto="DesAfiliacion";
           $notificacion="la solicitud de eliminacion de afiliacion,";
           $notificacion2="fue procesada....\r\n";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $fileTemplate="Template_Notificacion.html";
           $email=NULL;// Nulo no envia correo
           break;
       case "Pre-Afiliacion": //Afiliacion 
            $asunto="Afiliacion(Nueva)";
            $notificacion="La Solicitud de Afiliacion,";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="fue procesada exitosamente.\r\n";
            $notificacion2.="Nota: Recuerde realizar el pago correspondiente y enviarlo a la brevedad para formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Afiliacion.html";
            break;
       case "AfiliacionConfirmada": //Afiliacion confirmada
           $asunto="Pago de Afiliacion Confirmado";
           $notificacion="La Afiliacion fue confirmada.";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $notificacion2="Gracias por su pago.";
           $fileTemplate="Template_Notificacion.html";
           break;
        case "AfiliacionNoConfirmada": //Afiliacion no confirmada
            $asunto="Pago de Afiliacion no ha sido confirmado";
            $notificacion="la afiliacion no ha sido formalizada.";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="Nota: Recuerde realizar el pago correspondiente y enviarlos a la brevedad para formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Notificacion.html";
            break;
       case "PagoConfirmado": //Pago confirmado
           $asunto="Pago confirmado del Torneo: $nota";
           $notificacion="su pago para la inscripcion en el torneo $nota ha sido confirmado.";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $notificacion2=" ";
           $fileTemplate="Template_Pago.html";
           
           
           break;
        case "PagoNoConfirmado": //Afiliacion no confirmada
            $asunto="Pago no confirmado del Torneo :$nota";
            $notificacion="hasta la fecha no hemos recibido el pago correspondiente para la inscripcion en el torneo $nota.";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="Nota: Es importante realizar el pago en los lapsos establecidos.\r\n";
            $fileTemplate="Template_Notificacion.html";
           
            break;
       //Solicitud de afiliacion federacion y asociacion
       case "Afiliarme": 
            $asunto="Afiliacion";
            $notificacion="La Solicitud de Afiliacion,";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="fue procesada exitosamente.\r\n";
            $notificacion2.="Nota: Recuerde realizar el pago correspondiente y enviarlo a la brevedad para formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Afiliacion.html";
            break;
       case "DesAfiliarme": //Afiliacion anual
           $asunto="DesAfiliarme";
           $notificacion="la solicitud de eliminacion de afiliacion,";
           $notificacion2="fue procesada....\r\n";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $fileTemplate="Template_Notificacion.html";
           $email=NULL;// Nulo no envia correo
           break;
       //Notificaciones de los servicio web
       case "ServicioWeb": //Afiliacion 
            $asunto="Servicio Web";
            $notificacion="La Solicitud de servicio web,";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="fue procesada exitosamente.\r\n";
            $notificacion2.="Nota: Recuerde realizar el pago correspondiente y enviarlo para su confirmacion.\r\n";
            $fileTemplate="Template_Pago.html";
           break;
       case "DesServicioWeb": //Desafiliacion web
           $asunto="Eliminacion de servicio Web";
           $notificacion="la solicitud de retiro del servicio web,";
           $notificacion2="fue procesado....\r\n";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $fileTemplate="Template_Notificacion.html";
            $email=NULL;// Nulo no envia correo
           break;
       case "AfiliacionFormalizada": //Afiliacion confirmada
           $asunto="Pago de Afiliacion Formalizada";
           $notificacion="La Afiliacion fue formalizada.";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $notificacion2="Gracias por su pago.";
           $fileTemplate="Template_Notificacion.html";
           break;
        case "AfiliacionNoFormalizada": //Afiliacion no confirmada
            $asunto="Pago de Afiliacion no ha sido formalizada";
            $notificacion="la afiliacion no ha sido formalizada.";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="Nota: Recuerde realizar el pago correspondiente y enviarlo a la brevedad para formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Notificacion.html";
            break;
        case "ServicioWebFormalizado": 
           $asunto="Confirmacion de Afiliacion Federativa Procesada";
           $notificacion="La Confirmacion de Afiliacion Federativa fue procesada exitosamente.";
           $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
           $notificacion2="Gracias por su pago.";
           $fileTemplate="Template_Notificacion.html";
           break;
        case "ServicioWebNoFormalizado": 
            $asunto="Confirmacion de Afiliacion Federativa No Procesada";
            $notificacion="La Confirmacion de Afiliacion Federativa no fue formalizada exitosamente, comuniquese con su asociacion.\r\n";
            $BCC="BCC:atenismiranda@gmail.com,$email_empresa";
            $notificacion2="Nota: Recuerde realizar el pago correspondiente y enviarlos a la brevedad para procesar y formalizar su afiliacion.\r\n";
            $fileTemplate="Template_Notificacion.html";
            break;
       case "FICHA": 
            $asunto = "Actualizacion de Datos Basicos";
            $notificacion = "la actualizacion de datos"." "."\r\n";
            $notificacion2 = "fue registrada con Fecha :".date("d-M-Y")."\r\n\r\n";
            $notificacion2 .= "y fue actualizada exitosamente.";
            $fileTemplate="Template_Notificacion.html";
            break;
        default:
           $asunto="Ingreso al sistema";
           $notificacion="Entrada al sistema";
           $fileTemplate="Template_Notificacion.html";
           return;
    }
    
    $strMensaje="Estimado(a) atleta($estado) $nombre_atleta,$apellido_atleta, le notificamos que $notificacion "
                . "$notificacion2\r\n";
    //Obtenemos el template html
    $file_Template= file_get_contents("../Email_Template/".$fileTemplate);
       
    //Creamos los parametros para sustituir en la plantilla
    $campos=['@@OPERACION','@@SOLICITUD','@@CEDULA','@@NOMBRES','@@APELLIDOS','@@FECHANACIMIENTO','@@SEXO',
        '@@ASOCIACION','@@CATEGORIANATURAL','@@CODIGO','@@NOMBRE_TORNEO','@@ENTIDAD','@@GRADO','@@CATEGORIA','@@FECHACIERRE','@@FECHARETIRO','@@FECHAINICIO',
        '@@DISCIPLINA','@@TELEFONOS','@@BANCO','@@CUENTA','@@RIF','@@BENEFICIARIO','@@EMAIL_PAGO'];

   $valores=[$asunto,$strMensaje,$cedula,$nombre_atleta,$apellido_atleta,$fechanacimiento,$sexo,
       $estado,$categoria_natural,$codigo_torneo,$nombre_torneo,$entidad_torneo,$grado,$categoria,$fechacierre,
       $fecharetiro,$fechainicio,$disciplina,$telefonos_empresa,$banco_empresa,$cuenta_empresa_empresa,$rif_empresa,$nombre_empresa,$email_empresa];
    
    //Reemplazamos los valores de la platilla 
    $body = html_template($campos, $valores, $file_Template);
    
    $nombre_remitente='fvtenis.com.ve';
    //Enviamos Correo
    {
        $to = $email; //"robinson.carrasquero@gmail.com";
        $subject = $asunto;
        if ($atleta_id == 487) { // Prueba de usuario
            $from = "From: fvtenis.com.ve<info@fvtenis.com.ve>"
                    . "\r\n" . "BCC:atenismiranda@gmail.com";
        } else {
            $from = "From: $nombre_remitente<" . $email_from . ">"
                    . "\r\n" . "BCC:atenismiranda@gmail.com,$email_empresa";
        }
        //Enviamos correos via smtp                  
        email_smtp($to, $subject, $body, $from);
                   
    }
    return;
}

//Esta funcion indica si el usuario esta afiliado
function Control_Afiliacion_Anual($atleta_id,$ano_afiliacion) {
    //Verificamos pago de afiliacion
    $sql = "SELECT pagado FROM afiliaciones WHERE  atleta_id=$atleta_id && ano=$ano_afiliacion";
    $result = mysql_query($sql);
    $rsAfiliados = mysql_fetch_array($result);
    if ($rsAfiliados['pagado']>0){
        $habilitado= TRUE; //Habilitado para imprimir o enviar correo
    }else{
        $habilitado= FALSE; //Habilitado para imprimir o enviar correo
    }
    return $habilitado;
}

//Funcion para sustituir parametros de un campo con los valores en un string
function html_template($campos, $valores, $strDocumento) {
    $new_doc = str_replace($campos, $valores, $strDocumento, $contador);
    return $new_doc;
}

//Funcion para envio de correo via SMPT
function email_smtp($to,$subject,$body,$from){
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
    if ($to !=NULL && MODO_DE_PRUEBA==0){
        mail($to,$subject,$body,$cabeceras.$from);
    }
}