<?php
namespace Silversite\Toolkit;

use \Bitrix\Main\Loader,
	\Bitrix\Iblock\ElementTable,
	\Bitrix\Iblock\SectionTable,
	\Bitrix\Main\Data\Cache,
	\Bitrix\Main\Application;

class Components {

	/**
	 * Checks the existence of the field (IBlock element, IBlock section)
	 *
	 * @param int $iblock_id
	 * @param string $field_value
	 * @param string $type
	 * @param string $field_name
	 *
	 * @return bool
	 * */
	static function iblockFieldExists($iblock_id, $field_value, $type = "ELEMENT", $field_name = "CODE") {
		$result = false;
		if(empty($iblock_id))
			return false;
		if(empty($field_value))
			return false;

		$obCache = Cache::createInstance();
		$cacheLifetime = 0;///3600*24*31;
		$cacheID = $iblock_id.$field_name.$field_value;
		$cachePath = "/sstk_iblock_".$iblock_id;
		if($obCache->initCache($cacheLifetime, $cacheID, $cachePath)) {
			//get data from cache
			$result = $obCache->getVars();
		} elseif (Loader::includeModule("iblock") && $obCache->startDataCache()) {
			//forming result
			$arQuery = array(
				"select" => array("ID" , "IBLOCK_ID", "NAME"),
				"filter" => array(
					"=IBLOCK_ID" => (int) $iblock_id,
					"=ACTIVE" => "Y",
					"=".$field_name => $field_value
				)
			);
			switch($type) {
				case "ELEMENT":
					$dbResult = ElementTable::getList($arQuery);
					break;
				case "SECTION":
					$dbResult = SectionTable::getList($arQuery);
					break;
				case "ELEMENT_IN_SECTION":
					$dbResult = SectionTable::getList(
						array(
							"select" => array("ID", "CODE", "NAME", "ELEMENT.ID"),
							"filter" => array(
								"CODE" => $field_value["SECTION"],
								"ELEMENT.CODE" => $field_value["ELEMENT"]
							),
							"runtime" => array(
								new \Bitrix\Main\Entity\ReferenceField(
									"ELEMENT",
									"\\Bitrix\\Iblock\\ElementTable",
									array("=this.ID" => "ref.IBLOCK_SECTION_ID")
								)
							)
						)
					);
					break;
				default:
					$dbResult = ElementTable::getList($arQuery);

			}
			$arResult = $dbResult->fetchAll();

			$cache_manager = Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("iblock_id_".$iblock_id);
			$cache_manager->endTagCache();

			if(empty($arResult)) {
				$result = false;
				$obCache->abortDataCache();
			} else {
				$result = true;
			}


			$obCache->endDataCache($result);
		}

		return $result;
	}

	static function resizeImage($id, $arSizes, $type = BX_RESIZE_IMAGE_EXACT) {
		if((int) $id)
		{
			$arResizedImage = \CFile::ResizeImageGet(
				$id,
				$arSizes,
				$type,
				true
			);
			return $arResizedImage;
		}
		else
		{
			return false;
		}

	}

	static function pluralForm($n, $forms) {
		$n = (int) $n;
		return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
	}

	static function getYoutubeIdFromUrl($url) {
		$parts = parse_url($url);
		if(isset($parts['query'])){
			parse_str($parts['query'], $qs);
			if(isset($qs['v'])){
				return $qs['v'];
			}else if(isset($qs['vi'])){
				return $qs['vi'];
			}
		}
		if(isset($parts['path'])){
			$path = explode('/', trim($parts['path'], '/'));
			return $path[count($path)-1];
		}
		return false;
	}

	static function getAllPropertyValues($iblockId, $code)
	{
		$iblockId = (int) $iblockId;
		if(empty($iblockId))
			return false;

		$obCache = Cache::createInstance();
		$cacheLifetime = 3600*24*31;
		$cacheID = $iblockId.$code;
		$cachePath = "/sstk_all_property_values_" . $code . "_" . $iblockId;

		if($obCache->initCache($cacheLifetime, $cacheID, $cachePath)) {
			//get data from cache
			$arResult = $obCache->getVars();
		} elseif (Loader::includeModule("iblock") && $obCache->startDataCache()) {
			$dbRes = \CIBlockElement::GetList(
				array(),
				array("IBLOCK_ID" => $iblockId, "!PROPERTY_" . $code => false),
				array("PROPERTY_" . $code)
			);
			$arResult = array();
			while ($row = $dbRes->GetNext())
				$arResult[] = $row["PROPERTY_" . $code . "_VALUE"];

			$cache_manager = Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("iblock_id_".$iblockId);
			$cache_manager->endTagCache();

			if(empty($arResult))
				$obCache->abortDataCache();

			$obCache->endDataCache($arResult);
		}

		return $arResult;
	}

	static function getRuMonth($intMonth, $toLower = false,  $count = 2)
	{
		$intMonth = (int) $intMonth;

		$arMonth = [
			1 => [
				"Январь",
				"Января"
			],
			2 => [
				"Февраль",
				"Февраля"
			],
			3 => [
				"Март",
				"Марта"
			],
			4 => [
				"Апрель",
				"Апреля",
			],
			5 => [
				"Май",
				"Мая"
			],
			6 => [
				"Июнь",
				"Июня"
			],
			7 => [
				"Июль",
				"Июля"
			],
			8 => [
				"Август",
				"Августа"
			],
			9 => [
				"Сентябрь",
				"Сентября"
			],
			10 => [
				"Октябрь",
				"Октября"
			],
			11 => [
				"Ноябрь",
				"Ноября"
			],
			12 => [
				"Декабрь",
				"Декабря"
			]
		];

		if(isset($arMonth[$intMonth]))
		{
			$ruMonth = self::pluralForm($count, $arMonth[$intMonth]);
			if($toLower)
				$ruMonth = strtolower($ruMonth);
			return $ruMonth;
		}

		return "";
	}

	static function makeUpUserName($name, $lastName)
	{
		$userName = array_filter(
			array(
				$name,
				$lastName
			),
			function($v)
			{
				if(!empty($v))
					return $v;
			}
		);
		if(empty($userName))
			$userName = "Покупатель";
		else
			$userName = implode(" ", $userName);
		
		return $userName;
	}
}