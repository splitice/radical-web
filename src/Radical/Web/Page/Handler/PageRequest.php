<?php
namespace Radical\Web\Page\Handler;
use Radical\Web\Page\Handler as PH;

class PageRequest extends PageRequestBase {	
	function execute($method, $args = null){
		parent::Execute($method);
		
		//Flush Output
		$this->headers->Output();
		ob_flush();
		
		//Remove from stack
		PH::Pop();
	}
}