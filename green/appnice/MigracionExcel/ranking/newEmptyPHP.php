<?php
require_once '../../clases/Ranking_detalle_cls.php';
$IM=80;$IMD=100;$COSAT=45;$COTTEC=25;
  $array_puntos=array(
                    "IM"=>$IM,"IMD"=>$IMD,
                    "COSAT"=>$COSAT,"COTTEC"=>$COTTEC);
                $array_data=[];
                RankingDetalle::ranking_detalle("IM",$IM, $array_data);
                RankingDetalle::ranking_detalle("IMD",$IMD, $array_data);
                RankingDetalle::ranking_detalle("COSAT",$COSAT, $array_data);
                RankingDetalle::ranking_detalle("COTTEC",$COTTEC, $array_data);
                print_r($array_data);
