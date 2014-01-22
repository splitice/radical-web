<?php
namespace Radical\Web\Page\Handler;

class NullPageRequest extends PageRequestBase {	
	function execute($method){
		//Flush Output
		$this->headers->Output();
		ob_end_flush();
	}
	
	function __destruct(){
		$this->Execute('GET');
		exit;
	}
}