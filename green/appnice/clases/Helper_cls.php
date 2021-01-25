<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Helper {
    function __construct() {

    }

    public static function get_stylesheet(){
       /* print_r("\n");
        echo '<link rel="stylesheet" href="../bootstrap/3.3.7/css/bootstrap.min.css">';
        print_r("\n");
        echo '<script src="../js/3.1.1/jquery.min.js"></script>';
        print_r("\n");
        
        echo '<script src="../bootstrap/3.3.7/js/bootstrap.min.js"></script>';
        */
        echo '
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
    
        return;
    }

}
