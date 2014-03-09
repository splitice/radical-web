<?php
namespace Radical\Web\Page\Handler;

use Radical\Web\Page\Cache\DefaultCacheManager;
use Radical\Web\Page\Handler\Exceptions\PageHandlerException;
use Radical\Web\Page\Handler as PH;
use Radical\Web\Page\Router\Recognise;

abstract class PageRequestBase {
	const MAX_REQUEST_DEPTH = 20;
	
	/**
	 * Headers to output
	 * @var \Web\Page\Handler\HeaderManager
	 */
	public $headers;
	
	protected $page;
	protected $cache;
	
	function __construct(IPage $page = null){
		$this->page = $page;
		$this->headers = new HeaderManager();
		$this->cache = new DefaultCacheManager();
	}
	
	private function can_fake($method){
		return $method == 'HEAD';
	}
	
	function execute($method){
		if($method=='GET') $this->cache->preExecute();
		
		//No assumptions
		$method = strtoupper($method);
		
		//Add to Page\Handler Stack
		PH::Push($this);
	
		//Setup output buffering
		ob_start();
	
		$depth = 0;
		while($this->page->can($method) || $this->can_fake($method)){
			$depth++;
			
			$real_method = $method;
			if($this->can_fake($method)){
				$method = 'GET';
			}
	
			$return = $this->page->$method();
			if($return){
				ob_clean();
				$this->page = $return;
			}else{
				if(!$this->page->can($real_method)){
					if($real_method == 'HEAD'){
						//$contents = ob_get_contents();
						//Headers only, no body
						ob_clean();
					}
				}
				break;
			}
				
			//Infinite loop?
			if($depth > static::MAX_REQUEST_DEPTH){
				PH::Pop();
				ob_end_flush();
				$this->headers->Clear();
				throw new PageHandlerException('Max request depth of '.static::MAX_REQUEST_DEPTH.' exceeded.');
			}
		}
	
		//Nothing was handled
		if(!$depth){
			PH::Pop();
			ob_end_flush();
			$this->headers->Clear();
			throw new PageHandlerException('Invalid or unknown method '.$method);
		}
		
		//Pass to the cache handler
		if($method=='GET') $this->cache->postExecute($this->headers);
	}
	
	static function fromURL(\Radical\Utility\Net\URL $url){
		return Recognise::fromURL($url);
	}
}