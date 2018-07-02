<?php

/**
 * Description of Wpi<br>
 * Main class for WPI API.<br>
 * @author Zainul Alim <za.mi213@gmail.com>
 */

class Wpi {
	
	var $PRIVATE_KEY1 = "";
	var $PRIVATE_KEY2 = "";
	var $IS_DEVEL = false;
	var $DOMAIN_URL = "";

    public function __construct() {
    	$this->DOMAIN_URL = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
    }
    
    public function setPrivateKey($pk1 = "", $pk2 = "") {
    	$this->PRIVATE_KEY1 = $pk1;
    	$this->PRIVATE_KEY2 = $pk2;
    }

    public function isDevel($is_devel = false){
        $this->IS_DEVEL = $is_devel;
    }

    public function getToolbar(){
        $params = array(
            "token" => trim($this->PRIVATE_KEY1.$this->PRIVATE_KEY2)
        );
    	return $this->doGet(SCApiConstant::PATH_TOOLBAR, $params);
    }

    public function getToken(){
        return $this->doGet(SCApiConstant::PATH_TOKEN, "");
    }

    public function doGet($path, $content, $content_type = SCApiContentType::RAW_POST) {
        if (is_array($content)) {
            $content = http_build_query($content);
        }
        $URL = $this->IS_DEVEL ? SCApiConstant::SPI_URL_DEVEL : SCApiConstant::SPI_URL;
        $result = file_get_contents($URL . $path . "?" . $content, false, $this->createContext("GET", $content, true, $content_type));
        return $result;
    }

    public function doPost($path, $content, $content_type = SCApiContentType::RAW_POST) {
        if (is_array($content) && $content_type == SCApiContentType::JSON) {
            $content = json_encode($content);
        }
        $URL = $this->IS_DEVEL ? SCApiConstant::SPI_URL_DEVEL : SCApiConstant::SPI_URL;
        $result = file_get_contents($URL . $path, false, $this->createContext("POST", $content, true, $content_type));
        return $result;
    }

    private function createContext($method, $content = "", $use_auth = true, $content_type = SCApiContentType::RAW_POST) {
        if (is_array($content)) {
            $content = http_build_query($content);
        }

        $opts = array('http' =>
            array(
                'method' => $method,
                'header' => "Content-Type: $content_type\r\n" .
                            ($use_auth ? 'Authorization: Basic ' . base64_encode($this->PRIVATE_KEY1 . ":" . $this->PRIVATE_KEY2). "\r\n" : ""),
                'content' => $content
            )
        );

        return stream_context_create($opts);
    }

}


class SCApiConstant {
    const SPI_URL = "https://www.speedcash.co.id/spi";
    const SPI_URL_DEVEL = "https://www.smartcash.co.id/spi";
    const PATH_TOKEN = "/token";
    const PATH_API = "/api";
    const PATH_API2 = "/apiv2";
    const PATH_TOOLBAR = "/spi_toolbar/generate_toolbar_group";

}

class SCApiContentType {

    const RAW_POST = "application/x-www-form-urlencoded";
    const JSON = "application/json";
    const PLAIN = "text/plain";

}
