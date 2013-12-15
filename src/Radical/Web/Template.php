<?php
namespace Radical\Web;

use Radical\Web\Templates\Scope;

/**
 * The main template class
 * 
 * @author SplitIce
 *
 */
class Template extends Page\Handler\PageBase {
	const DEFAULT_CONTAINER = 'HTML';
	
	public $vars = array();
	protected $file;
	protected $name = 'error';
	protected $handler = null;
	private $container;
	
	/**
	 * Instansiate a new Template. Templates can be used as a page handler.
	 * Or rendered to a string using a sub request.
	 * 
	 * Templates can be handled by a variety of different adapters detirmined
	 * by the file extension.
	 * 
	 * Templates are sourced from ([app|system])/{$container}/{$name}.*
	 * 
	 * @param string $name name of the template file without extension.
	 * @param array $vars variables to start with
	 * @param string $container the template container to use (template/*)
	 * @throws \Exception
	 */
	function __construct($name, $vars = array(), $container = self::DEFAULT_CONTAINER) {
		$this->vars = $vars;
		$this->name = $name;
		$this->file = new \File(static::getPath($name,$container));
		$this->container = $container;
		if(!$this->file->Exists()){
			throw new \Exception('Template '.$name.' in '.$container.' doesnt exist');
		}
		
		foreach(array_slice(debug_backtrace(true),1) as $r){
			if(isset($r['object']) && $r['object'] instanceof Page\Handler\IPage && !($r['object'] instanceof Template)){
				$this->handler = $r['object'];
				break;
			}
		}
	}
	
	/**
	 * If a method isnt implemented pass it onto the Page Handler.
	 * 
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	function __call($method,$args){
		if(!method_exists($this->handler,$method)) return '';
		return call_user_func_array(array($this->handler,$method),$args);
	}
	
	/**
	 * Return all Adapters
	 * 
	 * @return array
	 */
	static function adapters(){
		return \Core\Libraries::get('Web\\Templates\\Adapter\\*');
	}
	
	/**
	 * Wrap in a container
	 * 
	 * @param string $file
	 * @return \Web\Templates\ContainerTemplate
	 */
	function containedBy($file = Templates\ContainerTemplate::DEFAULT_CONTAINER){
		return new Templates\ContainerTemplate($this->name, $this->container, $this->vars, $file);
	}
	
	/**
	 * Detirmine if a file can be loaded as a template by any adapter.
	 * 
	 * @param string $path
	 * @return boolean
	 */
	static function isSupported($path){
		if(!($path instanceof \File)){
			$path = new \File($path);
		}
		
		$handlers = static::adapters();
		foreach($handlers as $class){
			if(class_exists($class)){
				if($class::is($path)){
					return true;
				}
			}
		}	
		return false;
	}
	
	/**
	 * Get the path to a template resource
	 * 
	 * @param string $name
	 * @param string $output
	 * @return string
	 */
	static function getPath($name,$output = 'HTML'){
		global $BASEPATH;
		//Normally we would use the resource handler for this
		//howeaver as well as detirming which part of the system
		//to fetch from we also have a variable extension
		//@todo overriding order
		$expr = $BASEPATH . '*' . DS . 'template' . DS . $output . DS . $name.'.*';
		foreach(glob($expr) as $path){
			if(static::isSupported($path)){
				return $path;
			}
		}
	}
	
	/**
	 * Check if a specified template resource exists
	 * 
	 * @param unknown_type $name
	 * @param unknown_type $output
	 * @return boolean
	 */
	static function exists($name,$output='HTML'){
		return file_exists(static::getPath($name,$output));
	}
	
	/**
	 * Get the adapter for this template
	 * 
	 * @return \Web\Templates\Adapter\ITemplateAdapter
	 */
	protected function adapter(){	
		$handlers = static::adapters();
		foreach($handlers as $class){
			if(class_exists($class)){
				if($class::is($this->file)){
					return new $class($this->file);
				}
			}
		}
	}
	
	/**
	 * Get the scope
	 * 
	 * @return \Web\Templates\Scope
	 */
	protected function _scope(){
		return new Scope($this->vars, $this->handler);
	}
	
	/**
	 * Handle GET request
	 * 
	 * @throws \Exception
	 */
	function GET() {		
		$adapter = $this->adapter();
		if($adapter == null){
			throw new \Exception('Template file couldnt be found');
		}

		if($adapter instanceof Templates\Adapter\ITemplateAdapter){
			$top = Page\Handler::Top();
			if($top && $top->headers){
				$top->headers->Add('Content-Type', 'text/html;charset=utf-8');
			}else{
				//Warning
			}
			//$VAR,$HANDLER,$TEMPLATE_FILE
			$adapter->Output($this->_scope());
		}else{
			throw new \Exception('Invalid Template Adapter');
		}
	}
	
	/**
	 * Handle POST request
	 *
	 * @throws \Exception
	 */
	function pOST() {
		return $this->GET ();
	}
}