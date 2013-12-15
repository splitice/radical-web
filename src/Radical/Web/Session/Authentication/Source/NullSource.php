<?php
namespace Radical\Web\Session\Authentication\Source;

use Model\Database\DynamicTypes\Password;

use Radical\Web\Session\ModuleBase;
use Model\Database\Model\TableReferenceInstance;

class NullSource extends ModuleBase implements ISessionSource {
	function login($username,$password){
		
	}
	function isLoggedIn(){
		return $this->user() != null;
	}
	function logout(){
		unset(\Web\Session::$data['user']);
	}
	function user(){
		if(isset(\Web\Session::$data['user']))
			return \Web\Session::$data['user'];
	}
}