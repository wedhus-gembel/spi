<?php
require_once "spi/Spi.php";
require_once "spi/SpiMessage.php";

$username = '17b5da84c564f5728801e87e1c3b7ab9';
$password = '482d7d45cc88947a0fe038fc1b79dcb8';


$Spi = new Spi();
$Spi->setPrivateKey($username, $password);
$result = $Spi->getToolbar();
$toolbar = json_decode($result, TRUE);
$toolbar = isset($toolbar["products"]) ? $toolbar["products"] : array();

$message = new SpiMessage();
$message->set_item('cms', 'API');
$message->set_item('url_listener', 'http://www.yourwebstore.com/url_listener.php');
$message->set_item('spi_callback', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$message->set_item('spi_currency', 'IDR');
$message->set_item('spi_item_description', 'Baju Tidur');
$message->set_item('spi_price', 30000);
$message->set_item('spi_token', $username.$password);
$message->set_item('spi_quantity', 3);
$message->set_item('spi_is_escrow', 0);
$message->set_item('spi_amount', 50000);
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
$message = $message->getMessage();

?>

<!DOCTYPE html>
<html>
<head>
    <title>SPI Testing</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
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
    </style>
</head>
<body>
    <div class="container">
    <form action="" method="POST" name="form_pay">
        <?php
            foreach ($message as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $key1 => $value1) {
                        foreach ($value1 as $key2 => $value2) {
                            ?>
                                <input required type="hidden" name="<?=$key?>[<?= $key1?>][<?= $key2?>]" value="<?= $value2?>">
                            <?php
                        }
                    }
                } else {
                    ?>
                        <input type="hidden" name="<?= $key?>" id="<?= $key?>" value="<?= $value?>">
                    <?php
                }

                
            }

        ?>
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
                                    <div class="col-sm-3 text-center">
                                        <input type="radio" name="pay_url" value="<?= $row['payment_url']?>">
                                        <div class="spi-img">
                                            <img src="<?= $row['payment_logo']?>">
                                            <label><?= $row['payment_name']?></label>
                                        </div>
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
                    <pre>
                        <?php print_r($_POST);?>        
                    </pre>
                </div>
                <?php
            }
        ?>

      </div>
    </form>
    </div>
</body>
<script>
    var rad = document.form_pay.pay_url;
    var prev = null;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            if(this !== prev) {
                prev = this;
            }
            document.form_pay.action = this.value;
        };
    }
</script>
</html>