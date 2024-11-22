<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Pix\Payload;

$obPayload = (new Payload)->setPixKey('1234567890')//Chave CPF do Pix
->setDescription('Pagamento do pedido 123456')
->setMerchantName('Leonardo Zanata')
->setMerchantCity('SAO PAULO')
->setAmount(100.00)
->setTxid('CrowdGym1234'); 

$payloadQrCode = $obPayload->getPayload();
