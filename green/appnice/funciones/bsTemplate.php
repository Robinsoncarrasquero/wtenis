<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class bsTemplate
{
    public static function header($title,$user_name,$url='http://gss.com.ve/',$keyword=null,$descripcion=null){
        if ($descripcion==null){
            $descripcion='Asociaciones - Sistema Web de Torneos de Tenis con Inscripciones OnLine';
        }
        if ($keyword==null){
            $keyword="Sistema de Inscripciones, Torneos, Asociaciones, Tenis, Juegos, Senior, Juvenil, Junior";
        }
        $str_header=
        '
        <!DOCTYPE html>
            <html lang="en">

            <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
             
            <meta name="author" content="MyTenis">
            <meta name="description" content="'.$descripcion.'" />
            <meta name="robots" content="index,follow,max-snippet:-1,max-video-preview:-1,max-image-preview:large"/>
            <link rel="canonical" href="'.$url.'" />
            <meta name="keyword" content="'.$keyword.'">
            <link rel="shortcut icon" href="img/favicon.png">
            <title>'.$title.'</title>
            <link href="../css/mmaster_page.css" rel="stylesheet">

            <!-- Bootstrap CSS -->
            <link href="../bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
            <!-- bootstrap theme -->
            <link href="../bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">
            <!--external css-->
            <!-- font icon -->
            <link href="../niceadmin/css/elegant-icons-style.css" rel="stylesheet" />
            <link href="../niceadmin/css/font-awesome.min.css" rel="stylesheet" />
            <!-- full calendar css-->
            <!-- Custom styles -->
            <link href="../niceadmin/css/style.css" rel="stylesheet">
            <link href="../niceadmin/css/style-responsive.css" rel="stylesheet" />
            
            <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
            <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>
                <script src="js/respond.min.js"></script>
                <script src="js/lte-ie7.js"></script>
                <![endif]-->

                <!-- =======================================================
                Theme Name: NiceAdmin
                Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
                Author: BootstrapMade
                Author URL: https://bootstrapmade.com
                ======================================================= -->


                <!-- Bootstrap SWEETALERT-->
                <!-- <link href="../../sweetalert/css/bootstrap.min.css" rel="stylesheet"> -->
                <!-- Custom CSS -->
                <link href="../../sweetalert/css/main.css" rel="stylesheet">
                <!-- Scroll Menu -->
                <link href="../../sweetalert/css/sweetalert.css" rel="stylesheet">

                <!-- jQuery (necessary for Bootstrap JavaScript plugins) -->
                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <!-- <script src="../../sweetalert/js/bootstrap.min.js"></script> -->

                <!-- Custom functions file -->
                <script src="../../sweetalert/js/functions.js"></script>
                <!-- Sweet Alert Script -->
                <script src="../../sweetalert/js/sweetalert.min.js"></script>
                
                <style type="text/css">
                
                
                @media (min-width:600px)  { 
                /* portrait tablets, portrait iPad, e-readers (Nook/Kindle), landscape 800x480 phones (Android) */ 
                body, table{
                    width: 60%;
                }
                @media (min-width:801px)  { 
                /* tablet, landscape iPad, lo-res laptops ands desktops */ 
                body,table{
                    width: 80%;
                }
                @media (min-width:1025px) { 
                /* big landscape tablets, laptops, and desktops */ 
                body,table{
                    width: 90%;
                }
                @media (min-width:1281px) { 
                /* hi-res laptops and desktops */ 
                body{
                    //padding-right: 1em;
                    width: 100%;
                
                }
            </style> 
          
                
            </head>

            <body  >
            <!-- container section start -->
            <section id="container" class="">
                <!--header start-->
                <header class="header dark-bg">
                <div class="toggle-nav">
                    <div class="icon-reorder tooltips" xdata-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
                </div>

                <!--logo start-->
                <a href="#" class="logo">On <span class="lite">Line</span></a>
                <!--logo end-->
                <!--  search form start -->

                <!--
                <div class="nav search-row" id="top_menu">
                
                    <ul class="nav top-menu">
                    <li>
                        <form class="navbar-form">
                        <input class="form-control" placeholder="Search" type="text">
                        </form>
                    </li>
                    </ul>
                </div>
                 -->
                <!--  search form end -->
                <div class="top-nav notification-row">
                ';
                   
                    // Task Notificacion 
                    $str_header .= bsTemplate::task_notificacion_perfil();
                    
                    // Inbox Notificacion 
                    $str_header .= bsTemplate::inbox_notificacion_perfil();
                    
                    // Alert Notificacion
                    $str_header .= bsTemplate::alert_notificacion_perfil();
                    
                    //Perfil User
                    $str_header .= bsTemplate::perfil($user_name);
        
                    $str_header .='
                
                </div>
                </header>
                <!--header end-->
        ';
            
        return $str_header;
    }
 
    //El contenido principal
    public static function main_content($titulo_menu,$array_breadcrum) {
    
    $html= 
    '     
     <section class="wrapper">
         <div class="row">
           <div class="col-md-12">
             <h3 class="page-header"><i class="fa fa-table"></i> '.$titulo_menu.'</h3>
             <ol class="breadcrumb">
               <li><i class="fa fa-home"></i><a href="../MisTorneos/MisTorneos.php">Home</a></li>';
                $i=0;
                foreach ($array_breadcrum as $key=>$value) {
                    
                    // {
                    //     $html .='<li><i class="'.($i==0 ? $value['icono']: ' ').'"></i><a href="'.$value['href'].'">'.$value['opcion'].'</a></li>';    
                    //     $i++;
                    // }
                    
                }
                if (count($array_breadcrum)>0){
                //    $html .='<li><i class="glyphicon glyphicon-calendar></i><span class="glyphicon glyphicon-chevron"></span></li>';    

                }
                
            
            $html .='
            </ol>
           </div>
         </div>';
         return $html;
         
    }
    //Barra lateral
    public static function aside(){
        $str_aside=
        '
        <!--sidebar start-->
        <aside >
            <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
            <li>
                <a class="" href="../MisTorneos/MisTorneos.php">
                                <i class="icon_house_alt"></i>
                                Home
                            </a>
                </li>
                <li class="sub-menu">
                <a href="javascript:;" class=""> 
                                <i class="icon_document_alt"></i>
                                <span>Inscripcion</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                <ul class="sub">
                    <li><a class="" href="../Inscripcion/Inscripcion.php">Inscripcion</a></li>
                    <li><a class="" href="../Inscripcion/Inscripcion_Retiros.php">Retiros</a></li>
                </ul>
                </li>
                <li class="sub-menu">
                <a href="javascript:;" class="">
                                <i class="glyphicon glyphicon-road"></i>
                                <span>Afiliacion</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                <ul class="sub">
                    <li><a class="" href="../Afiliacion/AfiliacionWebAfiliacion.php">Actual</a></li>
                    <li><a class="" href="../Afiliacion/AfiliacionWebServicio.php">Realizadas</a></li>
                </ul>
                </li>

                <li>
                <a class="" href="../ARankingNacional/RankingByAtleta2.php">
                                <i class="icon_genius"></i>
                                <span>Ranking</span>
                            </a>
                </li>
                <li>
                
                <li>
                <a class="" href="../Perfil/ChangeKey.php">
                                <i class="icon_key"></i>
                                <span>Cambio de Clave</span>
                            </a>
                </li>
                
                <li>
                <a class="" href="../Perfil/ChangeEmail.php">
                                <i class="glyphicon glyphicon-envelope"></i>
                                <span>Cambio de Email</span>
                            </a>
                </li>

                <li>
                <a class="" href="../Ficha/FichaDatosBasicos2.php">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Ficha</span>
                            </a>
                </li>
                <li>
                <a class="" href="../Logout.php">
                                <i class="icon_lock"></i>
                                <span>Log Out</span>
                            </a>
                </li>
                
                <!--
                <li>
                <li class="sub-menu">
                <a href="javascript:;" class="">
                                <i class="icon_desktop"></i>
                                <span>Mis Fitures</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                <ul class="sub">
                    <li><a class="" href="general.html">Components</a></li>
                    <li><a class="" href="buttons.html">Buttons</a></li>
                    <li><a class="" href="grids.html">Grids</a></li>
                </ul>
                </li>
                
                <li>
                <a class="" href="widgets.html">
                                <i class="icon_genius"></i>
                                <span>Widgets</span>
                            </a>
                </li>
                <li>
                <a class="" href="chart-chartjs.html">
                                <i class="icon_piechart"></i>
                                <span>Charts</span>

                            </a>

                </li>

                <li class="sub-menu">
                <a href="javascript:;" class="">
                                <i class="icon_table"></i>
                                <span>Tables</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                <ul class="sub">
                    <li><a class="active" href="basic_table.html">Basic Table</a></li>
                </ul>
                </li>

                <li class="sub-menu">
                <a href="javascript:;" class="">
                                <i class="icon_documents_alt"></i>
                                <span>Pages</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                <ul class="sub">
                    <li><a class="" href="profile.html">Profile</a></li>
                    <li><a class="" href="login.html"><span>Login Page</span></a></li>
                    <li><a class="" href="contact.html"><span>Contact Page</span></a></li>
                    <li><a class="" href="blank.html">Blank Page</a></li>
                    <li><a class="" href="404.html">404 Error</a></li>
                </ul>
                </li>
                -->
            </ul>
            <!-- sidebar menu end-->
            </div>
        </aside>
        <!--main content start-->
        <section id="main-content">
        <div class="col-xs-12">';

  
        return $str_aside;
    }
    
    //Encabezado de la tabla con las opciones e iconos
    public static function table_head($titulo_thead,$array_thead){
        $html= '
        <!-- page start-->
         <div class="row">
           <div class="col-xs-12">
             <section class="panel">
               <header class="panel-heading">
                '.$titulo_thead.'
               </header>
 
                <table class="table table-responsive table-advance ">
                 <tbody>
                    <tr class="small ">';
                        foreach ($array_thead as $key=>$value) {
                            if ($key==null){
                                $html .='<th><span class="'.$value.'"></span>.</th>';    
                            }else{
                                $html .='<th><i class="'.$value.'"></i> '. $key.'</th>';
                            }
                            
                        }
                        
                    $html .='
                    </tr>';
                
                    return $html;
    }

    //Pie de la pagina
    public static function footer(){

        $str_footer=
        '
        </div>
        </section>
        <!--main content end-->

            <div class="text-right">
                <div class="credits">
                    <!--
                    All the links in the footer should remain intact.
                    You can delete the links only if you purchased the pro version.
                    Licensing information: https://bootstrapmade.com/license/
                    Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    -->
                    
                </div>
                
            </div>
            
        </section>
        <!-- container section end -->
        <!-- javascripts -->
        
        <script src="../niceadmin/js/jquery.js"></script> 
        <script src="../niceadmin/js/bootstrap.min.js"></script> 
        <!--<script src="../jquery/3.1.1/jquery.min.js"></script> -->
        <!--<script src="../bootstrap/3.3.7/js/bootstrap.min.js"></script> --> 
        <script src="../niceadmin/js/jquery.scrollTo.min.js"></script>
        <script src="../niceadmin/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="../niceadmin/js/scripts.js"></script>
  
        ';
        return $str_footer;
    }

    
    public static function icono_estatus_torneo($estatus='Open'){
        switch ($estatus) {
            case 'Open':
                return "Link glyphicon glyphicon-ok";
                break;
            case 'Closed':
                return "glyphicon glyphicon-remove-sign";
                break;
            case 'Next':
                return "glyphicon glyphicon-eye-open";
                break;
            case 'Running':
                return "glyphicon glyphicon-flag";
                break;
            default:
                return " glyphicon glyphicon-ok-sign";
                break;
        }

    
    } 
    
    //Alertas con panel 
    public static function panel($titulo_header,$texto,$class='alert alert-warning',$column='col-lg-12'){
        
        return "
        <div class='$column'>
           <section class='panel'>
                <header class='panel-heading'>
                  $titulo_header
                </header>
               <div class='panel-body'>
                   <p class='small $class'>$texto
                   </p>
               </div>
           </section>
       </div>";
    }
    
    //Alertas de texto
    public static function panel_texto($titulo_header,$texto,$class='alert alert-warning',$column='col-lg-12'){
        
        return "
        <div class='$column'>
            <div class='panel'>
                <header class='panel-heading'>
                  $titulo_header
                </header>
               <div class='xpanel-body'>
                   <p class='$class'>$texto
                   </p>
               </div>
            </div>
           
       </div>";
    }
   
    
        function redes_meta(){
        $meta='
        <!-- Optimización para motores de búsqueda de Rank Math - https://s.rankmath.com/home -->
        <title>Noticias - MyTenis</title>
        <meta name="robots" content="index,follow,max-snippet:-1,max-video-preview:-1,max-image-preview:large"/>
        <link rel="canonical" href="http://mytenis/noticias/" />
        <meta property="og:locale" content="es_ES">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Noticias - MyTenis">
        <meta property="og:description" content="En un gran acto y con una buena concurrencia de la Máxima Autoridad de la FVT, su Asamblea General, se celebro el pasado sabado 08/02 las elecciones de las nuevas autoridades de la FVT: Junta Directiva, Consejo Contralor y Consejo de Honor; las cuales tendrán la responsabilidad de culminar el periodo 2017-2021.">
        <meta property="og:url" content="https://MyTenis.org/noticias/">
        <meta property="og:site_name" content="MyTenis">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Noticias - MyTenis">
        <meta name="twitter:description" content="En un gran acto y con una buena concurrencia de la Máxima Autoridad de la FVT, su Asamblea General, se celebro el pasado sabado 08/02 las elecciones de las nuevas autoridades de la FVT: Junta Directiva, Consejo Contralor y Consejo de Honor; las cuales tendrán la responsabilidad de culminar el periodo 2017-2021.">
        ';
    }
    
    // <!-- Search Engine -->
    // <meta name="description" content="DESCRIPCIÓN DEL ARTÍCULO, MÁXIMO 155 CARACTERES">
    // <meta name="image" content="LINK A LA IMAGEN DEL ARTÍCULO, DEBE TENER UN TAMAÑO DE 705 PÍXELES POR 368 PÍXELES">
    // <!-- Schema.org for Google -->
    // <meta itemprop="name" content="TÍTULO DEL ARTÍCULO">
    // <meta itemprop="description" content="DESCRIPCIÓN DEL ARTÍCULO, MÁXIMO 155 CARACTERES">
    // <meta itemprop="image" content="LINK A LA IMAGEN DEL ARTÍCULO">
    function google_meta_pagina($titulo,$descripcion,$keyword,$url='http://mytenis'){
    $gmeta=
    '
        <meta name="description" content="'.$descripcion.'" />
        <title>'.$titulo.'</title>	
        <meta name="robots" content="index,follow,max-snippet:-1,max-video-preview:-1,max-image-preview:large"/>
        <link rel="canonical" href="'.$url.'" />
        <meta name="keyword" content=".'.$keyword.'">
    
    ';
    return $gmeta;

    }
    //Tareas de Notificacion
    public static function task_notificacion_perfil(){
        
        $rsTorneos= Torneo::Torneos_Open();
        $array_notificacion=[];
        foreach ($rsTorneos as $trecord)
        {
            $date = date_create();
            $fecha_actual = date_format($date, 'Y-m-d H:i:s');
                
            {
                // $array_hora_minutos=Torneo::horas_minutos($trecord['fechacierre']); 
                 
                // if ($array_hora_minutos['horas']<1){
                //     $tiempo_resta =['time_titulo'=>'mins','time'=>$array_hora_minutos['minutos']];
                // }else{
                //     if ($array_hora_minutos['minutos']>0){
                //         $tiempo_resta =['time_titulo'=>'hr','time'=>$array_hora_minutos['horas'].":".$array_hora_minutos['minutos']];
                //     }else{
                //         $tiempo_resta =['time_titulo'=>'hr','time'=>$array_hora_minutos['horas']];
                //     } 
                // }
                $diff=Torneo::diff_fecha($trecord['fecharetiros']); 
                $hours=Torneo::intervalo_fecha($diff,'hours'); 
                $days = $diff->format('%a');
                $mins = $diff->format('%I');
                if ($hours<25){
                    $tiempo_resta =['time_titulo'=>'mins','time'=>$hours/3600];
                }else{
                    $tiempo_resta =['time_titulo'=>'days','time'=>$days];
                }

                $fecha_unix =Torneo::Fecha_Apertura_Calendario($trecord['fechacierre'],$trecord['tipo']);
                $fecha_inicio=Torneo::fecha_string($fecha_unix);
                $totaltime =Torneo::horas_entre_fechas($fecha_inicio,$trecord['fechacierre']);
                $restatime =Torneo::horas_entre_fechas($fecha_inicio,$fecha_actual);
                
                $objTorneo_Inscritos= new TorneosInscritos();
                $objTorneo_Inscritos->Find_Atleta($trecord["torneo_id"],$_SESSION['atleta_id']);
                if ($objTorneo_Inscritos->Operacion_Exitosa()){
                    
                    $array_data=
                    [
                        'numero'=>$trecord['numero'],
                        'categoria'=>$objTorneo_Inscritos->getCategoria(),
                        'grado'=>$trecord['tipo'],
                        'entidad'=>$trecord['entidad'],
                        'nombre'=>$trecord['nombre'],
                        'time_titulo'=>$tiempo_resta['time_titulo'],
                        'time_time'=>$tiempo_resta['time'],
                        'estatus'=>$objTorneo_Inscritos->getEstatus(),
                        'restatime'=>$restatime,
                        'totaltime'=>$totaltime,
                        'consumido'=> round($restatime / $totaltime * 100,2)
                        
                    ];
                    array_push($array_notificacion,$array_data);
                } 
            }
             
        }
        $html ='
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

        <!-- task notificatoin start -->
        <li id="task_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-task-l"></i>
                <span class="badge bg-important">'. count($array_notificacion) .' </span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
            <div class="notify-arrow notify-arrow-blue"></div>
            <li>
                <p class="blue">You have '.count($array_notificacion).' pending Tournaments</p>
            </li>';

            foreach ($array_notificacion as $record)
                {
                    if ($record['consumido']>0){
                        $progressbar='progress progress-striped active';
                        $progressbaralert= 'progress-bar progress-bar-success ';
                        $progressmensaje= 'Abierto ';
                    }
                    if ($record['consumido']>90){
                        $progressbar='progress progress-striped active';
                        $progressbaralert= 'progress-bar progress-bar-info ';
                        $progressmensaje= 'Cerrando ';
                    }
            
                    $html .='
                    <li>
                        <a href="../Inscripcion/Inscripcion.php">
                        <div class="task-info">
                            <div class="desc ">'.$record['numero']."-".$record['grado']."-".$record['categoria']."-".$record['entidad']. ' cerrando en: '.$record['time_time']." ".$record['time_titulo'].' </div>
                            <!--<div class="percent">'.$record['consumido'].'%</div> -->
                        </div>
                        <div class="'.$progressbar.'">
                            <div class="'.$progressbaralert.'" role="progressbar" aria-valuenow="'.$record['consumido'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$record['consumido'].'%">
                            <!-- <span class="sr-only">'.$record['consumido'].'% Complete (success)</span> -->
                            </div>
                        </div>
                        </a>
                    </li>';
            }

            $html .=
            '
            <!--<li class="external">
                <a href="#">See All Tasks</a>
            </li> -->
            </ul>
        </li>
        <!-- task notificatoin end -->
        ';
        return $html;

    }

    //Inbox notificacion perfi
    public static function inbox_notificacion_perfil(){
       return;
        $html ='
        <!-- inbox notificatoin start-->
        <li id="mail_notificatoin_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope-l"></i>
                            <span class="badge bg-important">5</span>
                        </a>
            <ul class="dropdown-menu extended inbox">
            <div class="notify-arrow notify-arrow-blue"></div>
            <li>
                <p class="blue">You have 5 new messages</p>
            </li>
            <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Greg  Martin</span>
                                    <span class="time">1 min</span>
                                    </span>
                                    <span class="message">
                                        I really like this admin panel.
                                    </span>
                                </a>
            </li>
            <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini2.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Bob   Mckenzie</span>
                                    <span class="time">5 mins</span>
                                    </span>
                                    <span class="message">
                                    Hi, What is next project plan?
                                    </span>
                                </a>
            </li>
            <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini3.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Phillip   Park</span>
                                    <span class="time">2 hrs</span>
                                    </span>
                                    <span class="message">
                                        I am like to buy this Admin Template.
                                    </span>
                                </a>
            </li>
            <li>
                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini4.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Ray   Munoz</span>
                                    <span class="time">1 day</span>
                                    </span>
                                    <span class="message">
                                        Icon fonts are great.
                                    </span>
                                </a>
            </li>
            <li>
                <a href="#">See all messages</a>
            </li>
            </ul>
        </li>
        <!-- inbox notificatoin end -->
        ';

        return $html;

    }

    //Notificacion los retiros con 24 horas de de perfil de la pagina con los retiros
    public static function alert_notificacion_perfil(){
    
        $rsTorneos= Torneo::Torneos_Retiro();
        $array_notificacion=[];
        foreach ($rsTorneos as $record)
        {
            $date = date_create();
            $fecha_actual = date_format($date, 'Y-m-d H:i:s');
            
            {
                $diff=Torneo::diff_fecha($record['fecharetiros']); 
                $hours=Torneo::intervalo_fecha($diff,'hours'); 
                $days = $diff->format('%a');
                $mins = $diff->format('%I');
                if ($hours<24){
                    $tiempo_resta =['time_titulo'=>'mins','time'=>$hours/3600];
                }else{
                    $tiempo_resta =['time_titulo'=>'days','time'=>$days];
                }
                $objTorneo_Inscritos= new TorneosInscritos();
                $objTorneo_Inscritos->Find_Atleta($record["torneo_id"],$_SESSION['atleta_id']);
                if ($objTorneo_Inscritos->Operacion_Exitosa()){
                    $array_data=
                    [
                        'numero'=>$record['numero'],
                        'categoria'=>$objTorneo_Inscritos->getCategoria(),
                        'grado'=>$record['tipo'],
                        'entidad'=>$record['entidad'],
                        'nombre'=>$record['nombre'],
                        'time_titulo'=>$tiempo_resta['time_titulo'],
                        'time_time'=>$tiempo_resta['time'],
                        'estatus'=>$objTorneo_Inscritos->getEstatus(),
    
                    ];
                    array_push($array_notificacion,$array_data);
                } 
            }
             
        }    
        $html='
              
        <!-- alert notification start-->
                    <li id="alert_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                                        <i class="icon-bell-l"></i>
                                        <span class="badge bg-important">'.count($array_notificacion).' </span>
                                    </a>
                        <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-blue"></div>
                        <li>
                            <p class="blue">You have '.count($array_notificacion).' new notifications</p>
                        </li>';
                        foreach ($array_notificacion as $record)
                        {
                            if ($record['estatus']=='Retiro'){
                                $html .='    
                                <li>
                                <a href="../Inscripcion/Inscripcion_Retiros.php">
                                    <span class="small label label-success"><i class="glyphicon glyphicon-thumbs-down"></i></span>
                                    Retiros '. $record['numero']."-".$record['grado']."-".$record['categoria']."-".$record['entidad'].'
                                    <span class="small italic pull-right">'.$record['time_time'].' '.$record['time_titulo'].' </span>
                                    </a>
                                </li>
                                ';
                            }else{
                                $html .='    
                                <li>
                                    <a href="../Inscripcion/Inscripcion_Retiros.php">
                                    <span class="small label label-warning"><i class="glyphicon glyphicon-minus"></i></span>
                                    Retiros '. $record['numero']."-".$record['grado']."-".$record['categoria']."-".$record['entidad'].'
                                    <span class="small italic pull-right">'.$record['time_time'].' '.$record['time_titulo'].' </span>
                                    </a>
                                </li>
                                ';    
                            }
                        
                        }
                        $html .=
                        '<!--<li>
                            <a href="#">
                            <span class="label label-primary"><i class="icon_profile"></i></span>
                                                John location.
                                                <span class="small italic pull-right">50 mins</span>
                                            </a>
                        </li>
                        <li>
                            <a href="#">
                                                <span class="label label-danger"><i class="icon_book_alt"></i></span>
                                                Project 3 Completed.
                                                <span class="small italic pull-right">1 hr</span>
                                            </a>
                        </li>
                        <li>
                            <a href="#">
                                                <span class="label label-success"><i class="icon_like"></i></span>
                                                Mick appreciated your work.
                                                <span class="small italic pull-right"> Today</span>
                                            </a>
                        </li> 
                        <li>
                            <a href="#">See all notifications</a>
                        </li>-->
                        </ul>
                    </li>
                    <!-- alert notification end-->
                    ';
                    return $html;
    }
    //Perfil de usuario
    public static function perfil($user_name){
        if ($_SESSION['sexo']=="F"){
            $avatar= '<img alt="" src="../uploadFotos/perfil/femalemini.jpg">';
        }else{
            $avatar= '<img alt="" src="../uploadFotos/perfil/malemini.jpg">';
       
        }

        
        $html ='
        <!-- user login dropdown start-->
        <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">'. $avatar.'
                                <!-- <img alt="" src="../niceadmin/img/avatar1_small.jpg"> -->
                            </span>
                            <span class="username">'.strtolower($user_name).'</span>
                            <b class="caret"></b>
                        </a>
            <ul class="dropdown-menu extended logout">
            <div class="log-arrow-up"></div>
            <li class="eborder-top">
                <a href="../Ficha/FichaDatosBasicos2.php"><i class="icon_profile"></i> Mi Perfil</a>
            </li>
            <!--
            <li>
                <a href="#"><i class="icon_mail_alt"></i> My Inbox</a>
            </li>
            <li>
                <a href="#"><i class="icon_clock_alt"></i> Timeline</a>
            </li>
            <li>
                <a href="#"><i class="icon_chat_alt"></i> Chats</a>
            </li> 
            -->
            <li>
                <a href="../Logout.php"><i class="icon_key_alt"></i> Log Out</a>
            </li>
            
            </ul>
        </li>
        <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->';
        return $html;
    }

    public static function mensajes_notas($titulo,$class_titulo_alert="text-success",$texto,$class_texto_alert="text-success",$class_div_container="alert-default") {
        $salida="<div class='alert $class_div_container'>";
        $salida .= "<h3 class='text $class_titulo_alert'>".$titulo."<br>";

        $salida .=  "<h4 class='text text-primary'>".trim($texto)."</h4></h3>";
        $salida .="</div>";
        
        echo $salida;
    }
    public static function mensajes_panel($titulo,$texto,$class_panel_alert="panel-default",$class_texto_alert="text-info") {
        $salida = "<div class='panel $class_panel_alert'>";
        $salida .= '<div class="panel-heading"><h3>'.$titulo."</h3></div>";
        //echo "<h3 class='panel-body $class_texto_alert '>".$texto."</h3>";
                    
        $salida .= '<div class="panel-footer  '.$class_texto_alert.'"><h4>'.$texto.'</h4></div>';
                
        $salida .= '</div>';
        return $salida;
    }
    public static function mensaje_alerta($tipo_mensaje,$mensaje,$alert="alert alert-success",$column='col-lg-12') {
        $texto= "<div class='$column'>
                    <p class='$alert'><strong>$tipo_mensaje : </strong> $mensaje</p>
                </div>";
        return $texto;
    }
    
    public function color_option($option) {
        switch ($option) {
            case "default":
                $option= "default";
                break;
            case "primary":
                $option= "primary";
                break;
            case "success":
                $option= "success";
                break;
            case "info":
                $option= "info";
                break;
            case "warning":
                $option= "warning";
                break;
            case "danger":
                $option= "danger";
                break;
            default:
                $option=" ";
                
                break;
        }
        return '<span class="label label-success">'.$option.'</span>';

    }

    public static function label($Titulo,$options="default") {
        return '<span class="label label-'.$options.' ">'.$Titulo.'</span>';
    }

    public static function span($Titulo,$options="default") {
        return '<span class="label label-'.$options.' ">'.$Titulo.'</span>';
    }

    //User
    public static function icon_glyphicon_user(){
        return ' glyphicon glyphicon-user';
    }

    //Document List
    public static function icon_glyphicon_list(){
        return ' glyphicon glyphicon-list';
    }

    //Calendario
    public static function icon_glyphicon_calendar(){
        return ' glyphicon glyphicon-calendar';
    }
    //Engranaje
    public static function icon_glyphicon_cog(){
        return ' glyphicon glyphicon-cog';
    }

    //Informacion
    public static function icon_glyphicon_info_sign(){
        return ' glyphicon glyphicon-info-sign';
    }
    //Reloj de Time
    public static function icon_glyphicon_time(){
        return ' glyphicon glyphicon-time';
    }
    //Moneda Dolar
    public static function icon_glyphicon_usd(){
        return ' glyphicon glyphicon-usd';
    }
    //Moneda Euro
    public static function icon_glyphicon_eur(){
        return ' glyphicon glyphicon-eur';
    }
    //Certificacion
    public static function icon_glyphicon_certificate(){
        return ' glyphicon glyphicon-certificate';
    }
    //Como una cancha o carretera
    public static function icon_glyphicon_road(){
        return ' glyphicon glyphicon-road';
    }
    //Estrella
    public static function icon_glyphicon_star(){
        return ' glyphicon glyphicon-star';
    }
    //check Ok
    public static function icon_glyphicon_ok(){
        return ' glyphicon glyphicon-ok';
    }
    //Procesando
    public static function icon_glyphicon_transfer()
    {
        return ' glyphicon glyphicon-transfer';
    }
    //Email
    public static function icon_glyphicon_envelope()
    {
        return ' glyphicon glyphicon-envelope';
    }


    
}