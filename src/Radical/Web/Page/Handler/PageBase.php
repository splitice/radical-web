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

	function execute_request($method){
		return $this->$method();
	}
	
	function renderString(){
		$sr = new SubRequest($this);
		return $sr->Execute('GET');
	}
}