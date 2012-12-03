<?php
/**
* Curl wrapper for Yii
* @author hackerone
*/
class Curl extends CComponent{

	private $_ch;

	// config from config.php
	public $options;

	// default config
	private $_config = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_AUTOREFERER    => true,         
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT        => 10,
		CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0'
        );

	private function _exec($url){

		$this->setOption(CURLOPT_URL, $url);
		$c = curl_exec($this->_ch);
		if(!curl_errno($this->_ch))
			return $c;
		else
			throw new CException(curl_error($this->_ch));

	}

	public function get($url, $params = array()){
		$this->setOption(CURLOPT_HTTPGET, true);
		return $this->_exec($this->buildUrl($url, $params));
	}

	public function post($url, $data = array()){
		$this->setOption(CURLOPT_POST, true);
		$this->setOption(CURLOPT_POSTFIELDS, $data);
		return $this->_exec($url);
	}

	public function put($url, $params = array()){		
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
		return $this->_exec($this->buildUrl($url, $params));
	}

	public function buildUrl($url, $data = array()){
		$parsed = parse_url($url);
		isset($parsed['query'])?parse_str($parsed['query'],$parsed['query']):$parsed['query']=array();
		$params = isset($parsed['query'])?array_merge($parsed['query'], $data):$data;
		$parsed['query'] = ($params)?'?'.http_build_query($params):'';
		if(!isset($parsed['path']))$parsed['path']='/';
		return $parsed['scheme'].'://'.$parsed['host'].$parsed['path'].$parsed['query'];
	}

	public function setOptions($options = array()){
		curl_setopt_array( $this->_ch , $options);
		return $this;
	}

	public function setOption($option, $value){
		curl_setopt($this->_ch, $option, $value);
		return $this;
	}

	// initialize curl
	public function init(){
		try{
			$this->_ch = curl_init();
			$options = is_array($this->options)? ($this->options + $this->_config):$this->_config;
			$this->setOptions($options);

			$ch = $this->_ch;

	        // close curl on exit
	        Yii::app()->onEndRequest = function() use(&$ch){
	            curl_close($ch);
	        };
		}catch(Exception $e){
			throw new CException('Curl not installed');
		}
	}
}