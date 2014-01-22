<?php
namespace Radical\Web\Session\User;

interface IUserAdmin extends IUser {
	function isAdmin();
}