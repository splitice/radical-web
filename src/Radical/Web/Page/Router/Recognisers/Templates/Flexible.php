<?php
namespace Radical\Web\Page\Router\Recognisers\Templates;

use Radical\Utility\Net\URL;
use Radical\Web\Page\Router\IPageRecognise;
use Radical\Web\Page\Router\Recognisers\Templates\PatternTemplate\FlexibleMatch;

abstract class Flexible implements IPageRecognise {
	private static $match = null;
	
	protected abstract static function generate_matches();
	
	static function recognise(URL $url){
		if(self::$match === null){
			self::$match = array();
			static::generate_matches();
		}
		
		$path = $url->getPath()->getPath(true);
		$matches = null;
		foreach(self::$match as $data){
			if($data->matches($path, $matches)){
				return $data->call($matches);
			}
		}
	}
	
	protected function add_match(FlexibleMatch $match){
		self::$match[] = $match;
	}
}