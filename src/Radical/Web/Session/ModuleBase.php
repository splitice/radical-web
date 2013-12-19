<?php
namespace Radical\Web\Session;

abstract class ModuleBase {
	function __construct(){
		\Radical\Web\Session::Init($this);
	}
}