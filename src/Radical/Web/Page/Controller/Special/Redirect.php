<?php
namespace Radical\Web\Page\Controller\Special;

use Radical\Web\Page\Handler;

class Redirect extends Handler\PageBase {
	protected $url;
	
	function __construct($url){
		$this->url = $url;
	}
	/**
	 * Handle GET request
	 *
	 * @throws \Exception
	 */
	function GET(){
		$headers = \Radical\Web\Page\Handler::$stack->top()->headers;
		$headers->Status(301);
		$headers->Add('Location',$this->url);
	}
	
	/**
	 * Handle POST request
	 *
	 * @throws \Exception
	 */
	function pOST(){
		return $this->GET();
	}
}