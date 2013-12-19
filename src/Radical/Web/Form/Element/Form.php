<?php
namespace Radical\Web\Form\Element;
use Radical\Utility\HTML\SingleTag;

class Form extends SingleTag {
	function __construct($action = null, $method = 'POST'){
		parent::__construct('form',compact('action','method'));
	}
}