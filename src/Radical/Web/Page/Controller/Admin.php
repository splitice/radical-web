<?php
namespace Radical\Web\Page\Controller;
use Radical\Web\Page\Admin\Menu;
use Radical\Web\Page\Handler\HTMLPageBase;
use Radical\Web\Templates;
use Radical\Web\Session\User\IUserAdmin;
use Utility\Net\URL\Pagination\QueryMethod;
use Radical\Web\Page\Controller\Special\Redirect;
use Radical\Web\Page\Handler;
use Radical\Web\Page;

/**
 * The admin controller
 * 
 * @author SplitIce
 *
 */
class Admin extends HTMLPageBase {	
	protected $module;
	protected $url;
	
	function __construct(\Utility\Net\URL\Path $url,$module = null){
		$this->module = $module;
		$this->url = $url;
	}
	
	/**
	 * Ensure the user has permissions to access the admin panel.
	 * Can possibly result in the login action being executed.
	 * 
	 * @throws \Exception
	 * @return boolean
	 */
	private function checkAdmin(){
		//This is a logged in area, ensure the user is logged in
		\Web\Session::$auth->LoggedInArea();
		if(\Web\Session::$auth->isAdmin()){
			//if is an admin do nothing
			return false;
		}
		
		//This user isnt an admin cant go any further
		throw new \Exception('Not an admin');
	}

	/**
	 * Handle GET request
	 *
	 * @throws \Exception
	 */
	 function GET(){
		$page = $this->checkAdmin();
		if($page) return $page;
		
		//If no module specified then we are listing modules to load
		if($this->module === null){
			return new Templates\ContainerTemplate('index', array('menu'=>new Menu()),'admin');
		}else{
			//Class path to the module
			$class = Page\Admin\Constants::CLASS_PATH.$this->module;
			if(!class_exists($class)){
				throw new \Exception('Couldnt find admin module');
			}
			
			//Remove the module name from the URL path
			$this->url->removeFirstPathElement();
			
			//Delegate to module
			return new $class($this->url);
		}
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