<?php
namespace Radical\Web\Page\Router;

use Radical\Utility\Net\URL;
use Radical\Web\Page\Request;

class Recognise {
	static $recognisers = array();
	
	static function fromRequest(){
		$url = Request::getUrl();
		return static::fromURL($url);
	}
	
	static function fromURL(URL $url, $excluding = array()){
		foreach(self::$recognisers as $class){
			if(\Radical\Core\CoreInterface::oneof($class,'Radical\\Web\\Page\\Router\\IPageRecognise') && !in_array($class, $excluding)){
				$r = $class::Recognise(clone $url);
				if($r){
					return $r;
				}
			}
		}
	}
	
	const POSITION_START = 0;
	const POSITION_END = 1;
	
	static function register($class, $position = self::POSITION_END){
		if($position == self::POSITION_END){
			self::$recognisers[] = $class;
		}else{
			array_unshift(self::$recognisers, $class);
		}
	}
}