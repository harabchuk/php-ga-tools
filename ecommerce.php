<?php
/*
    Enhanced Ecommerce Payloads
*/

namespace PhpGaTools;

class EnhancedEcommerce
{
	/*
	$products = array(
		array('id'=>'00411', 'name'=>'The Jungle Books', 'brand'=>'Rudyard Kipling', 'price'=>330, 'qty'=>1, 'category'=>'Classics'),
		array('id'=>'00412', 'name'=>'Just So Stories', 'brand'=>'Rudyard Kipling', 'price'=>350, 'qty'=>3, 'category'=>'Classics'),
	);
	*/
	function purchase($orderId, $revenue, array $products){
		$transaction = array(
			'ti'=>$orderId,
			'tr'=>$revenue,
			'pa'=>'purchase'
		);
		for($i=0; $i<count($products); $i++){
			$n = $i+1;
			$transaction["pr{$n}id"] = $products[$i]['id'];
			$transaction["pr{$n}nm"] = $products[$i]['name'];
			$transaction["pr{$n}br"] = $products[$i]['brand'];
			$transaction["pr{$n}pr"] = $products[$i]['price'];
			$transaction["pr{$n}ca"] = $products[$i]['category'];
			$transaction["pr{$n}qt"] = $products[$i]['qty'];
		}
		return $transaction;
	}
}
?>
