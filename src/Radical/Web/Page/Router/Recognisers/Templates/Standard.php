<?php
namespace Radical\Web\Page\Router\Recognisers\Templates;

use Radical\Utility\Net\URL;
use Radical\Basic\String\Format;
use Radical\Web\Page\Router\IPageRecognise;

class Standard implements IPageRecognise {
	static $match = array();
	static function recognise(URL $url){
		$path = $url->getPath()->getPath(true);
		foreach(static::$match as $expr=>$class){
			$match = Format::Consume($path, $expr);
			if($match){
				if(is_array($class) || is_string($class)){
					if(is_array($class)){
						$data = isset($class['data'])?$class['data']:$match;
						$class = $class['class'];
					}else{
						$data = $match;
						
						//matched but no data
						if($data === true){
							$data = array();
						}
					}
					if(is_string($class)){
						if($class{0} != '\\'){
							$class = '\\Web\\Page\\Controller\\'.$class;
						}
						return new $class($data);
					}
				}
				return $class;
			}
		}
	}
}