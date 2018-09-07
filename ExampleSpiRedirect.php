<?php

require_once "spi/Spi.php";
require_once "spi/SpiMessage.php";
require_once "spi/SpiHelper.php";


define("MERCHANT_KEY", "b8697bc90f98e5f72f64dddd205e3f8a");
define("PRIVATE_KEY1", "35ac86421452f8364c3cb8fc264f2d21");
define("PRIVATE_KEY2", "d9850099aba2996792c8687dcea28f1f");

$Spi = new Spi();
$Spi->isDevel(true);
$Spi->setPrivateKey(PRIVATE_KEY1, PRIVATE_KEY2);

// get toolbar
$result = $Spi->getToolbar();
$toolbar = json_decode($result, TRUE);
$toolbar = isset($toolbar["products"]) ? $toolbar["products"] : array();


// generate message
$message = new SpiMessage();
$message->set_item('cms', 'API');
$message->set_item('url_listener', 'http://www.yourwebstore.com/url_listener.php');
$message->set_item('spi_callback', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$message->set_item('spi_currency', 'IDR');
$message->set_item('spi_item_expedition', 0);

$message->set_item('spi_token', PRIVATE_KEY1.PRIVATE_KEY2);
$message->set_item('spi_is_escrow', 0);
$message->set_item('spi_merchant_transaction_reff', uniqid());
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
// total amount
$message->set_item('spi_amount', 50000);

// set 1 to skip every page(exclude pages that have mandatory input) in SPI
$message->set_item('skip_spi_page', 0);

// for SPI Redirect, spi_signature must be defined
$spi_signature = SpiHelper::generateSpiSignature(MERCHANT_KEY, $message->getMessage());
$message->set_item('spi_signature', $spi_signature);
$message->set_item('get_link', "yes");
$message->set_item('payment_via', "SSN");
$message = $message->getMessage();


?>

<!DOCTYPE html>
<html>
<head>
    <title>WPI Testing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SpeedCash Online Payment Gateway Indonesia - Sistem pembayaran online untuk bisnis online, belanja online dan Rekber Rekening Bersama">
    <meta name="keywords" content="sistem pembayaran,pembayaran online,bisnis online,belanja online,payment gateway indonesia">
    <meta name="tag-name" content="pembayaran online,bisnis online,payment gateway indonesia"/>
    <meta name="author" content="SpeedCash">

    <link rel="shortcut icon" href="https://www.speedcash.co.id/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
    img {
        max-width: 120px;
    }
    .bayar {
        margin-top: 37px;
        width: 100%;
        font-size: 30px;
    }
    body {
        background: #eee;
    }
    .container {
        margin-top: 50px;
        background: #fff;
        padding: 40px;
    }
    a > span {
        font-size: 20px;
        font-weight: bold;
    }
    .bordered {
        padding: 10px;
        min-height: 125px;
        margin-bottom: 5px;
        border: 1px solid #e6e1e1;
        display: inline-flex;
        border-radius: 7px;
    }
    .spi-img span {
        display: block;
    }
    .bordered.active {
        background: #0094dc;
        color: #fff;
    }
    .bordered.active img {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 5px;
    }
</style>
</head>
<body>
    <form action="" method="POST" name="form_pay">
    <div class="container">
        
            <div class="row">
                <?php
                    foreach ($message as $key => $value) {
                        if(is_array($value)){
                            foreach ($value as $key1 => $value1) {
                                foreach ($value1 as $key2 => $value2) {
                                    ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="<?= $key?>"><?=$key?>[<?= $key1?>][<?= $key2?>]</label>
                                            <input type="text" class="form-control" name="<?=$key?>[<?= $key1?>][<?= $key2?>]" value="<?= $value2?>">
                                          </div>
                                          
                                    </div>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="<?= $key?>"><?= ucwords($key)?></label>
                                    <input type="text" class="form-control" name="<?= $key?>" value="<?= $value?>">
                                  </div>
                                  
                            </div>
                            
                            <?php
                        }

                        
                    }

                    ?>
                
            </div>
    </div>
    <div class="container">
            
            <div class="row">
                <?php
                ?>
                <ul class="nav nav-pills">
                    <?php
                    $urutan = 0;
                    foreach ($toolbar as $key => $group) {
                        ?>
                        <li class="<?= $urutan == 0 ? 'active' : ''?>"><a data-toggle="pill" href="#<?=strtoupper($key)?>">
                            <span><?=ucwords($key)?></span>
                        </a></li>
                        <?php
                        $urutan ++;
                    }
                    $urutan = 0;
                    ?>
                </ul>
                <div class="tab-content">
                    <?php    
                    foreach ($toolbar as $key => $group) {
                        ?>  


                        <div id="<?=strtoupper($key)?>" class="tab-pane fade <?= $urutan == 0 ? 'in active' : ''?>">

                            <h4><?=ucwords($key)?></h4>
                            <?php
                            foreach ($group as $row) {
                                ?>
                                <div class="text-center bordered">
                                    <label>
                                        <input type="radio" name="pay_url" value="<?= $row['payment_url']?>">
                                        <div class="spi-img">
                                            <img src="<?= $row['payment_logo']?>">
                                            <span><?= $row['payment_name']?></span>
                                        </div>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>



                        <?php
                        $urutan++;
                    }
                    ?>
                </div>
                <?php
                ?>
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-danger bayar">BAYAR</button>
              </div>


              <?php
              if(count($_POST) > 1){
                ?>
                <div class="col-sm-12">
                    <h1>Response</h1>
                    <?php
                        $spi_token = PRIVATE_KEY1.PRIVATE_KEY2;
                        $spi_merchant_transaction_reff = isset($_POST["order_id"]) ? $_POST["order_id"] : "";
                        $response_code = isset($_POST["response_code"]) ? $_POST["response_code"] : "";
                        $spi_signature = SpiHelper::generateSpiSignatureResponse(MERCHANT_KEY, $spi_token, $spi_merchant_transaction_reff, $response_code);
                        $signature_response = isset($_POST["spi_signature"]) ? $_POST["spi_signature"] : "";

                        if($spi_signature == $signature_response){
                            ?>
                                <div class="alert alert-success text-center">
                                    <h2>VERIFIED</h2>
                                    <h3>Valid Signature</h3>
                                </div>
                            <?php
                        } else {
                            ?>
                                <div class="alert alert-danger text-center">
                                    <h2>UNVERIFIED</h2>
                                    <h3>Invalid Signature</h3>
                                </div>
                            <?php
                        }

                    ?>
                    <pre>
                        <?php print_r($_POST);?>        
                    </pre>
                </div>
                <?php
            }
            ?>

        </div>
    
</div>
</form>
</body>
<script>
    var rad = document.form_pay.pay_url;
    var prev = null;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            (prev) ? prev.parentElement.parentElement.classList.remove("active") : null;
            if(this !== prev) {
                prev = this;
            }
            document.form_pay.action = this.value;
            this.parentElement.parentElement.classList.add("active");
        };
    }
</script>
</html>
