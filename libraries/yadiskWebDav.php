<?php
/*
class yadiskWebDav {

	public $server;
	public $port = 80;
	
	protected $username;
	protected $password;
	
	protected $method;
	protected $headers;
	protected $basic_headers;
	protected $body;
	
	public function __construct($server, $port, $username, $password) {
		$this->server = $server;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		
		$this->basic_headers = array(
			'Authorization: Basic '.base64_encode($this->username.":".$this->password)
		);
	}

	public function options() {
		$this->headers = array(
			
		);
		
		$this->body = 
	}
	
	public function request() {
		$url = 'http://www.example.com/path/to/folder/';
		$response = file_get_contents($url, false, stream_context_create(array(
			'http' => array(
				'method' => $this->method,
				'header' => array_merge($this->basic_headers,$this->headers),
				'content' => $this->body,
			)
		)));
	}

}
*/
