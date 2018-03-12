<?php

/**
 * Description of SpiDirectPayment<br>
 * This class to make life easier and happier while use and validate SPI json request.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

namespace spi;

require "Spi.php";
require "SpiMessage.php";
require "SpiHelper.php";

class SpiDirectPayment extends Spi {
	var $spiMessage;
	var $payment_method;
	var $encrypt_method;

	public function __construct() {
		$this->spiMessage = new SpiMessage();
		$this->encrypt_method = 0;
	} 
	
	public function setEncryptMethod ($method = 0){
		$this->encrypt_method = $method;
	}

	public function setMessageFromJson($json){
		$this->spiMessage->create_spi_message($json);
		$this->spiMessage->set_item($this->spiMessage->_spi_token, $this->PRIVATE_KEY1.$this->PRIVATE_KEY2);
	}

	public function setPaymentMethod ($payment_method = ""){
		$this->payment_method = $payment_method;
	}

	public function doPay(){
		$message = $this->spiMessage->getJson();
		$token = $this->getToken();
		$result = "";
		if($this->encrypt_method == 0){
			$messageEncrypted = SpiHelper::encrypt($message, $token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
			$result = $this->doPost(SCApiConstant::PATH_API . "/". $this->payment_method, $messagePay);
		} else {
			$messageEncrypted = SpiHelper::OpenSSLEncrypt($message, $token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
			$result = $this->doPost(SCApiConstant::PATH_API2 . "/". $this->payment_method, $messagePay);
		}
		return $result;
	}

}