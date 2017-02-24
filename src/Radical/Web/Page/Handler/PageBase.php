<?php
namespace Radical\Web\Page\Handler;

use Radical\Core\ErrorHandling;
use Radical\Core\IRenderToString;

abstract class PageBase implements IPage, IRenderToString {
    function __construct(){

    }
	function can($method){
		return method_exists($this,$method);
	}
	
	function execute($method = 'GET'){
		$request = new PageRequest($this);
		ErrorHandling\Handler::Handle(array($request,'Execute'),array($method));
	}

	function execute_request($method, $args = null){
		if($args === null) {
			$args = $_GET;
			if ($method == 'POST') {
				$args = $_POST;
			}
		}
		return $this->$method($args);
	}
	
	function renderString(){
		$sr = new SubRequest($this);
		return $sr->Execute('GET');
	}
}