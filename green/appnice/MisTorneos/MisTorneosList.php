<?php

session_start();
require_once "../clases/Empresa_cls.php";
require_once "../clases/Torneos_cls.php";
require_once "../clases/Torneos_Inscritos_cls.php";
require_once '../funciones/funcion_fecha.php';
require_once '../clases/Encriptar_cls.php';
require_once '../funciones/Imagenes_cls.php';
require_once '../sql/ConexionPDO.php';
require_once '../clases/Bootstrap2_cls.php';
require_once '../clases/Paginacion_cls.php';
require_once '../clases/Torneo_Archivos_cls.php';

$atleta_id =Encrypter::decrypt($_POST['id']);
$pagina =  intval(substr($_POST['pagina'],4));
//sleep(1);

//Paginacion
$objPaginacion = new Paginacion(5,$pagina);
$querycount="SELECT count(*)as total FROM torneoinscritos WHERE atleta_id =$atleta_id";
$objPaginacion->setTotal_Registros($querycount);
$total_registros=$objPaginacion->getTotal_Registros();
$select="SELECT torneo.*,torneoinscritos.categoria AS LACATEGORIA FROM torneoinscritos INNER JOIN torneo ON torneo.torneo_id=torneoinscritos.torneo_id "
        . "WHERE atleta_id =$atleta_id order by torneo.fecha_inicio_torneo desc ";
$records=$objPaginacion->SelectRecords($select);
//<!--main content start-->

$strniceadmin .='<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-table"></i> Table</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-table"></i>Table</li>
              <li><i class="fa fa-th-list"></i>Basic Table</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading">
                Basic Table
              </header>
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading">
                Striped Table
              </header>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading no-border">
                Border Table
              </header>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td rowspan="2">1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@TwBootstrap</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading">
                Hover Table
              </header>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Sumon</td>
                    <td>Mosa</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading">
                Condensed table
              </header>
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Ajay Patel</td>
                    <td>LA</td>
                    <td>@ajaypatel_aj</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading">
                Contextual classes
              </header>
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Column heading</th>
                    <th>Column heading</th>
                    <th>Column heading</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="active">
                    <td>1</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="success">
                    <td>2</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="warning">
                    <td>3</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="danger">
                    <td>4</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Responsive tables
              </header>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Table heading</th>
                      <th>Table heading</th>
                      <th>Table heading</th>
                      <th>Table heading</th>
                      <th>Table heading</th>
                      <th>Table heading</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                      <td>Table cell</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </section>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Advanced Table
              </header>

              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th><i class="icon_profile"></i> Full Name</th>
                    <th><i class="icon_calendar"></i> Date</th>
                    <th><i class="icon_mail_alt"></i> Email</th>
                    <th><i class="icon_pin_alt"></i> City</th>
                    <th><i class="icon_mobile"></i> Mobile</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
                  <tr>
                    <td>Angeline Mcclain</td>
                    <td>2004-07-06</td>
                    <td>dale@chief.info</td>
                    <td>Rosser</td>
                    <td>176-026-5992</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Sung Carlson</td>
                    <td>2011-01-10</td>
                    <td>ione.gisela@high.org</td>
                    <td>Robert Lee</td>
                    <td>724-639-4784</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Bryon Osborne</td>
                    <td>2006-10-29</td>
                    <td>sol.raleigh@language.edu</td>
                    <td>York</td>
                    <td>180-456-0056</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Dalia Marquez</td>
                    <td>2011-12-15</td>
                    <td>angeline.frieda@thick.com</td>
                    <td>Alton</td>
                    <td>690-601-1922</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Selina Fitzgerald</td>
                    <td>2003-01-06</td>
                    <td>moshe.mikel@parcelpart.info</td>
                    <td>Waelder</td>
                    <td>922-810-0915</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Abraham Avery</td>
                    <td>2006-07-14</td>
                    <td>harvey.jared@pullpump.org</td>
                    <td>Harker Heights</td>
                    <td>511-175-7115</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Caren Mcdowell</td>
                    <td>2002-03-29</td>
                    <td>valeria@hookhope.org</td>
                    <td>Blackwell</td>
                    <td>970-147-5550</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Owen Bingham</td>
                    <td>2013-04-06</td>
                    <td>thomas.christopher@firstfish.info</td>
                    <td>Rule</td>
                    <td>934-118-6046</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Ahmed Dean</td>
                    <td>2008-03-19</td>
                    <td>lakesha.geri.allene@recordred.com</td>
                    <td>Darrouzett</td>
                    <td>338-081-8817</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Mario Norris</td>
                    <td>2010-02-08</td>
                    <td>mildred@hour.info</td>
                    <td>Amarillo</td>
                    <td>945-547-5302</td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="#"><i class="icon_check_alt2"></i></a>
                        <a class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>';
    
    $strTable = '<div class="col-sm-12 col-sm-8">';
   
    $strTable .='
            <div class="table"> 
            <table class="table table-striped table-responsive">

                <thead >        
                    <tr class="table-head ">
                        <th><p class="glyphicon glyphicon-dashboard"<p></th>
                        <th>Ent</th>
                        <th>Grado</th>
                        <th>Doc</th>
                        <th>LI</th>
                        <th>FS</th>
                        <th>Draw</th>
                        
                        <th>Fotos</th>
                        <th>Fecha</th>
                     </tr>
                </thead>';
                
                 //echo   $strTable ;
                           
                            
                $habilitado= $_SESSION['SWEB'];
                $nr=0;
                foreach ($records as $record) {

                    $objTorneo = new Torneo();
                    $row=$objTorneo->RecordById($record['torneo_id']);

                    if (Fecha_Apertura_Calendario($row['fechacierre'],$row['grado'] ) <= Fecha_Hoy() && Fecha_Create($row['fechacierre']) > Fecha_Hoy()) {

                             $estatus="Open";
                     } else {
                         if (Fecha_Apertura_Calendario($row['fechacierre'],$row['grado']) > Fecha_Hoy()) {

                             $estatus="Next";
                         } else {

                             if (Fecha_Fin_Torneo($row['fecha_inicio_torneo']) >= Fecha_Hoy()
                                && Fecha_ini_Torneo($row['fecha_inicio_torneo'],$row['tipo']) < Fecha_Hoy()){

                                     $estatus="Running";
                             }else {
                                 if (Fecha_Fin_Torneo($row['fecha_inicio_torneo']) < Fecha_Hoy()) {

                                     $estatus="End";
                                 }else{
                                     $estatus="Closed";
                                 }
                             }
                         }
                     }
                        if($habilitado){
                             $mostrar=TRUE;
                        }else{
                            if (Fecha_Create($row['fecha_inicio_torneo']) < Fecha_Hoy()){
                               $mostrar=TRUE;
                            }  else {
                               $mostrar=FALSE;
                            }
                        }
                        if($mostrar){
                            switch ($estatus) {
                                case 'Open':
                                    $strTable .= '<tr class="success"  >  ';

                                    $strTable .= '<td><p class="Link glyphicon glyphicon-ok"></p></td>';
                                    //echo '<td><a class=" edit-record" target="" href="../Inscripcion/bsInscripcion.php" </a>'.$estatus.'</td>';
                                    break;

                                case 'Closed':
                                    $strTable .= '<tr class=" " >';
                                    $strTable .= '<td><p class="glyphicon glyphicon-remove-sign"></p></td>';
                                    //echo '<td>'.$estatus.'</td>';
                                    break;
                                case 'Next':
                                    $strTable .= '<tr class=" edit-record" >';
                                    $strTable .= '<td ><p class="glyphicon glyphicon-eye-open"></p></td>';
                                   // echo '<td>'.$estatus.'</td>';
                                    break;
                                case 'Running':
                                   $strTable .= '<tr class="warning " >';
                                   $strTable .= '<td ><p class="glyphicon glyphicon-flag"></p></td>';
                                   //echo '<td>'.$estatus.'</td>';
                                   break;
                                default:
                                    $strTable .= '<tr class=" " >';
                                    $strTable .= '<td ><p class=" glyphicon glyphicon-ok-sign"></p></td>';
                                    //echo '<td>'.$estatus.'</td>';
                                    break;
                            }
                            $key= urlencode(Encrypter::encrypt($row['torneo_id']));
                            $hash_tid=urlencode(Encrypter::encrypt($row['torneo_id']));
                            $hash_codigo= urlencode(Encrypter::encrypt($row['codigo']));
                            $strTable .= '<td >'. $row['entidad'].'</td>';
                            $strTable .= '<td>'.$row['numero']."-".$row['tipo'].'<br>';
                            $strTable .= '<strong><mark class="badge" >'. $record['LACATEGORIA'].'</mark></strong></td>';
                            // echo '<td><a data-id="co'.$row['torneo_id'].'" href="MisConstancias.php?torneo_id='.$row['torneo_id'].'" target="_blank" class="glyphicon glyphicon-print edit-record">  </a></td>';
                            $strTable .= '<td><a data-id="co'.$row['torneo_id'].'" href="../Constancias/ConstanciaParticipacion.php?torneo_id='.$key.'" target="_blank" class="glyphicon glyphicon-print edit-record">  </a></td>';
                            
                        //Lista de Inscritos              
                        $Total_inscritos = TorneosInscritos::Count_Inscritos($row['torneo_id']);
                        if ($Total_inscritos>0){
                            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos"><a target="_blank" href="../Torneo/bsTorneos_Consulta_Atletas_Inscritos.php?t='
                            .$hash_codigo.'" class="activo-glyphicon glyphicon glyphicon-align-justify"></a></td>';
                        }else{
                            $strDatali= '<td data-toggle="tooltip" data-placement="bottom" title="Lista de Inscritos Vacia"> <a  class=" inactivo-glyphicon glyphicon glyphicon-align-justify">  </a></td>';
                        }    
                        $strTable .=$strDatali;
                        //FSheet
                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "fs");
                        if($rsTorneo_fs){
                            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet"> <a href="../Torneo/Download_Doc.php?thatid='.
                                    $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('fs')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon glyphicon-blackboard">  </a></td>';
                        }else{
                            $strDatafs= '<td data-toggle="tooltip" data-placement="bottom" title="Fact Sheet No Disponible"> <a  class="inactivo-glyphicon glyphicon glyphicon-blackboard">  </a></td>';
                        }
                        $strTable .=$strDatafs;

                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "ds");
                        $strDraw="<td>";
                        if($rsTorneo_fs){
                            $draws= '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles"><a href="../Torneo/Download_Doc.php?thatid='.
                            $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('ds')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-file">  </a></p>';
                        }else{
                            $draws = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Singles No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-file">  </a></p>';
                        }

                        $strDraw .=$draws;
                        //$strDraw .="</td>"; 
                        //$strDraw .="<td>";
                        $rsTorneo_fs = Torneo_Archivos::FindDocument($row['torneo_id'], "dd");
                        if($rsTorneo_fs){
                            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles"><a href="../Torneo/Download_Doc.php?thatid='.
                           $hash_tid.'&thatdoc='.urlencode(Encrypter::encrypt('dd')).'" target="_blank" class="activo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
                        }else{
                            $drawd = '<p data-toggle="tooltip" data-placement="bottom" title="Draw Dobles No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-duplicate">  </a></p>';
                        }   
                        $strDraw .=$drawd;
                        $strDraw .="</td>";
                        $strTable .=$strDraw;

                        //Galeria
                        $folder="../uploadFotos/torneos/".$row['torneo_id']."/";
                        $key=  $row['codigo'].",".$row['torneo_id'];
                        $ghref="../Galerias/Galeria.php?tid=".$key;
                        if(Imagenes::findGaleria($folder)){
                            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria"><a href="'.$ghref.'" target="_blank" class="activo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                        }else{
                            $strGaleria= '<td data-toggle="tooltip" data-placement="bottom" title="Galeria No Disponible"><a  class="inactivo-glyphicon glyphicon glyphicon-picture">  </a></td>';
                        }
                        $strTable .=$strGaleria;
                        $strTable .= "<td data-toggle='tooltip' data-placement='auto' title='Fecha'>"
                        . ""
                        //. "<p class='fechacierre'>Cierre: ". date_format(date_create($row['fechacierre']),"d-m-Y")."</p>"
                        //. "<p class='fecharetiro'>Retiro: ".date_format(date_create($row['fecharetiros']),"d-m-Y")."</p>"
                        . "<mark>".date_format(date_create($row['fecha_inicio_torneo']),"d-m-Y")."</mark>"
                        . ""
                        . "</td>";
                        $strTable .= '</tr>';

                        $nr++;

                        }

                }

$strTable .=
                        '   
                        </table>
                </div>';
      

        
 $strTable .=  '</div>';
 
   
  //Lado derecho
    $strTable .= '<div class="col-xs-12 col-sm-4">';
    $strTable .= '<div class="notas-left ">';

    $strTable .=  '<h5 class="alert alert-warning">'. Bootstrap_Class::texto("Mensaje:").''
            . '<br><br> Ahora puedes imprimir la constancia de participacion '
            . 'de torneo en la columna <mark>(Doc)</mark>con el icono <a class="glyphicon glyphicon-print"></a> '
            . '.</h5>';
    if ($nr>0){
    
        $strTable .= ''
                . '<h5 class="alert alert-info">'.Bootstrap_Class::texto("Mensaje:").
                "<br><br>Torneos que ha inscrito ($total_registros).</h5>"
                . '';
    }

    $strTable .= '</div>';
    $strTable .= '</div>';
$lineaOut=$strTable;
$lineaOut=$strniceadmin;

if ($nr>0){
    $jsondata = array("Success" => True, "html"=>$lineaOut,"pagination"=>$objPaginacion->Paginacion());   
} else {    
    $jsondata = array("Success" => False, "html"=>"No hay datos registrados","pagination"=>"");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);
