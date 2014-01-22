<?php
namespace Radical\Web\Page\Router;

interface IPageRecognise {
	static function recognise(\Radical\Utility\Net\URL $url);
}