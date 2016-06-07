# PHP GA Tools
Google Analytics helper class for sending hits using the Measurement protocol

### Send an event
```php
<?php

include "gasender.php";

$clientId = '...'; // Google Analytics Client ID
$ga = new \PhpGaTools\GaSender('UA-XXXXX-1', clientId);
$payload = $ga->event('Form', 'Submit', 'Footer', 10);
$ga->send($payload);
```

### Enhanced ecommerce purchase
```php
<?php

include "gasender.php";
include "ecommerce.php";

$clientId = '...'; // Google Analytics Client ID
$ga = new \PhpGaTools\GaSender('UA-XXXXX-1', $clientId);
$ec = new \PhpGaTools\EnhancedEcommerce();

$products = array(
	array('id'=>'00411', 'name'=>'The Jungle Books', 'brand'=>'Rudyard Kipling', 'price'=>330, 'qty'=>1, 'category'=>'Classics'),
	array('id'=>'00412', 'name'=>'Just So Stories', 'brand'=>'Rudyard Kipling', 'price'=>350, 'qty'=>2, 'category'=>'Classics'),
);

// merge two payloads: event and the purchase
$payload = array_merge(
	$ga->event('Ecommerce', 'Event'),
	$ec->purchase('0032', '1030', $products)
);

$ga->send($payload);
```

### Other hits
Fill free to add other measurement protocol hits.

### Links
[Hit Builder](https://ga-dev-tools.appspot.com/hit-builder/)
