<?php
class CouchDB {	
	
		private $socket;
		private $username;
		private $password;
		private $host;
		private $port;
		private $request;
		private $header;
		private $body;
	
		 function __construct($host, $port = 5984, $username = null, $password = null) {
			$this->host = $host;
			$this->port = $port;
			$this->username = $username;
			$this->password = $password;
		}
		
		public function polacz() {
        $this->socket = @fsockopen($this->host, $this->port, $err_num, $err_string);
        if(!$this->socket) {
            return false;
        }
		else { 
			return true;
		}
		}
		
		public function rozlacz() {
		$this->socket = null;
		}
		
		public function odpowiedz($method, $url, $data = null, $i = null) {
			$this->request = "{$method} {$url} HTTP/1.0\r\nHost: {$this->host}\r\n";
			if($this->username || $this->password){
				$this->request .= 'Authorization: Basic '.base64_encode($this->username.':'.$this->password)."\r\n";
			}
			if($data) {
				$this->request .= 'Content-Length: '.strlen($data)."\r\n";
				$this->request .= 'Content-Type: application/json'."\r\n\r\n";
				$this->request .= $data."\r\n";
			} else {
				$this->request .= "\r\n";
			}
			fwrite($this->socket, $this->request);
			$response = '';
			while(!feof($this->socket)) {
				$response .= fgets($this->socket);
			}
			 list($this->headers, $this->body) = explode("\r\n\r\n", $response);
			 $this->rozlacz();
			 if($i) return $this->headers;
			 else return $this->body;
		}
		
	}
?>