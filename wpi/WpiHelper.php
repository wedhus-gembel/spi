<?php

/**
 * Description of WpiHelper<br>
 * Class helper, to support another function.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

Class WpiHelper {

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

	public static function generateWpiSignature($merchant_key = "", $message = array()){
        $spi_token = isset($message["spi_token"]) ? $message["spi_token"] : "";
        $spi_merchant_transaction_reff = isset($message["spi_merchant_transaction_reff"]) ? $message["spi_merchant_transaction_reff"] : "";
        $spi_amount = isset($message["spi_amount"]) ? $message["spi_amount"] : "0";
        $spi_expedition_price = isset($message["spi_expedition_price"]) ? $message["spi_expedition_price"] : "0";
        $spi_merchant_discount = isset($message["spi_merchant_discount"]) ? $message["spi_merchant_discount"] : "0";
        
        $spi_amount = number_format(doubleval($spi_amount),2,".","");
        $spi_expedition_price = number_format(doubleval($spi_expedition_price),2,".","");
        $spi_merchant_discount = number_format(doubleval($spi_merchant_discount),2,".","");
        
        $signature = strtoupper(sha1(
                $spi_token . '|' . 
                $merchant_key . '|' . 
                $spi_merchant_transaction_reff . '|' .
                $spi_amount . '|' . 
                $spi_expedition_price . '|'. 
                $spi_merchant_discount
                ));
        return $signature;
	}


	public static function generateWpiSignatureResponse($merchant_key = "", $spi_token = "", $spi_merchant_transaction_reff, $response_code){
	    $spi_signature = strtoupper(sha1(
	            $spi_token . '|' . 
	            $merchant_key . '|' . 
	            $spi_merchant_transaction_reff . '|' .
	            $response_code
	            ));
	    return $spi_signature;
	}
}