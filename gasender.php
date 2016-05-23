<?php

namespace PhpGaTools;

class GaSender
{
	var $trackingId='';
	var $clientId='';
	
	function __construct($trackingId, $clientId){
		$this->trackingId=$trackingId;
		$this->clientId=$clientId;
	}
	
	function event($category, $action, $label='', $value=''){
		return array(
			't'=>'event',
			'ec'=>$category,
			'ea'=>$action,
			'el'=>$label,
			'ev'=>$value,
			'ni'=>1
		);
	}

	function send(array $payload){
		$data = array_merge($payload, array('v'=>1, 'tid'=>$this->trackingId, 'cid'=>$this->clientId));
		print_r($data);
		$url = 'http://www.google-analytics.com/collect';
		$content = http_build_query($data); 
		$content = utf8_encode($content); // The payload must be UTF-8 encoded.
		$user_agent = 'Sipuni GaHelper (Sipuni.com)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_exec($ch);
		curl_close($ch);
	}
}
