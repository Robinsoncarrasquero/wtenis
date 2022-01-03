<?php
    require_once 'appnice/clases/Atleta_cls.php';
    require_once 'appnice/clases/Ranking_cls.php';
    require_once 'appnice/clases/Ranking_detalle_cls.php';
    require_once 'appnice/clases/Ranking_detalle_codigo_cls.php';
    
    require_once 'appnice/sql/ConexionPDO.php';

    $ranking_id= htmlspecialchars($_GET['ranking']);

    $ranking = new Ranking();
    $ranking->Fetch($ranking_id);
    if ($ranking){
        $atleta = new Atleta();

        $atleta->Fetch($ranking->getAtleta_id());
       
    }else{
        echo 'ERROOR DATA NO ES VALIDA';
        exit;
    }
    
    
    $strTable =
'


            <table class="table table-condensed  table-striped  table-responsive">
                <thead >
                    <tr class="rank-title">
                        <th>#</th>
                        <th>Torneo</th>
                        <th>Puntos</th>
                        <th>Base</th>
                        <th>Total</th>
                        <th>*</th>
                        
                     </tr>
                </thead>
                <tbody>';
                $nr=0;
                $np=0;
                $rsRankingDet=RankingDetalle::ReadByRanking($ranking_id);
                $RankingDetalleCodigo = new RankingDetalleCodigo();
                $arrayRankingPrimeros6=RankingDetalle::primeros6rk($rsRankingDet,$RankingDetalleCodigo);
                $arrayincluyeOtros=array('IN'=>'IN','NN'=>'NN');
                //var_dump($arrayRankingPrimeros6);
                foreach ($rsRankingDet as $row) {
                    $objRankingDetalleCodigo = new RankingDetalleCodigo();
                    $objRankingDetalleCodigo->Fetch($row['codigo']);
                    {
                        $nr ++;
                        if($objRankingDetalleCodigo->getTipo()!='TT'){
                            $strTable .= '<tr class=" small italic">';  
                        }else{
                            $strTable .= '<tr class=" small italic text text-danger">';
                        }
                        $strTable .= '<td >' . $nr . '</td>';
                        if($objRankingDetalleCodigo->getTipo()!='TT'){
                            $strTable .= '<td class="small italic text text-capitalize">' . ($objRankingDetalleCodigo->getDescripcion()) . '</td>';
                        }else{
                            $strTable .= '<td class="small italic text text-capitalize" >' .$objRankingDetalleCodigo->getDescripcion() . '</td>';
                        }    
                        $strTable .= '<td class="small " >' . $row['puntos'] . '</td>';
                        
                        $base=   $objRankingDetalleCodigo->getBase();
                        $strTable .= '<td class="small ">' .   $base  . '</td>';
                        
                        $ganado= (intval($row['puntos']) / 100 * intval($objRankingDetalleCodigo->getBase())); 
                        $strTable .= '<td class="small ">' . $ganado . '</td>';
           
                        if (array_key_exists($objRankingDetalleCodigo->getTipo(), $arrayincluyeOtros) ){
                           $strTable .= '<td class="small"><span class="glyphicon glyphicon-asterisk"></span>'. '</td>';
                        }elseif (array_key_exists($row['codigo'],$arrayRankingPrimeros6)){
                            if (strrpos($row['codigo'], "S")){
                                $strTable .= '<td class="small"><span class="glyphicon glyphicon-ok">*</span>'. '</td>';
                            }else{
                                $strTable .= '<td class="small"><span class="glyphicon glyphicon-ok-circle">D</span>'. '</td>';
                            }
                        }else{
                            $strTable .="<td></td> ";
                        }    
                        
                        $strTable .= '</tr>';
                    }
                }

$strTable.=
                '</tbody>    
            </table>
        ';
    

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Tennis Player</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<meta name="author" content="corsini" />
<meta name="keywords" content="Tennis, club, events, football, golf, non-profit, betting assistant, football,fitness, tennis, sport, soccer, goal, sports, volleyball, basketball,	charity, club, cricket, football, hockey, magazine, non profit, rugby, soccer, sport, sports, tennis" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,700,600,300' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,300,200,500,600,700,800,900' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
    <link href="css/fonts/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!--Video Porfolio-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />
    
    <link href="css/component.css" rel="stylesheet" type="text/css" />
    <link href="css/style_dir.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico" />
    <link href="css/responsive.css" rel="stylesheet" type="text/css" />
</head>
<body>

<section class="content-top-login">
    <div class="container">
<div class="col-md-12">
    <div class="box-support"> 
      <p class="support-info"><i class="fa fa-envelope-o"></i> info@example.com</p>
   </div>
    <div class="box-login"> 
     <!-- <i class="fa fa-shopping-cart"></i>-->
      <a href='login.php'>Login</a>
      <a href='appnice/sesion_cerrar.php'>Sign Up</a>
   </div>

<!-- Carrito	
   <div class="cart-prod hiddenbox">
      <div class="sec-prod">
       <div class="content-cart-prod">
         <i class="fa fa-times"></i>
         <img src="http://placehold.it/160x160" alt="" />
         <p>FIVE BLX</p>
         <p>1 X $55.00</p>
       </div>
       <div class="content-cart-prod">
         <i class="fa fa-times"></i>
         <img class="racket-img" src="http://placehold.it/160x160" alt="" />
         <p>FIVE BLX</p>
         <p>1 X $125.00</p>
       </div>
        <div class="content-cart-prod">
         <p class="cart-tot-price">Total: $180.00</p>
         <a href="#" class="btn-cart">Go to cart</a>
         <a href="#" class="btn-cart">Checkout</a>
       </div>
      </div>
   </div>
 </div>
fin carrito-->
</div>
</section>

<!--SECTION MENU -->
<section class="container box-logo">
 <header>
   <?php require_once 'menu.php' ?>
</header>

</section>
    <section class="drawer">
    <div class="col-md-12 size-img back-img-match">
        <div class="effect-cover">
                <h3 class="txt-advert animated">Ranking de Tenista</h3>
                <p class="txt-advert-sub">Informacion del jugador en el circuito.</p>
            </div>
    </div>
    
    <section id="single_player" class="container secondary-page">
      <div class="general general-results players">
           <div class="top-score-title right-score col-md-9">
                <h3><?php echo $atleta->getNombres()?> <span><?php echo $atleta->getApellidos()?></span><span class="point-little">.</span></h3>
                <div class="col-md-12 atp-single-player">
                  <?php 
                        if ($atleta->getSexo()=="M"){
                            echo '<img class="img-djoko" src ="images/player/player-face.jpg" alt=""/>';
                        }else{
                            echo '<img class="img-djoko" src ="images/player/facef.jpg" alt=""/>';
                        }
                  ?>
                  <!-- <img class="img-djoko" src ="images/player/player-face.jpg" alt=""/> -->
                  <div class="col-md-2 data-player">
                     <p>Fecha Nac:</p>
                     <p>Lugar Nac.:</p>
                     <p>Height:</p>
                     <p>Weight:</p>
                     <p>Plays:</p>
                     <p>Inicio:</p>
                     <p>Nicknames:</p>
                  </div>
                 

                <div class="col-md-3 data-player-2">
                     <p><?php echo date_format(date_create($atleta->getFechaNacimiento()),'M-Y'); ?></p>
                     <p><?php echo mb_substr ($atleta->getLugarNacimiento(),0,14) ?></p>
                     <p><?php echo $atleta->getTalla(); ?></p>
                     <p><?php echo $atleta->getPeso(); ?></p>
                     <p><?php echo $atleta->gethand(); ?></p>
                     <p><?php echo $atleta->edad() ; ?></p>
                     <p><?php echo $atleta->getNombreCorto() ?></p>
                    
                  </div>
                  
                  <div class="col-md-2 rank-player">
                     <div class="content-rank"><p class="rank-data"><?php echo $ranking->getRknacional() ?></p></div>
                     <p class="rank-title">Actual Ranking</p>
                  </div>
                </div>
            
                <div class="col-md-12 atp-single-player skill-content">
                     <div class="exp-skill">
                            <p class="exp-title-pp">PUNTOS : <?php echo $ranking->getPuntos()?></p>
                            <div class="skills-pp">
                            <?PHP echo $strTable ?>
                            </div>
                        
                    </div>
             </div>
                
                <div class="col-md-12 atp-single-player skill-content">
                     <div class="exp-skill">
                            <p class="exp-title-pp">SKILLS</p>
                            <div class="skills-pp">
                            <div class="skillbar-pp clearfix" data-percent="95%">
                                <div class="skillbar-title-pp"><span>Grip   </span></div>
                                <div class="skillbar-bar-pp"></div>
                                <div class="skill-bar-percent-pp">95%</div>
                            </div>
                            <div class="skillbar-pp clearfix" data-percent="84%">
                                <div class="skillbar-title-pp"><span>Serve  </span></div>
                                <div class="skillbar-bar-pp"></div>
                                <div class="skill-bar-percent-pp">84%</div>
                            </div>
                            <div class="skillbar-pp clearfix" data-percent="65%">
                                <div class="skillbar-title-pp"><span>Forehand</span></div>
                                <div class="skillbar-bar-pp"></div>
                                <div class="skill-bar-percent-pp">65%</div>
                            </div>
                            <div class="skillbar-pp clearfix" data-percent="75%">
                                <div class="skillbar-title-pp"><span>Backhand</span></div>
                                <div class="skillbar-bar-pp"></div>
                                <div class="skill-bar-percent-pp">75%</div>
                            </div>
                        </div>
                    </div>
             </div>
               <div class="col-md-12 atp-single-player skill-content">
                      <div class="ppl-desc">
                        <p class="exp-title-pp">DESCRIPCION</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
                        standard dummy text ever since the 1500s, when an unknown printer took a gallery of type and scrambled it to make a type specimen book.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
                        standard dummy text ever since the 1500s, when an unknown printer took a gallery of type and scrambled it to make a type specimen book.</p>
                    </div>
              </div>
           </div><!--Close Top Match-->

           <!--Right Column-->
           <div class="col-md-3 right-column">
           <div class="top-score-title col-md-12 right-title">
                <h3>Noticias recientes</h3>
                <!-- <div class="right-content">
                    <p class="news-title-right">A New Old Life</p>
                    <p class="txt-right">Simon, who’s seeded just a lowly 26th here, was in many ways the right man for this grueling assignment</p>
                    <a href="single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                </div>
                <div class="right-content">
                    <p class="news-title-right">A New Old Life</p>
                    <p class="txt-right">Simon, who’s seeded just a lowly 26th here, was in many ways the right man for this grueling assignment</p>
                    <a href="single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                </div>
                <div class="right-content">
                    <p class="news-title-right">A New Old Life</p>
                    <p class="txt-right">Simon, who’s seeded just a lowly 26th here, was in many ways the right man for this grueling assignment</p>
                    <a href="single_news.html" class="ca-more"><i class="fa fa-angle-double-right"></i>more...</a>
                </div> -->
          </div>
          <div class="top-score-title col-md-12">
            <img src="img/img_descargadas/cancha.png" alt="" />
          </div>
          <div class="top-score-title col-md-12 right-title">
                <h3>Photos</h3> 
                <ul class="right-last-photo">
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img1.jpg" alt="" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img2.jpg" alt="320x213" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img6.jpg" alt="320x213" />
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img6.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
									    <img src="img/img_descargadas/cdavis/img5.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                        <li>
                            <div class="jm-item second">
							    <div class="jm-item-wrapper">
								    <div class="jm-item-image">
                      <img src="img/img_descargadas/cdavis/img4.jpg" alt="320x213" />
									    
									    <div class="jm-item-description">
                                            <div class="jm-item-button">
                                                <i class="fa fa-plus"></i>
                                            </div>
                                        </div>
								    </div>	
							    </div>
						    </div>
                        </li>
                
                </ul>
          </div>
          </div>
         </section>
         <section id="sponsor" class="container">
            <!--SECTION SPONSOR-->
           <div class="client-sport client-sport-nomargin">
               <div class="content-banner">
                   <?php require_once 'sponsor.php'?>
                  
                </div>
          </div>
           
       </section>

   <?php require_once 'footer.php' ?>
</section>
<script src="js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!--MENU-->
<script src="js/menu/modernizr.custom.js" type="text/javascript"></script>
<script src="js/menu/cbpHorizontalMenu.js" type="text/javascript"></script>
<!--END MENU-->

<!-- Button Anchor Top-->
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>

<!--PERCENTAGE-->
<script>
    $(function () {
        "use strict";
        $('.skillbar-pp').each(function () {
            $(this).find('.skillbar-bar-pp').width(0);
        });

        $('.skillbar-pp').each(function () {
            $(this).find('.skillbar-bar-pp').animate({
                width: $(this).attr('data-percent')
            }, 2000);
        });
    });
</script>


 <script src="js/custom.js" type="text/javascript"></script>

</body>
</html>
