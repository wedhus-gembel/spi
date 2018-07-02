<?php

/**
 * Description of WpiDirectPayment<br>
 * Class for make direct request.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

require_once "Wpi.php";
require_once "WpiMessage.php";
require_once "WpiHelper.php";

class WpiDirectPayment extends Wpi {
	var $spiMessage;
	var $payment_method;
	var $encrypt_method;

	public function __construct() {
		$this->spiMessage = new WpiMessage();
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
			$messageEncrypted = WpiHelper::encrypt($message, $token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
			$result = $this->doPost(SCApiConstant::PATH_API . "/". $this->payment_method, $messagePay);
		} else {
			$messageEncrypted = WpiHelper::OpenSSLEncrypt($message, $token);
			$messageEncrypted = substr($messageEncrypted, 0, 10). $token. substr($messageEncrypted, 10);
			$messagePay = array("orderdata" => $messageEncrypted);
			$result = $this->doPost(SCApiConstant::PATH_API2 . "/". $this->payment_method, $messagePay);
		}
		return $result;
	}

}