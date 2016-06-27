<?php
namespace Silversite\Toolkit;

use \Bitrix\Main\Loader,
	\Bitrix\Iblock\ElementTable as BElementTable,
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
		$cacheLifetime = 3600*24*31;
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
					$dbResult = BElementTable::getList($arQuery);
					break;
				case "SECTION":
					$dbResult = SectionTable::getList($arQuery);
					break;
				default:
					$dbResult = BElementTable::getList($arQuery);

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

	static function resizeImage($id, $arSizes) {
		if((int) $id)
		{
			$arResizedImage = \CFile::ResizeImageGet(
				$id,
				$arSizes,
				BX_RESIZE_IMAGE_EXACT
			);
			return $arResizedImage;
		}
		else
		{
			return false;
		}

	}
}