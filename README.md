# PHP GA Tools
Google Analytics helper class for sending hits using the Measurement protocol

### Send an event
```php
<?php

include "gasender.php";

$clientId = '...'; // Google Analytics Client ID
$trackingId = 'UA-XXXXX-1'; // From your config

$ga = new \PhpGaTools\GaSender($trackingId, $clientId);
$payload = $ga->event('Form', 'Submit', 'Footer', 10);
$ga->send($payload);
```

### Enhanced ecommerce purchase
```php
<?php

include "gasender.php";
include "ecommerce.php";

$clientId = '...'; // Google Analytics Client ID
$trackingId = 'UA-XXXXX-1'; // From your config

$ga = new \PhpGaTools\GaSender($trackingId, $clientId);
$ec = new \PhpGaTools\EnhancedEcommerce();

$products = array(
	array('id'=>'00411', 'name'=>'The Jungle Books', 'brand'=>'Rudyard Kipling', 'price'=>330, 'qty'=>1, 'category'=>'Classics'),
	array('id'=>'00412', 'name'=>'Just So Stories', 'brand'=>'Rudyard Kipling', 'price'=>350, 'qty'=>2, 'category'=>'Classics'),
);
$orderId = '0032';
$orderRevenue = 1030;

// merge two payloads: event and the purchase, enhanced ecommerce payloads are
// always sent with an event
$payload = array_merge(
	$ga->event('Ecommerce', 'Event'),
	$ec->purchase($orderId, $orderRevenue, $products)
);

$ga->send($payload);
```
### Check for errors and debugging

Check the last error

```php
...
...
$ok = $ga->send($payload);
if(!$ok){
  print($ga->lastError);
}
```

Enable debugging

```php
...
...
$ga->debug = true;
$ok = $ga->send($payload);
if(!$ok){
  print($ga->lastError);
}
// print debugging info
print_r($ga->lastInfo);

// print last payload
print_r($ga->lastPayload);
```
### Encodings support

If you use an encoding different from UTF8 add it to the constructor.

Let's say you use CP1251.
```php
$ga = new \PhpGaTools\GaSender($trackingId, $clientId, 'CP1251');
```

### Other hits
Fill free to add other measurement protocol hits.

### Links
[Hit Builder](https://ga-dev-tools.appspot.com/hit-builder/)
