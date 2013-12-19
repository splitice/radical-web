<?php
namespace Radical\Web\Session\Authentication\Source;

use Radical\Database\DynamicTypes\Password;
use Radical\Database\Model\TableReferenceInstance;

class Database extends MultipleDatabase {
	function __construct(TableReferenceInstance $table){
		parent::__construct($table);
	}
}