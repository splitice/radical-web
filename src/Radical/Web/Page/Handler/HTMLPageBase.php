<?php
namespace Radical\Web\Page\Handler;

abstract class HTMLPageBase extends PageBase implements IMeta {
    /**
     * @var MetaManager
     */
    protected $_meta;
	function __construct(){
		$this->_meta = new MetaManager();
	}
	function title($part = null){
		return $part;
	}
	function meta($what = null, $type = 'meta'){
		if($what === null) return $this->_meta;
		if($this->_meta && $this->_meta->offsetExists($what))
			return $this->_meta->toTag($what,$this->_meta[$what], $type);
	}
}