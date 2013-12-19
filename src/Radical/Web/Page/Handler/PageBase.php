<?php
namespace Radical\Web\Page\Handler;

use Core\ErrorHandling\Errors\Internal\ErrorException;
use Core\ErrorHandling;

abstract class PageBase implements IPage {
	function can($method){
		return method_exists($this,$method);
	}
	
	function execute($method = 'GET'){
		$request = new PageRequest($this);
		ErrorHandling\Handler::Handle(array($request,'Execute'),array($method));
	}
}