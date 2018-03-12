<?php

/**
 * Description of SC SPI Message Request<br>
 * Class for make redirect request.<br>
 * @author Reza Ishaq M <rezaishaqm@gmail.com>
 */

class SpiMessage {

    var $_bases_model = array(
        "cms" => "",
        "spi_info1" => "",
        "authKey" => "",
        "spi_callback" => "",
        "url_listener" => "",
        "spi_currency" => "",
        "spi_item" => "",
        "spi_item_description" => "",
        "spi_price" => "",
        "spi_item_weight" => "",
        "spi_quantity" => "",
        "spi_is_escrow" => "",
        "spi_amount" => "",
        "spi_merchant_discount" => "",
        "spi_signature" => "",
        "spi_merchant_discount_reff" => "",
        "spi_token" => "",
        "spi_merchant_transaction_reff" => "",
        "spi_seller_zipcode" => "",
        "spi_item_expedition" => "",
        "spi_expedition_name" => "",
        "spi_expedition_type" => "",
        "spi_expedition_code" => "",
        "spi_expedition_price" => "",
        "spi_billingPhone" => "",
        "spi_billingEmail" => "",
        "spi_billingCountry" => "",
        "spi_billingState" => "",
        "spi_billingName" => "",
        "spi_billingPostalCode" => "",
        "spi_billingAddress" => "",
        "spi_billingCity" => "",
        "spi_deliveryName" => "",
        "spi_deliveryAddress" => "",
        "spi_deliveryCity" => "",
        "spi_deliveryState" => "",
        "spi_deliveryPostalCode" => "",
        "spi_deliveryCountry" => "",
        "spi_item_weight" => "",
        "spi_paymentDate" => "",
        "spi_request_key" => "",
        "custom_page" => "",
        "custom_header" => "",
        "custom_logo" => "",
        "custom_name" => "",
    );

    const _spi_item_name = "name";
    const _spi_item_sku = "sku";
    const _spi_item_qty = "qty";
    const _spi_item_unitPrice = "unitPrice";
    const _spi_item_desc = "desc";
    const _spi_item_produkToken = "produkToken";
    const _spi_item_tax = "tax";
    const _spi_item_weight = "weight";
    const _spi_expeditionName = "expeditionName";
    const _spi_expeditionCode = "expeditionCode";
    const _spi_expeditionType = "expeditionType";
    const _spi_expeditionPrice = "expeditionPrice";
    const _spi_id_merchant = "id_merchant";
    const _spi_additional_info1 = "additional_info1";
    const _spi_additional_info2 = "additional_info2";
    const _spi_totalPrice = "totalPrice";
    const _spi_token = "spi_token";
    

    var $_spi_item_arr = array(
        self::_spi_item_name => "",
        self::_spi_item_desc => "",
        self::_spi_item_produkToken => "",
        self::_spi_item_qty => "",
        self::_spi_item_sku => "",
        self::_spi_item_unitPrice => "",
        self::_spi_item_tax => "",
        self::_spi_item_weight => "",
        self::_spi_expeditionName => "",
        self::_spi_expeditionCode => "",
        self::_spi_expeditionType => "",
        self::_spi_expeditionPrice => "",
        self::_spi_id_merchant => "",
        self::_spi_additional_info1 => "",
        self::_spi_additional_info2 => "",
        self::_spi_totalPrice => "",
        
    );
    var $_item_name = self::_spi_item_name;
    var $_item_sku = self::_spi_item_sku;
    var $_item_qty = self::_spi_item_qty;
    var $_item_desc = self::_spi_item_desc;
    var $_item_produk_token = self::_spi_item_produkToken;
    var $_item_unit_price = self::_spi_item_unitPrice;
    var $_item_tax = self::_spi_item_tax;
    var $_item_weight = self::_spi_item_weight;
    var $_item_expeditionName = self::_spi_expeditionName;
    var $_item_expeditionCode = self::_spi_expeditionCode;
    var $_item_expeditionType = self::_spi_expeditionType;
    var $_item_expeditionPrice = self::_spi_expeditionPrice;
    var $_item_id_merchant = self::_spi_id_merchant;
    var $_item_additional_info1 = self::_spi_additional_info1;
    var $_item_additional_info2 = self::_spi_additional_info2;
    var $_item_totalPrice = self::_spi_totalPrice;

    var $_cms = "cms";
    var $_spi_info1 = "spi_info1";
    var $_authKey = "authKey";
    var $_spi_callback = "spi_callback";
    var $_url_listener = "url_listener";
    var $_spi_currency = "spi_currency";
    var $_spi_item = "spi_item";
    var $_spi_item_description = "spi_item_description";
    var $_spi_price = "spi_price";
    var $_spi_quantity = "spi_quantity";
    var $_spi_is_escrow = "spi_is_escrow";
    var $_spi_amount = "spi_amount";
    var $_spi_token = "spi_token";
    var $_spi_merchant_transaction_reff = "spi_merchant_transaction_reff";
    var $_spi_seller_zipcode = "spi_seller_zipcode";
    var $_spi_item_expedition = "spi_item_expedition";
    var $_spi_expedition_name = "spi_expedition_name";
    var $_spi_expedition_type = "spi_expedition_type";
    var $_spi_expedition_code = "spi_expedition_code";
    var $_spi_expedition_price = "spi_expedition_price";
    var $_spi_billingPhone = "spi_billingPhone";
    var $_spi_billingEmail = "spi_billingEmail";
    var $_spi_billingCountry = "spi_billingCountry";
    var $_spi_billingState = "spi_billingState";
    var $_spi_billingName = "spi_billingName";
    var $_spi_billingPostalCode = "spi_billingPostalCode";
    var $_spi_billingAddress = "spi_billingAddress";
    var $_spi_billingCity = "spi_billingCity";
    var $_spi_deliveryName = "spi_deliveryName";
    var $_spi_deliveryAddress = "spi_deliveryAddress";
    var $_spi_deliveryCity = "spi_deliveryCity";
    var $_spi_deliveryState = "spi_deliveryState";
    var $_spi_deliveryPostalCode = "spi_deliveryPostalCode";
    var $_spi_deliveryCountry = "spi_deliveryCountry";
    var $_spi_item_weight = "spi_item_weight";
    var $_spi_paymentDate = "spi_paymentDate";
    var $_spi_request_key = "spi_request_key";
    var $_spi_merchant_fee = "spi_merchant_fee";
    var $_spi_merchant_tax = "spi_merchant_tax";
    var $_spi_merchant_discount = "spi_merchant_discount";
    var $_spi_signature = "spi_signature";
    var $_spi_merchant_discount_reff = "spi_merchant_discount_reff";
    
    var $_custom_page = "custom_page";
    var $_custom_header = "custom_header";
    var $_custom_logo = "custom_logo";
    var $_custom_name = "custom_name";
    var $_id_seller = "id_seller";
    
    function __construct() 
    {
        
    }
    
    function get_raw_item($object, $key)
    {
        if(array_key_exists($key, $object)){
            return $object[$key];
        }
        return "";
    }
    
    function set_item($key, $val, $parent="")
    {
        if($parent !== "")
        {
            $this->_bases_model[$parent][$key] = $val;
        }
        else
        {
            $this->_bases_model[$key] = $val;
        }
    }
    
    function get_item($key, $parent="")
    {
        if($parent !== "")
        {
            return $this->_bases_model[$parent][$key];
        } 
        else 
        {
            if(array_key_exists($key, $this->_bases_model)){
                return $this->_bases_model[$key];
            }
        }
        return "";
    }
    
    function get_spi_item($key, $index=0)
    {
        $item = $this->get_item($this->_spi_item);
        if(is_array($item))
        {    
            if(array_key_exists($key, $item[$index])){
                return $item[$index][$key];
            }
        }else{
            if($key == self::_spi_item_name){
                return $this->get_item($this->_spi_item);
            }else if($key == self::_spi_item_desc){
                return $this->get_item($this->_spi_item_description);
            }else if($key == self::_spi_item_qty){
                return $this->get_item($this->_spi_quantity);
            }else if($key == self::_spi_item_unitPrice){
                return $this->get_item($this->_spi_price);
            }
        }
        return "";
    }
    
    function create_spi_message(&$msg) 
    {
        $request = json_decode($msg, TRUE);
        if (json_last_error() == JSON_ERROR_NONE) {
            foreach($request as $key => $val)
            {
                if(array_key_exists($key, $this->_bases_model)){
                    $this->_bases_model[$key] = $val;
                }else{
                    $this->_bases_model[$key] = $val;
                }
            }
        }else{
            throw new \Exception('Not Authorized, Failed format message!');
        }
    }
    
    public function getJson(){
        return json_encode($this->_bases_model);
    }

    public function getMessage(){
        return $this->_bases_model;
    }
}
