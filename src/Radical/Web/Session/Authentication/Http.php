<?php
namespace Radical\Web\Session\Authentication;

use Radical\Web\Session\ModuleBase;
use Radical\Web\Session\Authentication\Source\ISessionSource;

class Http extends ModuleBase implements IAuthenticator {
	function Authenticate(){
		$headers = \Radical\Web\Page\Handler::$stack->top()->headers;
		$headers->Status(401);
		$headers->Add('WWW-Authenticate','Basic realm="Site Login"');
		$headers->Output();
		echo 'Text to send if user hits Cancel button';
		exit;
	}
	function AuthenticationError($error = 'Username or Password Invalid'){
		die('Login Failed: '.$error);
		//@todo complete
	}
	function init(ISessionSource $handler){
		if(!empty($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_PW'])){

			$username = $_SERVER['PHP_AUTH_USER'];
			$password = $_SERVER['PHP_AUTH_PW'];
			
			$success = $handler->Login($username,$password);
			//die(var_dump($success));
			if(!$success){
				return $this->AuthenticationError();
			}
		}
	}
}