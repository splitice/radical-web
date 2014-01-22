<?php
namespace Radical\Web\Session\Authentication;

use Radical\Web\Session\ModuleBase;
use Radical\Web\Session\Authentication\Source\ISessionSource;

class Post extends ModuleBase implements IAuthenticator {
	const FIELD_USERNAME = 'username';
	const FIELD_PASSWORD = 'password';
	private $authenticate;
	
	function __construct($isAuthenticationPage = true){
		$this->authenticate = $isAuthenticationPage;
		parent::__construct();
	}
	function Authenticate(){
		//Return an example form that could be used for login
	}
	function AuthenticationError($msg = 'Username or Password Invalid'){
		
	}
	function init(ISessionSource $handler){
		if($this->authenticate && isset($_POST[static::FIELD_USERNAME]) && $_POST[static::FIELD_PASSWORD]){
			$username = $_POST[static::FIELD_USERNAME];
			$password = $_POST[static::FIELD_PASSWORD];
			
			$success = $handler->Login($username,$password);
			
			if(!$success){
				return $this->AuthenticationError();
			}
		}
		return true;
	}
}