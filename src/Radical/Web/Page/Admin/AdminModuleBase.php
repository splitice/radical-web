<?php
namespace Radical\Web\Page\Admin;

use Radical\Web\Page\Handler\HTMLPageBase;
use Radical\Web\Page\Handler;
use Radical\Web\Template;
use Radical\Web\Templates;

abstract class AdminModuleBase extends HTMLPageBase implements Modules\IAdminModule {
	function getName(){
		return $this->getModuleName();
	}
	function getModuleName(){
		$c = ltrim(get_called_class(),'\\');
		$c = substr($c,strlen(Constants::CLASS_PATH));
		return $c;
	}
	function getSubmodules(){
		return array();
	}
	function toURL(){
		return '/admin/'.$this->getModuleName();
	}
	function __toString(){
		return $this->getName();
	}
	static function createLink(){
		return new static();
	}
	protected function _T($template,$vars){
		$vars['this'] = $this;
		if(Request::Context() == Request::CONTEXT_OUTER){
			return new Template($template,$vars,'admin');
		}
		
		$menu = new Menu($this->getModuleName());
		$vars['menu'] = $menu;
		return new Templates\ContainerTemplate($template,$vars,'admin');
	}
	
	function toId(){
		return 'tab-'.$this->getModuleName();
	}
}