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
	var $encoding='';

	function __construct($trackingId, $clientId, $encoding=''){
		$this->trackingId=$trackingId;
		$this->clientId=$clientId;
		$this->encoding=$encoding;
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
		// remove empty values except zeros. GA does not accept it
		$cleanedPayload = array_filter($payload, function($v){
				return ($v===0 ? true : !empty($v));
		});

		$data = array_merge($cleanedPayload, array('v'=>1, 'tid'=>$this->trackingId, 'cid'=>$this->clientId));

		if($this->encoding){
			array_walk($data, function(&$value){
					$value=iconv($this->encoding, 'UTF8', $value);
			});
		}

		$url = 'http://www.google-analytics.com/collect';
		$content = http_build_query($data);
		$content = utf8_encode($content);
		$user_agent = 'Php GA Tools (https://github.com/harabchuk/php-ga-tools)';

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
