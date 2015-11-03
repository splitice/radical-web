<?php
namespace Radical\Web\Page\Cache;

use Radical\Web\Page\Handler\HeaderManager;

/**
 * A smart cache manager, will implement caching in your script without
 * any input from you, although will also work better if you do.
 * 
 * @author SplitIce
 */
class DefaultCacheManager implements ICacheManager {
	function preExecute(){
	}
	private function notModified(HeaderManager $headers){
		//Clear output buffers
		while(ob_get_level()) ob_end_clean();
		
		//Start a new buffer
		ob_start();
		
		//Send 304 not modified
		$headers->Status(304);
	}
	function postExecute(HeaderManager $headers){
		//If people dont utilise the checks until now this will catch it at the end of the request
		if($headers->status == 200){
			if(isset($headers['Last-Modified'])){				
				//Check if the user sent a If-Modified-Since header in their request
				$ims = \Radical\Web\Page\Request::header('If-Modified-Since');
				if($ims){
					//Parse the time in the last modified sent from the page handler
					$lmts = strtotime($headers['Last-Modified']);
					
					//If the user has an unmodified version (aparently) based on last modifed dates
					if($lmts <= strtotime($ims)){
						$this->notModified($headers);
					}
				}
			}else{ //If no Last-Modified specified
				//Look for etag in request
				$et = \Radical\Web\Page\Request::header('If-None-Match');
                if(strlen($et) >= 2){
                    if(substr($et,0,2) == 'W/'){
                        $et = substr($et,2);
                    }
                }
				if(isset($headers['ETag'])){
					if($et == $headers['ETag']){
						$this->notModified($headers);
					}
				}else{
					$hash = md5(md5(ob_get_contents(), true).session_id());
					if($hash == substr($et,1,-1)){
						$this->notModified($headers);
					}else{
						$headers->setEtag($hash);
					}
				}
			}
		}
	}
}