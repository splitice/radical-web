<?php
namespace Radical\Web\Session\Authentication;

use Radical\Web\Session\Authentication\Source\ISessionSource;

interface IAuthenticator {
	function Authenticate();
	function init(ISessionSource $handler);
	function AuthenticationError($error = 'Username or Password Invalid');
}