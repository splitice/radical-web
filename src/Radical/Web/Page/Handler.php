<?php
namespace Radical\Web\Page;

use Radical\Web\Page\Handler\NullPageRequest;

class Handler {
	static $__dependencies = array('interface.Web.Page.Handler.IPage','interface.Web.Page.Handler.IPage');
	
	/**
	 * A stack of Page\Handlers, used for preserving state (headers etc) during subrequests.
	 * 
	 * @var SplStack
	 */
	static $stack;
	
	static function init(){
		if(!static::$stack){
			static::$stack = new \SplStack();
		}
	}
	static function __callStatic($method,$arguments){
		static::Init();
		return call_user_func_array(array(static::$stack,$method),$arguments);
	}
	
	static function top(){
		return self::current();
	}
	
	/**
	 * @param bool $notExistsCreate
	 * @return \Radical\Web\Page\Handler\NullPageRequest
	 */
	static function current($notExistsCreate = false){
		static::Init();
		if(static::$stack->count() == 0){
			if($notExistsCreate){
				return new NullPageRequest();
			}
			return null;
		}else{
			return static::$stack->top();
		}
	}
	
	static function objectify($object,$data = null){
		$classes = \Radical\Core\Libraries::get('*\\Web\\Page\\Controller\\'.$object);
		if(!$classes){
			return null;
		}
		$class = $classes[0];
		return new $class($data);
	}
}