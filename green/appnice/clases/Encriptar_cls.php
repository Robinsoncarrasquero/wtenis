<?php

/**
* Description of Encrypter
*
* @author jose
*/

class Encrypter {

	private static  $Key = "cabuy";

	// public static function encrypt ($input) {
               
	// 	$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
	// 	return $output;
	// }

	// public static function decrypt ($input) {
              
	// 	$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))), "\0");
	// 	return $output;
	// }

	public static function encrypt ($input) {
	
		// 	$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
		return $input;
	}

	public static function decrypt ($input) {
              
		//$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))), "\0");
		return $input;
	}


        
               
       

}

//$texto = "Son unos corruptos";
//
//// Encriptamos el texto
//$texto_encriptado = Encrypter::encrypt($texto);
//
//// Desencriptamos el texto
//$texto_original = Encrypter::decrypt($texto_encriptado);
//
//if ($texto == $texto_original) {
//    echo 'Encriptación / Desencriptación realizada corre';
//    echo 'texto original '.$texto_original;
//    echo 'texto encriptado '.$texto_encriptado;
    
//}





