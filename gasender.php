<?php

namespace PhpGaTools;

class GaSender
{
	var $trackingId='';
	var $clientId='';
	var $debug=false;
	var $lastError='';
	var $lastInfo='';
	var $lastPayload='';

	function __construct($trackingId, $clientId){
		$this->trackingId=$trackingId;
		$this->clientId=$clientId;
	}

	function event($category, $action, $label=null, $value=null){
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
		// remove empty values, GA does not accept it
		$cleanedPayload = array_filter($payload, function($v){
				return ($v===0 ? true : !empty($v));
		});
		$data = array_merge($cleanedPayload, array('v'=>1, 'tid'=>$this->trackingId, 'cid'=>$this->clientId));
		$url = 'http://www.google-analytics.com/collect';
		$content = http_build_query($data);
		$content = utf8_encode($content);
		$user_agent = 'Php GA Tools (metricexpert.com)';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$ok = $result!==false;

		if(!$ok){
			$this->lastError = curl_error($ch);
		}

		if($this->debug){
			$this->lastInfo = curl_getinfo($ch);
			$this->lastPayload = $data;
		}

		curl_close($ch);
		return $ok;
	}
}
