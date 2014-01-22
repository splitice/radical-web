<?php
namespace Radical\Web\Page\Handler;

interface IPage {
	function execute();
	function can($m);
}