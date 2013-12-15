<?php
namespace Radical\Web\Page\Controller;

use Radical\Web\Page\Router\Recognise;
use Radical\Web\Page\Handler\HTMLPageBase;
use Radical\Web\Template;
use Radical\Web\Page\Handler;
use Core\ErrorHandling\Errors\Internal\ErrorException;

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
		\Web\Page\Handler::top()->headers->status(500);
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
	
	static function fromURL(\Utility\Net\URL $url){
		$page = Recognise::fromURL($url);
		return new static($page);
	}
}