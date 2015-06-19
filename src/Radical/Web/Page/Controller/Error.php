<?php
namespace Radical\Web\Page\Controller;

use Radical\Core\ErrorHandling\Errors\Internal\ErrorException;
use Radical\Web\Page\Handler\HTMLPageBase;
use Radical\Web\Page\Router\Recognise;
use Radical\Web\Template;

class Error extends HTMLPageBase {
	private $error;
	
	function __construct(ErrorException $error){
		$this->error = $error;
	}

	/**
	 * Handle GET request
	 *
	 * @throws \Exception
	 */
	function GET(){
		\Radical\Web\Page\Handler::top()->headers->status(500);
		return new Template('error',array('error'=>$this->error),'framework');
	}
	
	/**
	 * Handle POST request
	 *
	 * @throws \Exception
	 */
	function pOST(){
		return $this->GET();
	}
	
	static function fromURL(\Radical\Utility\Net\URL $url){
		$page = Recognise::fromURL($url);
		return new static($page);
	}
}