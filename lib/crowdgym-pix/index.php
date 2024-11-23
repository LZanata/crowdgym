<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//INSTANCIA PRINCIPAL DO PAYLOAD PIX
$obPayload = (new Payload)->setPixKey('47685586827')//Chave CPF do Pix
->setDescription('Pagamento de Assinatura')
->setMerchantName('LEONARDO Z DE JESUS')
->setMerchantCity('BARUERI')
->setAmount(100.00)
->setTxid('CROWDGYM'); 

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