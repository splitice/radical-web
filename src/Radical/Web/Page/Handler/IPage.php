<?php
namespace Radical\Web\Page\Handler;

interface IPage {
	function execute($method = 'GET');
	function can($m);
	function execute_request($method);
}