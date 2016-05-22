<?php
namespace Radical\Web\Templates;

class ContainerTemplate extends \Radical\Web\Template {
	const DEFAULT_CONTAINER = 'Common/container';
	
	public $incBody = true;
	protected $body;
	
	function __construct($body, $vars = array(), $container = 'HTML', $name = self::DEFAULT_CONTAINER){
		parent::__construct($name,$vars,$container);
		$this->body = $body;
	}
	
	protected function _scope(){
		return new ContainerScope($this->vars, $this->handler, $this->body, $this->container);
	}
}