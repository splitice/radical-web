<?php
namespace Radical\Web\Page\Admin;

class Request {
	const CONTEXT_OUTER = 'outer';
	const CONTEXT_INNER = 'inner';
	
	static function context($to = null){
		if($to !== null)
			$_POST['_admin'] = $to;
		
		if(isset($_POST['_admin']))
			return $_POST['_admin'];
	}
}