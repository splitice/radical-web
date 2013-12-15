<?php
namespace Radical\Web\Form\Element;

class SubmitButton extends Button {
	function __construct($value = 'Submit'){
		parent::__construct($value,'submit');
	}
}