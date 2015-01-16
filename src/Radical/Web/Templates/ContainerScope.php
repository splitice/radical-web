<?php
namespace Radical\Web\Templates;

use Radical\Web\Page\Handler\IPage;
use Radical\Web\Page\Handler\PageBase;
use Radical\Web\Page\Handler\PageRequest;
use Radical\Web\Template;

/**
 * Extra scope functions for templates based off
 *  ContainerTemplate for including the body of
 *  the container.
 * 
 * @author SplitIce
 *
 */
class ContainerScope extends Scope {
	protected $body;
	protected $container;
	
	function __construct(array $vars,IPage $handler = null,$body,$container){
		$this->body = $body;
		$this->container = $container;
		parent::__construct($vars,$handler);
	}

    /**
	 * Include the body template
	 */
	function body(){
        if($this->body instanceof PageBase){
            echo $this->subrequest($this->body);
        }else {
            $this->incl($this->body, $this->container);
        }
	}

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

	/**
	 * Get the name of the body
	 */
	function bodyName(){
        if($this->body instanceof Template){
            return null;
        }
		return $this->body;
	}
}