<?php

/**
 * Description of SpiHelper<br>
 * Class helper, to support another function.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

Class SpiHelper {

	public static function encrypt($text, $key) {
	    $key = $key;
	    return trim(base64_encode(
	    mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
	    $key, $text, MCRYPT_MODE_ECB,
	    mcrypt_create_iv(
	    mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,
	    MCRYPT_MODE_ECB), MCRYPT_RAND))));
	}

	public static function decrypt($text, $key) {
	    return trim(
	            mcrypt_decrypt(
	                MCRYPT_RIJNDAEL_256,
	                $key, base64_decode($text), MCRYPT_MODE_ECB,
	                    mcrypt_create_iv(
	                        mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,
	                        MCRYPT_MODE_ECB), 
	                MCRYPT_RAND)
	            ));
	     


	}


	public static function OpenSSLEncrypt($message, $key) {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = $key;
	    $secret_iv = $key;
	    // hash
	    $key = hash('sha256', $secret_key);
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    $output = openssl_encrypt($message, $encrypt_method, $key, 0, $iv);
	    $output = trim(base64_encode($output));
	    return $output;
	}

	public static function OpenSSLDecrypt($message, $key) {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = $key;
	    $secret_iv = $key;
	    // hash
	    $key = hash('sha256', $secret_key);
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    $output = trim(openssl_decrypt(base64_decode($message), $encrypt_method, $key, 0, $iv));
	    return $output;
	}

}