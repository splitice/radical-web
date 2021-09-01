<?php
namespace Radical\Web\Page\Router\Recognisers\Templates;

use Radical\Basic\StringHelper\Format;
use Radical\Utility\Net\URL;
use Radical\Web\Page\Router\IPageRecognise;

class Standard implements IPageRecognise {
	static $match = array();
	static function recognise(URL $url){
		$path = $url->getPath()->getPath(true);
		$match = null;
		foreach(static::$match as $expr=>$class){
			$matches = Format::consumeRegex($path, $expr, $match);
			if($matches){
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
						if($class[0] != '\\'){
							$class_expr = '\\*\\Web\\Page\\Controller\\'.$class;
							$class = null;
							
							foreach(\Radical\Core\Libraries::get($class_expr) as $class){
								//$class set
								break;
							}
							
							if($class === null){
								return null;
							}
						}
						return new $class($data);
					}
				}
				return $class;
			}
		}
	}
}