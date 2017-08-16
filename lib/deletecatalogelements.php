<?php
/*
 * Удалятор элементов инфоблока
 * 
 * */
namespace Silversite\Toolkit;

use Bitrix\Main\Loader;
use Silversite\Toolkit\Catalog\SilverSiteCatalog;

class DeleteCatalogElements
{
	protected static $instance = null;
	protected $iblockId = 26;
	protected $priceCode = array("BASE");
	protected $debug = false;
	public $strWarning = "";
	const MAIL_TEMPLATE = "IBLOCK_ELEMENTS_DELETED";

	public function __construct(){}

	public function __clone(){}

	static function getInstance()
	{
		if(empty(self::$instance))
			self::$instance = new self;
		return self::$instance;
	}

	public function setIblockId($iblockId)
	{
		$this->iblockId = $iblockId;
		return $this;
	}

	public function debug($val)
	{
		$val = (boolean) $val;
		$this->debug = $val;
		return $this;
	}

	public function setPriceCode($priceCode)
	{
		$this->priceCode = $priceCode;
		return $this;
	}

	public function deleteUnfilledProducts()
	{
		if(!Loader::includeModule("iblock"))
			throw new \Exception("cannot include module `iblock`");

		$arResult["CATALOG"] = \CCatalogSKU::GetInfoByIBlock($this->iblockId);
		$arResult["CATALOG"]["PRICES"] = \CIBlockPriceTools::GetCatalogPrices($this->iblockId, $this->priceCode);
		$arCatalogType = $this->getCatalogType();

		if($arResult["CATALOG"]["CATALOG_TYPE"] == \CAllCatalogSku::TYPE_FULL)
		{
			//Выбираем товары
			$dbElementResult = \CIBlockElement::GetList(
				array(),//sort
				array("IBLOCK_ID" => $this->iblockId), //filter
				false,//nav
				false,//group
				array(
					"ID",
					"IBLOCK_ID",
					"IBLOCK_NAME",
					"NAME",
					"IBLOCK_SECTION_ID",
					"XML_ID",
					"DETAIL_PICTURE",
					"DETAIL_TEXT",
					"PROPERTY_*"
				) //selects
			);

			$arDeleteElements = array();
			while($obRow = $dbElementResult->GetNextElement())
			{
				$row = $obRow->GetFields();
				$row["PROPERTIES"] = $obRow->GetProperties();
				//Дополнительная проверка для каталога для свойств
				if(!empty($arCatalogType))
				{
					//Массив для проверки полей
					$arFieldsCheck = array(
						"детальное изображение" => "DETAIL_PICTURE",
						//"детальное описание" => "DETAIL_TEXT"
					);
					switch($arCatalogType)
					{
						case "mattresses":
							//Массив для проверки свойств
							$arPropertiesCheck = array(
								//"Краткое описание (маркетинговое)" => "MARKETINGOVOE_OPISANIE",
								"Производитель" => "PROIZVODITEL",
								"Высота" => "VYSOTA",
								"Жесткость стороны 1" => "ZHESTKOST_STORONY_1",
								"Основа" => "OSNOVA",
								"Наполнитель" => "NAPOLNITEL",
								//"Нагрузка" => "NAGRUZKA",
								//"Двухзонный" => "DVUKHZONNYY",
								//"Съемный чехол" => "SEMNYY_CHEKHOL",
								//"Эффект памяти" => "EFFEKT_PAMYATI",
								//"Ортопедический" => "ORTOPEDICHESKIY",
								//"Эффект Зима-лето" => "EFFEKT_ZIMA_LETO",
								//"Скрученный" => "SKRUCHENNYY",
								//"Гарантия" => "GARANTIYA",
								//"Не для маркета" => "NE_DLYA_MARKETA",
								//"Количество дней доставки ОТ" => "KOLICHESTVO_DNEY_DOSTAVKI_OT",
								//"Количество дней доставки ДО" => "KOLICHESTVO_DNEY_DOSTAVKI_DO",
							);
							break;
						case "mattresses-cover":
							//Массив для проверки свойств
							$arPropertiesCheck = array(
								"Производитель" => "PROIZVODITEL",
								"Высота" => "VYSOTA",
								"Жесткость" => "ZHESTKOST_STORONY_1",
								"Наполнитель" => "NAPOLNITEL",
								//"Количество дней доставки ОТ" => "KOLICHESTVO_DNEY_DOSTAVKI_OT",
								//"Количество дней доставки ДО" => "KOLICHESTVO_DNEY_DOSTAVKI_DO",
							);
							break;
						case "pillows":
							//Массив для проверки свойств
							$arPropertiesCheck = array(
								//"Маркетинговое описание" => "MARKETINGOVOE_OPISANIE",
								"Производитель" => "PROIZVODITEL",
								"Наполнитель" => "NAPOLNITEL",
								//"Высота" => "VYSOTA",
								//"Количество дней доставки ОТ" => "KOLICHESTVO_DNEY_DOSTAVKI_OT",
								//"Количество дней доставки ДО" => "KOLICHESTVO_DNEY_DOSTAVKI_DO",
							);
							break;
					}

					//Проверяем поля
					if(!empty($arFieldsCheck))
					{
						foreach($arFieldsCheck as $ruName => $index)
						{
							if(empty($row[$index]))
							{
								$row = $this->setDeleteReason($row, $arDeleteElements, "отсутствует " . $ruName);
								$arDeleteElements[$row['ID']] = $row;
							}
						}
					}

					//Проверяем свойства
					if(!empty($arPropertiesCheck))
					{
						foreach($arPropertiesCheck as $ruName => $index)
						{
							if(is_array($row["PROPERTIES"][$index]["VALUE"]))
							{
								$firstValue = current($row["PROPERTIES"][$index]["VALUE"]);
								if(empty($firstValue))
								{
									$row = $this->setDeleteReason($row, $arDeleteElements, "значение свойства `" . $ruName . "` пустое");
									$arDeleteElements[$row['ID']] = $row;
								}
							}
							else
							{
								if(empty($row["PROPERTIES"][$index]["VALUE"]))
								{
									$row = $this->setDeleteReason($row, $arDeleteElements, "значение свойства `" . $ruName . "` пустое");
									$arDeleteElements[$row['ID']] = $row;
								}
							}
						}
					}
				}

				//Нет привязки к разделу
				if(empty($row["IBLOCK_SECTION_ID"]))
				{
					$row = $this->setDeleteReason($row, $arDeleteElements, "отсутствует привязка к разделу");
					$arDeleteElements[$row["ID"]] = $row;
				}

				$arResult["PRODUCTS_ID"][] = $row["ID"];
				$arResult["ELEMENTS"][$row["ID"]] = $row;
			}
			unset($row);

			if(!empty($arResult["ELEMENTS"]))
			{
				$priceId = $arResult["CATALOG"]["PRICES"][$this->priceCode[0]]["ID"];

				//Выбираем ТП
				$dbElementResult = \CIBlockElement::GetList(
					array(),//sort
					array("IBLOCK_ID" => $arResult["CATALOG"]["IBLOCK_ID"]), //filter
					false,//nav
					false,//group
					array(
						"ID",
						"IBLOCK_ID",
						"IBLOCK_NAME",
						"NAME",
						"PROPERTY_CML2_LINK",
						"PROPERTY_DLINA",
						"PROPERTY_SHIRINA",
						"XML_ID",
						"CATALOG_GROUP_".$priceId
					) //select
				);

				while($row = $dbElementResult->GetNext())
				{
					if(empty($row["PROPERTY_CML2_LINK_VALUE"]))
					{
						$row = $this->setDeleteReason($row, $arDeleteElements, "торговое предложение не привязано к товару");
						$arDeleteElements[$row["ID"]] = $row;
					}

					if(empty($row["PROPERTY_DLINA_VALUE"]) || empty($row["PROPERTY_SHIRINA_VALUE"]))
					{
						$row = $this->setDeleteReason($row, $arDeleteElements, "у торгового предложения не заполнена длина или ширина");
						$arDeleteElements[$row["ID"]] = $row;
					}

					if(empty($row["CATALOG_PRICE_".$priceId]))
					{
						$row = $this->setDeleteReason($row, $arDeleteElements, "у торгового предложения не заполнена цена");
						$arDeleteElements[$row["ID"]] = $row;
					}

					$arResult["ELEMENTS"][$row["PROPERTY_CML2_LINK_VALUE"]]["OFFERS"][] = $row;
				}
				unset($row);

				foreach($arResult["ELEMENTS"] as $arElement)
				{
					if(empty($arElement["OFFERS"]))
					{
						$arElement = $this->setDeleteReason($arElement, $arDeleteElements, "к товару не привязаны торговые предложения");
						$arDeleteElements[$arElement["ID"]] = $arElement;
					}
				}
				unset($arElement);
			}

			if(!empty($arDeleteElements) && $this->deleteElements($arDeleteElements))
			{
				if(!$this->debug)
					$this->writeLog($arDeleteElements);
				else
				{
					tdump("общее количество на удаление: ". count($arDeleteElements) );
					foreach($arDeleteElements as $arDebug)
					{
						$delReason = str_replace(", ", "\n", $arDebug["DELETE_REASON"]);
						$str = "{$arDebug["ID"]}\n{$arDebug["NAME"]}\n{$delReason}";
						tdump($str);
					}
				}
				return $arDeleteElements;
			}
			elseif(!empty($this->strWarning))
				return $this->strWarning;
			else
				return "Нечего удалять.";
		}
		else
		{
			throw new \Exception("catalog type must be TYPE_FULL");
		}


	}

	protected function setDeleteReason($arr, $arDeleteElements, $message)
	{
		if(empty($arDeleteElements[$arr["ID"]]["DELETE_REASON"]))
			$arr["DELETE_REASON"] = $message;
		else
			$arr["DELETE_REASON"] = $arDeleteElements[$arr["ID"]]["DELETE_REASON"] . ", " . $message;

		return $arr;
	}

	protected function deleteElements($arDelete)
	{
		if(!$this->debug)
		{
			global $DB;

			$strWarning = "";

			foreach ($arDelete as $arElement) {
				if(!\CIBlockElement::Delete($arElement["ID"]))
				{
					$strWarning .= 'Error! '. $arElement["ID"];
				}
			}

			if($this->sendDeletedElementsEmail($arDelete) && empty($strWarning) && empty($this->strWarning))
				return true;
			else
			{
				$this->strWarning .= $strWarning;
				return false;
			}
		}
		else
		{
			$this->sendDeletedElementsEmail($arDelete);
			return true;
		}
	}

	protected function sendDeletedElementsEmail($arDelete)
	{
		if(!empty($arDelete))
		{
			$elementsToDeleteHtml = "";
			foreach($arDelete as $k => $arElement)
			{
				ob_start();
				?>
				<tr style="border-bottom: none;">
					<td style="font-size: 14px; padding: 20px; text-align: left;"><?echo $arElement["ID"];?></td>
					<td style="font-size: 14px; padding: 20px; text-align: center;"><?echo $arElement["XML_ID"];?></td>
					<td style="font-size: 14px; padding: 20px; text-align: center;"><?echo $arElement["NAME"];?></td>
					<td style="font-size: 14px; padding: 20px; text-align: center;"><?echo $arElement["IBLOCK_NAME"];?></td>
					<td style="font-size: 14px; padding: 20px; text-align: right;"><?echo $arElement["DELETE_REASON"];?></td>
				</tr>
				<?
				$elementsToDeleteHtml .= ob_get_contents();
				ob_end_clean();
			}

			$bSendResult = \CEvent::Send(
				self::MAIL_TEMPLATE,
				SITE_ID,
				array("DELETE" => $elementsToDeleteHtml, "COUNT" => count($arDelete))
			);

			if(!$bSendResult)
			{
				$this->strWarning .= " cannot send email";
				return false;
			}
			return true;
		}
		return false;
	}

	protected function writeLog($arDelete)
	{
		if(!empty($arDelete))
		{
			$resultLogStr = "";
			$seporator1 = "================================= Log started: " . date("d.m.Y H:i:s") . " =================================\n";
			$resultLogStr .= $seporator1;
			foreach ($arDelete as $arElement) {
				$logStr =     "DATE: " . date("d.m.Y H:i:s") . "\n"
							. "ID: " . $arElement["ID"] . "\n"
							. "XML_ID: " . $arElement["XML_ID"] . "\n"
							. "NAME: " . $arElement["NAME"] . "\n"
							. "IBLOCK_ID: " . $arElement["IBLOCK_ID"] . "\n"
							. "IBLOCK_NAME: " . $arElement["IBLOCK_NAME"] . "\n"
							. "DELETE_REASON: " . $arElement["DELETE_REASON"] . "\n";

				$resultLogStr .= $logStr;
			}
			$seporator2 = "================================= Log ended: " . date("d.m.Y H:i:s") . " =================================\n";
			$resultLogStr .= $seporator2;

			$f = fopen($_SERVER["DOCUMENT_ROOT"]."deleted_iblock_elements.log", "a");
			fwrite($f, $resultLogStr."\n");
			fclose($f);
		}
	}

	protected function getCatalogType()
	{
		$arCatalogParams = SilverSiteCatalog::getCatalogParams();
		$catalogType = "";
		if(!empty($arCatalogParams))
		{
			foreach($arCatalogParams as $iblockType => $arCatalogParam)
			{
				if((int) $arCatalogParam["catalogParams"]["IBLOCK_ID"] == $this->iblockId)
					$catalogType = $iblockType;
			}
		}

		if(!empty($catalogType))
			return $catalogType;
		else
			return false;
	}
}