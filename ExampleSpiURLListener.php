<?php

$res_success = "ACCEPTED"; // please always use this response if your system flag success 
$res_no_success = "NOK"; // use another response except "ACCEPTED" if your system flag not success, SPI will retry 3x until get response "ACCEPTED" 


/**
Example of JSON String :
{
    "id_transaksi": "5757636", // Trx ID from SPI
    "no_reff": "7891092505", // Reff ID from Merchant, you will use this param for flagging
    "response_code": "00",
    "id_produk": "SCPIMNDRCP", // Product ID from SPI
    "method_code": "MANDIRICP", // Payment Method
    "keterangan": "Transaksi anda berhasil"
}

Example Response Code :
‘’ : (Empty) Transaksi dalam Proses
00 : Transaksi Sukses
80 : Salah Currency
33 : Database Trouble
31 : Gagal Catat Transaksi
**/


// SPI will request with POST and request body [JSON format]
$json_string = file_get_contents('php://input'); // this is example for grabbing json, you can use another method

$json_array = json_decode($json_string, TRUE);


$response_code = $json_array["response_code"];
$no_reff = $json_array["no_reff"];


// Flagging for making TRX in your system succeed
if($response_code == '00'){
	// Processing your TRX......
	// Flagged for Success

	// TRX status in your system is success
	die($res_success);
	/**
	TRX status in your system is fail
	die($res_failed);
	**/
} 
// Flagging for making TRX in your system failed
else {
	// Processing your TRX......
	// Flagged for fail
	die($res_success);
}


?>
