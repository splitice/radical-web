<?php
namespace Radical\Web\Page\Admin\Modules;

interface IAdminModule {
	function getName();
	function getSubmodules();
	function toURL();
}