<?php
namespace Radical\Web\Session;

abstract class ModuleBase {
	function __construct(){
		\Web\Session::Init($this);
	}
}