<?php
namespace Radical\Web\Session\Extra;

use Radical\Web\Session\Handler\Internal\ISessionHandler;

interface ISessionExtra {
	function __construct(ISessionHandler $handler);
}