<?php
namespace Radical\Web\Page\Cache;

use Radical\Web\Page\Handler\HeaderManager;

interface ICacheManager {
	/**
	 * Called after all the PageHandler itterations are done
	 * 
	 * @param HeaderManager $headers
	 */
	function postExecute(HeaderManager $headers);
}