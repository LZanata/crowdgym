<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//INSTANCIA PRINCIPAL DO PAYLOAD PIX
$obPayload = (new Payload)->setPixKey('1234567890')//Chave CPF do Pix
->setDescription('Pagamento do pedido 123456')
->setMerchantName('Leonardo Zanata')
->setMerchantCity('SAO PAULO')
->setAmount(100.00)
->setTxid('CrowdGym1234'); 

//CÓDIGO DE PAGAMENTO PIX
$payloadQrCode = $obPayload->getPayload();


//QR CODE
$obQrCode = new QrCode($payloadQrCode);

//IMAGEM DO QRCODE
$image = (new Output\Png)->output($obQrCode,400);

?>

<h1>QR CODE PIX</h1>

<br>

<img src="data:image/png;base64, <?=base64_encode($image)?>">

<br><br>

Código Pix: <br>
<strong><?=$payloadQrCode?></strong>