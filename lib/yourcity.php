<?php
namespace Silversite\Toolkit;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

Class YourCity {

	protected static $instance = null;
	protected $iblockId = 7;
	protected $cacheTime = 3600;
	protected $cachePath = "/cities";
	public static $otherCityId = 11297; //moscow //id города, если не получилось обределить по ip
	public $arCities = array();

	public function getCitiesArray() {
		global $APPLICATION;

		$arResult = array();
		if(Loader::includeModule("silversite.toolkit") && Loader::includeModule("iblock")) {

			$obCache = \Bitrix\Main\Data\Cache::createInstance();

			if($obCache->initCache($this->cacheTime, $this->iblockId, $this->cachePath))
			{
				$arResult["CITIES"] = $obCache->getVars();
			}
			elseif($obCache->startDataCache())
			{
				//Все города из информационного блока
				$dbCities = \CIBlockElement::GetList(
					array(),//sort
					array("IBLOCK_ID" => $this->iblockId, "ACTIVE" => "Y"), //filter
					false, //group by
					false, //nav
					array(
						"ID",
						"NAME",
						"PROPERTY_MAP_CENTER",
						"PROPERTY_MAP_ZOOM"
					) //select
				);
				while($arCity = $dbCities->GetNext())
					$arResult["CITIES"][$arCity["ID"]] = $arCity;
				
				$cacheManager = Application::getInstance()->getTaggedCache();
				$cacheManager->startTagCache($this->cachePath);
				$cacheManager->registerTag("iblock_id_".$this->iblockId);
				$cacheManager->endTagCache();

				$obCache->endDataCache($arResult["CITIES"]);
			}

			$cityId = abs((int) $_COOKIE["SS_CITY_ID"]);
			if(empty($cityId)) {
				//Узнаем имя города по ip
				$cityName = Main::getInstance()->getCityNameSx();
				foreach($arResult["CITIES"] as $arCity) {
					if($arCity["NAME"] == $cityName)
						$arResult["SELECTED_CITY"] = $arCity;
				}
				if(empty($arResult["SELECTED_CITY"]))
					$arResult["SELECTED_CITY"] = $arResult["CITIES"][$this->otherCityId];
				$APPLICATION->set_cookie("CITY_ID", $arResult["SELECTED_CITY"]["ID"], time()+3600*24*30*12, "/", false, false, true, "SS");
				$arResult["DEFINED_BY_IP"] = true;
			} else {
				//Выбираем город
				if(array_key_exists($cityId, $arResult["CITIES"]))
					$arResult["SELECTED_CITY"] = $arResult["CITIES"][$cityId];
				else
					$arResult["SELECTED_CITY"] = $arResult["CITIES"][$this->otherCityId];
			}
			
			return $arResult;
		}
	}

	static function getInstance($iblockId = "", $cacheTime = "") {
		if(!isset(self::$instance))
			self::$instance = new self($iblockId, $cacheTime);

		return self::$instance;
	}

	function __construct($iblockId, $cacheTime) {
		if(!empty($iblockId))
			$this->iblockId = $iblockId;
		if(!empty($cacheTime))
			$this->cacheTime = $cacheTime;
		$this->arCities = $this->getCitiesArray();
	}
}