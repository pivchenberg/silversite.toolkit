<?php

namespace Silversite\Toolkit\Catalog\PropsProps;

class PropsPropsCollection
{
	static public $instance;
	private $cache = array();
	
	static function getInstance(){
		if(empty($instance))
			self::$instance = new self;
		
		return self::$instance;
	}
	
	public function getPropsPropsObjectByIblockId($iblockId, $list = false)
	{
		$obPropsProps = "";
		if(empty($this->cache[$iblockId]))
		{
			$obPropsProps = new PropsProps($iblockId, $list);
			$this->cache[$iblockId] = $obPropsProps;
		}
		else
			$obPropsProps = $this->cache[$iblockId];
		
		return $obPropsProps;
	}
	
	function __construct(){}
}