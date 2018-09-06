<?php

require_once "wpi/WpiDirectPayment.php";
require_once "wpi/WpiMessage.php";

define("MERCHANT_KEY", "39c9e05920f663956bc8c30eb5eeea1f0704ee98");
define("PRIVATE_KEY1", "4a77ed8d7f73c2450479efdaba9e4d90");
define("PRIVATE_KEY2", "3c5622721d650b61f533bd24fc53668a");

$id_produk = isset($_GET["id_produk"]) ? $_GET["id_produk"] : "indomaret";

$Wpi = new WpiDirectPayment();
$Wpi->isDevel(true);
// set your private key
$Wpi->setPrivateKey(PRIVATE_KEY1, PRIVATE_KEY2);

// You can set directly from JSON string
$message = '{
    "cms": "API_DIRECT",
    "authKey": "",
    "url_listener": "http://www.yourwebstore.com/url_listener.php",
    "spi_currency": "IDR",
    "spi_item": [{
        "name": "Baju Bali",
        "sku": "01020304",
        "qty": "2",
        "unitPrice": "20000",
        "desc": "Baju Tidur",
        "produkToken": "",
        "totalPrice": 40000
    },
    {
        "name": "Baju Jogja",
        "sku": "01020305",
        "qty": "1",
        "unitPrice": "10000",
        "desc": "Baju Olahraga",
        "produkToken": "",
        "totalPrice": 10000
    }],
    "spi_is_escrow": "0",
    "spi_amount": 50000,
    "spi_merchant_transaction_reff": "'.uniqid().'",
    "spi_item_expedition": "0",
    "spi_billingPhone": "085649605912",
    "spi_billingEmail": "zainulalim@gmail.com",
    "spi_billingName": "Pembeli Baju",
    "spi_paymentDate": "'.date('YmdHis', strtotime(date('YmdHis') . ' + 1 hours')).'",
}';

// or you can set manually each items in array
$message = new WpiMessage();
$message->set_item('cms', 'API_DIRECT');
$message->set_item('url_listener', 'http://www.yourwebstore.com/url_listener.php');
$message->set_item('spi_currency', 'IDR');
$message->set_item('spi_is_escrow', 0);
$message->set_item('spi_merchant_transaction_reff', uniqid());
$message->set_item('spi_item_expedition', 0);
$message->set_item('spi_billingPhone', '081234567777');
$message->set_item('spi_billingEmail', 'zainulalim@gmail.com');
$message->set_item('spi_billingName', 'Zainul Alim');
$message->set_item('spi_paymentDate', date('YmdHis', strtotime(date('YmdHis') . ' + 1 hours')));
$item1 = array(
    'name' => 'Baju Bali',
    'sku' => '01020304',
    'qty' => 2,
    'unitPrice' => 20000,
    'desc' => 'Baju Tidur',
);
$message->set_item(0, $item1, 'spi_item');
$item2 = array(
    'name' => 'Baju Jogja',
    'sku' => '01020305',
    'qty' => 1,
    'unitPrice' => 10000,
    'desc' => 'Baju Olahraga',
);
$message->set_item(1, $item2, 'spi_item');
$message->set_item('spi_amount', 50000);

// get json message
$message = $message->getJson();
// using encryption, 1 => Mcrypt, 2 => OpenSSL
$Wpi->setEncryptMethod(1);
// set encrypted message
$Wpi->setMessageFromJson($message);
// set payment method, 
$Wpi->setPaymentMethod($id_produk);
/**
* List of products:
finpay_code => Finnet Payment Code
bri         => BRI Mocash
tcash       => Telkomsel Cash
mandiri     => Mandiri Payment Code
xltunai     => XLTunai
atm_prima   => ATM BCA
bniva       => BNI Virtual Account
briva       => BRI Virtual Account
cimbpc      => ATM 137 Online
indomaret   => Indomaret
alfamart    => Alfamart
**/

$result = $Wpi->doPay();
die($result);
