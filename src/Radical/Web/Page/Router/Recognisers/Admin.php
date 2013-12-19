<?php
namespace Radical\Web\Page\Router\Recognisers;

use Radical\Utility\Net\URL;
use Radical\Web\Page\Router\IPageRecognise;
use Radical\Web\Page\Controller;
use Radical\Web\Page\Handler;

class Admin implements IPageRecognise {
	static function recognise(URL $url){
		$url = $url->getPath();
		if($url->firstPathElement() == 'admin'){
			$url->removeFirstPathElement();
			$data = array();
			
			$module = $url->firstPathElement();
			if($module){
				return new \Web\Page\Controller\Admin($url,$module);
			}
			return new \Web\Page\Controller\Admin($url);
		}
	}
}