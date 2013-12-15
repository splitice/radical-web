<?php
namespace Radical\Web\Session\Authentication\Source;

interface ISessionSource {
	function login($username,$password);
	function isLoggedIn();
	function logout();
	function user();
}