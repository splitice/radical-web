<?php
namespace Radical\Web\Page\Controller;

use Radical\Web\Page\Handler\PageBase;
use Radical\Web\Page\Handler;

class TransparentGif extends PageBase {		
	/**
	 * Handle GET request
	 *
	 * @throws \Exception
	 */
	function GET(){
		\Web\Page\Handler::top()->headers['Content-Type'] = 'image/gif';
		echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
	}
}