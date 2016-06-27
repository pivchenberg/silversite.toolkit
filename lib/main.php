<?php
namespace Silversite\Toolkit;

use Silversite\Toolkit\SxGeo;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Main {
	protected static $instance = null;

	public function getCityNameSx() {
		$cityName = "";
		$arSxGeo = array();

		$encoding = mb_internal_encoding();
		mb_internal_encoding("8bit");
		
		$SxGeo = new SxGeo(Main::getPath()."/../inc/".'SxGeoCity.dat', SXGEO_FILE | SXGEO_MEMORY);
		$ip = $_SERVER['REMOTE_ADDR'];
		$arSxGeo = $SxGeo->getCityFull($ip);

		mb_internal_encoding($encoding);

		$cityName = !empty($arSxGeo["region"]["name_ru"]) ? $arSxGeo["region"]["name_ru"] : Loc::getMessage("SS_TK_CMAIN_OTHER_CITY");
		return $cityName;
	}


	static function getPath() {
		return dirname(__FILE__);
	}
	
	
	
	static function getInstance() {
		if(!isset(self::$instance))
			self::$instance = new self;
		
		return self::$instance;
	}
}