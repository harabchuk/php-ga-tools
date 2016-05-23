<?php

include "gasender.php";
use PhpGaTools;

$ga = new \GaTools\GaSender('UA-XXXXX-1', '40702790-327f-47f7-bb09-aa797e86bbf0');

$payload = $ga->event('Payment', 'Make Payment', 'Visa', 455);

$ga->send($payload);
