<?php

/**
* Description of Encrypter
*
* @author jose
*/

class Encrypter {

	private static  $Key = "cabuy";

	public static function encrypt ($input) {
	
		// 	$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), $input, MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))));
		
		return base64_encode($input);
	}

	public static function decrypt ($input) {
              
		//$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(Encrypter::$Key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5(Encrypter::$Key))), "\0");
		
		return base64_decode($input);
	}

}