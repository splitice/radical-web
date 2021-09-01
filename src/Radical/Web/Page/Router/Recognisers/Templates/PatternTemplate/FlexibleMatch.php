<?php
namespace Radical\Web\Page\Router\Recognisers\Templates\PatternTemplate;

use Radical\Basic\StringHelper\Format;

class FlexibleMatch {
	private $expr;
	private $action;	

	function __construct($expr, $action){
		$this->expr = $this->match_functor($expr);
		$this->action = $this->action_functor($action);
	}
	
	private function action_functor($data){
		if(is_string($data)){
			$len = strlen($data);
			if($len == 0){
				throw new \InvalidArgumentException('String must be more than 0B');
			}
			
			$class = $data;
			if($data[0] != '\\'){
				$class_expr = '\\*\\Web\\Page\\Controller\\'.$data;
				$class = null;
					
				foreach(\Radical\Core\Libraries::get($class_expr) as $class){
					//$class set
					break;
				}
					
				if($class === null){
					return null;
				}
			}
			
			return function($data) use($class){
				return new $class($data);
			};
		}
		else if(is_callable($data)){
			return $data;
		}
		throw new \InvalidArgumentException("Invalid argument type:".gettype($data));
	}
	
	private function match_functor($data){
		if(is_string($data)){
			$len = strlen($data);
			if($len == 0){
				throw new \InvalidArgumentException('String must be more than 0B');
			}
		
			if($len > 1 && $data[0] == '`'){
				return function($url, &$matches) use ($data){
					return preg_match($data, (string)$url, $matches);
				};
			}else{
				return function($url, &$matches) use ($data){
					$matches = Format::Consume((string)$url, $data);
					return (bool)$matches;
				};
			}
		}
		else if(is_callable($data)){
			return $data;
		}
		throw new \InvalidArgumentException("Invalid argument type:".gettype($data));
	}
	
	function matches($url, &$matches){
		$expr = $this->expr;
		return $expr($url, $matches);
	}
	
	function call($arguments){
		$action = $this->action;
		return $action($arguments);
	}
}