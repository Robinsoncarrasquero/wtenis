<?php
require_once 'funcion_fecha.php';
// require_once '../ConexionMysqli_cls.php';
require_once '../clases/Atleta_cls.php';
require_once '../clases/Empresa_cls.php';
require_once '../clases/Torneos_cls.php';
require_once '../sql/ConexionPDO.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
    
/* 
 * Utilizamos esta funcion para hacer el envion de correo de cualquier moovimiento tales 
 * como Inscripcion, eliminacion de inscripcion, retiros.
 */
function email_inscripcion($tipodeoperacion,$torneoid,$atleta_id,$categoria){
    $email_empresa= $_SESSION['email_empresa'];
    if (isset($_SESSION['email_envio'])){
        $email_from= $_SESSION['email_envio'];
    }else{
        $email_from="info@example.com";
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
    $torneo = new Torneo();
    $torneo->Fetch($torneoid);


    if ($torneo){
        $codigo_torneo=$torneo->getCodigo();
        $nombre_torneo=$torneo->getNombre();
        $empresa_id=$torneo->getEmpresa_id();
        $grado=$torneo->getTipo();
        $fechacierre=$torneo->getFechaCierre();
        $fecharetiro=$torneo->getFechaRetiros();
        $fechainicio=$torneo->getFechaInicioTorneo();
        $categoria_torneo=$torneo->getCategoria();
        $entidad_torneo=$torneo->getEntidad();
        
        $disciplina = $torneo->getModalidad;

        //Datos del Atleta
        
        $atleta = new Atleta();
        $atleta->Find($atleta_id);

        $nombre_atleta=$atleta->getNombres();
        $apellido_atleta=$atleta->getApellidos();
        $email=$atleta->getEmail();
        $estado=$atleta->getEstado();
        $sexo=$atleta->getSexo();
        $cedula=$atleta->getCedula();
        $fechanacimiento=   fecha_date_dmYYYY($atleta->getFechaNacimiento());
        $categoria_natural = categoria_natural(anodeFecha($atleta->getFechaNacimiento()));
        
        //Buscamos los datos Banciarios en la Tabla Empresa o asociacion
        //$sqlEmp="SELECT telefonos,entidad,cuenta,banco,rif,nombre,email FROM empresa WHERE empresa_id=" .$empresa_id;
        $sqlEmp="SELECT telefonos,entidad,cuenta,banco,rif,nombre,email "
                . "FROM empresa "
                . "WHERE estado='$entidad_torneo'";
        
        $rsempresa = new Empresa();
        $rsempresa->Fetch($entidad_torneo);

        if ($rsempresa){
            $banco_empresa =$rsempresa->getBanco();
            $cuenta_empresa =$rsempresa->getCuenta();
            $rif_empresa =$rsempresa->getRif();
            $nombre_empresa =$rsempresa->getNombre();
            $email_empresa=$rsempresa->getEmail();
            $telefonos_empresa=$rsempresa->getTelefonos();
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
            $nombre_remitente='mytenis';
            $email_empresa='robinson.carrasquero@gmail.com';
            $to = $email; //"robinson.carrasquero@gmail.com";
            $subject = "$movimiento al torneo:($codigo_torneo)";
            
            if ($atleta_id==487){ // Prueba de usuario
                $from = "From: mytenis<info@example>"
                    . "\r\n" ."BCC:atenismiranda@gmail.com";
            }else{
                $from = "From: $nombre_remitente<".$email_from.">" 
                    . "\r\n" ."BCC:atenismiranda@gmail.com,$email_empresa";
            }
            $from = $email_empresa;
            email_smtp($to,$subject,$body,$from);
        }
            
    }

    
    return;
}



//Utilizamos esta funcion para enviar un correo cuando se hacen modifican datos
//de correos, cambio de clave, ingreso al sitio, etc. En este caso la plantilla
//de mensaje es distinta.
function email_notificacion($tipoNotificacion,$cedulax,$nota=NULL){
    
    //Datos Atleta
    $atleta = new Atleta();
    $atleta->Find_Cedula($cedulax);
    $atleta_id=$atleta->getID();
    $nombre_atleta=$atleta->getNombres();
    $apellido_atleta=$atleta->getApellidos();
    $email=$atleta->getEmail();
    $estado=$atleta->getEstado();
    $sexo=$atleta->getSexo();
    $cedula=$atleta->getCedula();
    $fechanacimiento=   fecha_date_dmYYYY($atleta->getFechaNacimiento());
    $categoria_natural = categoria_natural(anodeFecha($atleta->getFechaNacimiento()));
    $lugarnacimiento=$atleta->getLugarNacimiento();
    $disciplina=$atleta->getDisciplina();
    
    //Datos Empresa
    $rsempresa = new Empresa();
    $rsempresa->Fetch($atleta->getEstado());
    
    if ($rsempresa){
        $empresa_id= $rsempresa->get_Empresa_id();
        $banco_empresa =$rsempresa->getBanco();
        $cuenta_empresa =$rsempresa->getCuenta();
        $rif_empresa =$rsempresa->getRif();
        $nombre_empresa =$rsempresa->getNombre();
        $email_empresa=$rsempresa->getEmail();
        $telefonos_empresa=$rsempresa->getTelefonos() ? $rsempresa->getTelefonos() : "XXX-XXX-XX-XX" ;
        $email_from= $rsempresa->getEmail_Envio();
        $estado=$rsempresa->getEstado();
    }else{
        $banco_empresa ="desconocido";
        $cuenta_empresa ="desconocida";
        $rif_empresa ="desconocido";
        $nombre_pago ="desconocida";
        $email_empresa="desconocido";
        $telefonos_empresa='desconocido';
        $email_from="info@example.com";
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
           $notificacion="su nueva clave es :".$atleta->getContrasena();
           $notificacion2=" ";
            $fileTemplate="Template_Clave.html";
           break;
       case "RecuperarClave": //Recuperacion de clave
           $asunto="Recuperacion de clave";
           $notificacion="su nueva clave es :".$atleta->getContrasena();
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
    $file_dir=__DIR__."/../Email_Template/".$fileTemplate; 
    $file_Template= file_get_contents($file_dir);
    //Creamos los parametros para sustituir en la plantilla
    $campos=['@@OPERACION','@@SOLICITUD','@@CEDULA','@@NOMBRES','@@APELLIDOS','@@FECHANACIMIENTO','@@SEXO',
        '@@ASOCIACION','@@CATEGORIANATURAL',
        '@@DISCIPLINA','@@TELEFONOS','@@BANCO','@@CUENTA','@@RIF','@@BENEFICIARIO',
        '@@EMAIL_PAGO'];

   $valores=[$asunto,$strMensaje,$cedula,$nombre_atleta,$apellido_atleta,$fechanacimiento,$sexo,
       $estado,$categoria_natural,
       $disciplina,$telefonos_empresa,$banco_empresa,$cuenta_empresa,$rif_empresa,$nombre_empresa,
       $email_empresa];
    
    //Reemplazamos los valores de la platilla 
    $body = html_template($campos, $valores, $file_Template);
    // $DIR=__DIR__;
    // $FILE=__FILE__;
    // $DROOT=$_SERVER['DOCUMENT_ROOT'];        
    // $jsondata = array("Success" => TRUE, "msg"=>$FILE ."FILE ".$DROOT . "DROOT ". $DIR. " DIR ","html"=>json_encode($body, JSON_FORCE_OBJECT));
    // header('Content-type: application/json; charset=utf-8');
    // echo json_encode($jsondata, JSON_FORCE_OBJECT);
    //var_dump($body);
    $nombre_remitente='FVT';
    $email_empresa='rcarrasquero@gmail.com';
    $email_from ='atenimiranda@gmail.com';
    //Enviamos Correo
    {
        $to = $email; //"robinson.carrasquero@gmail.com";
        $subject = $asunto;
        if ($atleta_id == 487) { // Prueba de usuario
            $from = "From: mytenis<$email_from>"
                    . "\r\n" . "BCC:robinson.carrasquero@gmail.com";
        } else {
            $from = "From: $nombre_remitente<" . $email_from . ">"
                    . "\r\n" . "BCC:atenismiranda@gmail.com,$email_empresa";
        }
        $from = $email_from;
        //Enviamos correos via smtp                  
        email_smtp($to, $subject, $body, $from);
                   
    }
    return;
}

//Esta funcion indica si el usuario esta afiliado
function Control_Afiliacion_Anual($atleta_id,$ano_afiliacion) {
    //Verificamos pago de afiliacion
    $sql = "SELECT pagado FROM afiliaciones WHERE  atleta_id=$atleta_id && ano=$ano_afiliacion";
    $result = Conexion_mysqli::mysqli_query($sql);
    $rsAfiliados =Conexion_mysqli::mysqli_fetch_array($result);
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
    //$cabeceras = 'X-Mailer: PHP/' . phpversion();
    if ($to !=''){
        envphpmailer($to,$subject,$body,$from);
    // }else{
    //     mail($to,$subject,$body,$cabeceras.$from);
    }
 
}


function envphpmailer($to,$subject,$body,$from)
{

    $Configuracion = new Configuracion();
    $SMTP = $Configuracion->SMTP();
    

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $SMTP['SMTP_HOST'];                    //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $SMTP['SMTP_USERNAME'];                    //SMTP username
        $mail->Password   = $SMTP['SMTP_PASSWORD'];                            //SMTP password
        $mail->SMTPSecure = $SMTP['SMTP_SECURE'];;            //Enable implicit TLS encryption
        $mail->Port       = $SMTP['SMTP_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($from, 'Sistemas ');
        $mail->addAddress($to, 'Afiliado');     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(false);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;//'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = $body;//'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        return  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

