<?php
namespace Radical\Web\Page\Cache;

use Radical\Web\Page\Handler\HeaderManager;

/**
 * A cache manager to do nothing
 * 
 * Used in sub requests and for people who dont ever want caching
 * 
 * @author SplitIce
 */
class NullCacheManager implements ICacheManager {
	function postExecute(HeaderManager $headers){
		//Do nothing
	}
	

	function preExecute(){
		
	}
}