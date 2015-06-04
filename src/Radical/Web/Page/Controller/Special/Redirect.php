<?php
namespace Radical\Web\Page\Controller\Special;

use Radical\Web\Page\Handler;

class Redirect extends Handler\PageBase {
	protected $url;
    protected $code;
	
	function __construct($url, $code = 302){
		$this->url = $url;
        $this->code = $code;
	}
	/**
	 * Handle GET request
	 *
	 * @throws \Exception
	 */
	function GET(){
		$headers = \Radical\Web\Page\Handler::$stack->top()->headers;
		$headers->Status($this->code);
		$headers->Add('Location',$this->url);
		$headers->Add('Cache-Control','nocache');
	}
	
	/**
	 * Handle POST request
	 *
	 * @throws \Exception
	 */
	function POST(){
		return $this->GET();
	}
}