<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$date=date_create("2017-01-17");
$date=date_create(); // fecha del servidor 
date_add($date,date_interval_create_from_date_string("4 days"));
echo date_format($date,"Y-m-d:H:i:s");





