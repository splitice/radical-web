<?php
namespace Radical\Web\Session;

use Radical\Web\Session\User\IUserAdmin;

use Radical\Web\Session\Authentication\Source\ISessionSource;
use Radical\Web\Session\Authentication\IAuthenticator;

/**
 * Authenticator Bridge class between the Authentication Source
 * and the Authentication handler.
 * 
 * @author SplitIce
 *
 */
class Authenticator {
	/**
	 * @var \Web\Session\Authentication\Source\ISessionSource
	 */
	private $source;
	/**
	 * @var \Web\Session\Authentication\IAuthenticator
	 */
	private $authenticator;
	
	/**
	 * @return the $source
	 */
	public function getSource() {
		return $this->source;
	}

	/**
	 * @return the $authenticator
	 */
	public function getAuthenticator() {
		return $this->authenticator;
	}

	/**
	 * @param \Radical\Web\Session\Authentication\Source\ISessionSource $source
	 */
	public function setSource($source) {
		$this->source = $source;
	}

	/**
	 * @param \Radical\Web\Session\Authentication\IAuthenticator $authenticator
	 */
	public function setAuthenticator($authenticator) {
		$this->authenticator = $authenticator;
	}
	
	/**
	 * @return \Radical\Web\Session\Authentication\Source\ISessionSource $source
	 */
	private function _source() {
		if($this->source === null){
			throw new \Exception("No Authentication Source Provided");
		}
		return $this->source;
	}
	
	/**
	 * @return the $authenticator
	 */
	private function _authenticator() {
		if($this->authenticator === null){
			throw new \Exception("No Authenticator Provided");
		}
		return $this->authenticator;
	}

	function __construct(IAuthenticator $authenticator = null, ISessionSource $source = null){
		$this->authenticator = $authenticator;
		$this->source = $source;
	}
	function login($username,$password){
		return $this->_source()->Login($username, $password);
	}
	function loggedInArea(){
		if($this->isLoggedIn()) return true;
		$this->_authenticator()->Init($this->_source());
		$this->_authenticator()->Authenticate();
	}
	function Authenticate(){
		return $this->_authenticator()->Authenticate();
	}
	function isLoggedIn(){
		return $this->_source()->isLoggedIn();
	}
	function isAdmin(){
		if(!isset(\Radical\Web\Session::$data['user']))
			return false;
		
		$user = \Radical\Web\Session::$data['user'];
		if($user instanceof IUserAdmin){
			return $user->isAdmin();
		}
		return false;
	}
	function getUser(){
		return $this->_source()->user();
	}
	function user(){
		return $this->_source()->user();
	}
	function logout(){
		return $this->_source()->Logout();
	}
}