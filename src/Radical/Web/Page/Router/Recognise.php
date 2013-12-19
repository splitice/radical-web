<?php
namespace Radical\Web\Page\Router;

use Radical\Utility\Net\URL;
use Radical\Web\Page\Request;

class Recognise {
	static $__dependencies = array('interface.Web.Page.Router.IPageRecognise','interface.Web.Page.API.IAPIModule');
	
	static function fromRequest(){
		$url = Request::getUrl();
		return static::fromURL($url);
	}
	
	static function fromURL(URL $url, $excluding = array()){
		$recognisers = \Core\Libraries::get('Web\\Page\\Router\\Recognisers\\*');
		foreach($recognisers as $class){
			if(\oneof($class,'Web\\Page\\Router\\IPageRecognise') && !in_array($class, $excluding)){
				$r = $class::Recognise(clone $url);
				if($r){
					return $r;
				}
			}
		}
	}
}