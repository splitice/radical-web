<?php
namespace Radical\Web\Page\Router\Recognisers\Templates;

use Radical\Utility\Net\URL;
use Radical\Web\Page\Router\IPageRecognise;

abstract class Flexible implements IPageRecognise {
	private static $match = null;
	
	protected abstract static function generate_matches();
	
	static function recognise(URL $url){
		if(self::$match !== null){
			self::$match = static::generate_matches();
		}
		
		$path = $url->getPath()->getPath(true);
		$matches = null;
		foreach(static::$match as $data){
			if($data->matches($path, $matches)){
				return $data->call($matches);
			}
		}
	}
}