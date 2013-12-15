<?php
namespace Radical\Web\Page\Handler;

class SubRequestResponse {
	public $data;
	public $headers;
	
	function __construct($data,HeaderManager $headers){
		$this->data = $data;
		$this->headers = $headers;
	}
	
	function __toString(){
		return $this->data;
	}
}