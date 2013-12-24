<?php
namespace Radical\Web\Templates\Adapter;

use Radical\Web\Templates\Scope;

/**
 * The default adapter. Uses php files for templates.
 * 
 * $_ is a global in these files which provides access
 * to variables and a set of helper functions.
 * 
 * @author SplitIce
 *
 */
class PHPTemplate implements ITemplateAdapter {
	private $file;
	function __construct(\Radical\File $file){
		$this->file = $file;
	}
	function output(Scope $_){
		global $_CONFIG;
		include($this->file);
	}
	static function is(\Radical\File $file){
		if($file->getExtension() == 'php'){
			return true;
		}
		return false;
	}
}