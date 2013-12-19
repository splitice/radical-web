<?php
namespace Radical\Web\Session\Authentication\Source;

use Radical\Database\DynamicTypes\Password;
use Radical\Web\Session\ModuleBase;
use Radical\Database\Model\TableReferenceInstance;

class NullSource extends ModuleBase implements ISessionSource {
	function login($username,$password){
		
	}
	function isLoggedIn(){
		return $this->user() != null;
	}
	function logout(){
		unset(\Radical\Web\Session::$data['user']);
	}
	function user(){
		if(isset(\Radical\Web\Session::$data['user']))
			return \Radical\Web\Session::$data['user'];
	}
}