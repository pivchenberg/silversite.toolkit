<?php
namespace Silversite\Toolkit\SimpleAjax\Handlers;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Context;
use Silversite\Toolkit\Catalog\SilverSiteCatalogSettings;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;

class BasketSimpleHandler implements IAjaxHandler
{
	private $attachedProductsLimit = 20;

	public function handleRequest()
	{
		global $APPLICATION;

		$request = Context::getCurrent()->getRequest();
		$offerId = abs((int) $request->get("offerId"));
		if($offerId && Loader::includeModule("sale") && Loader::includeModule("catalog") && Loader::includeModule("iblock"))
		{
			$requestQuantity = $request->get("quantity");
			$quantity = isset($requestQuantity) ? abs((int)$requestQuantity) : 1;

			//Проверяем есть ли такой товар в корзине
			$dbBasketItem = \CSaleBasket::GetList(
				array(),
				array(
					"FUSER_ID" => \CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"PRODUCT_ID" => $offerId,
					"ORDER_ID" => "NULL",
				),
				false,
				false,
				array(
					"ID",
					"PRODUCT_ID",
					"QUANTITY",
					"PRICE"
				)
			);
			$productInBasket = $dbBasketItem->Fetch();

			//Свойства модели
			$dbRes = \CIBlockElement::GetList(
				[],
				["=ID" => \CIBlockElement::SubQuery(
					"PROPERTY_CML2_LINK",
					array(
						"ID" => $offerId
					)
				)
				],
				false,
				false,
				[
					"ID",
					"IBLOCK_ID",
					"NAME",
					"DETAIL_PAGE_URL",
					"XML_ID"
				]
			);
			//CML2_ARTICLE, DLINA_MM, SHIRINA_MM, VYSOTA_MM
			$ob = $dbRes->GetNextElement();
			$arPropsToAdd = [];
			$arProductProps = [];
			$arProductField = [];
			if($ob)
			{
				$arProductProps = $ob->GetProperties();
				$arProductField = $ob->GetFields();
				$arPropsToAdd = [
					$arProductProps["CML2_ARTICLE"],
					$arProductProps["DLINA_MM"],
					$arProductProps["SHIRINA_MM"],
					$arProductProps["VYSOTA_MM"],
					[
						"CODE" => "DETAIL_PAGE_URL",
						"NAME" => "Детальный URL",
						"VALUE" => $arProductField["DETAIL_PAGE_URL"]
					]
				];
				$modelXmlId = $arProductField['XML_ID'];
			}

			if($quantity > 0)
			{
				if(empty($productInBasket) || $request->get("inc"))
					//Добавление или инкремент на указанное количество
					Add2BasketByProductID($offerId, $quantity, $arPropsToAdd);
				else
					//Обновление
					\CSaleBasket::Update($productInBasket["ID"], array("QUANTITY" => $quantity));
			}
			else
			{
				//Удаление
				\CSaleBasket::Delete($productInBasket["ID"]);
			}

			//Возвращаем измененную корзину
			$arBasketResult = $APPLICATION->IncludeComponent("silversite:sale.basket.basket.line","json",Array(
					"HIDE_ON_BASKET_PAGES" => "N",
					"PATH_TO_ORDER" => "/order/",
					"POSITION_FIXED" => "Y",
					"POSITION_HORIZONTAL" => "right",
					"POSITION_VERTICAL" => "top",
					"SHOW_AUTHOR" => "N",
					"SHOW_DELAY" => "N",
					"SHOW_EMPTY_VALUES" => "Y",
					"SHOW_IMAGE" => "Y",
					"SHOW_NOTAVAIL" => "N",
					"SHOW_NUM_PRODUCTS" => "Y",
					"SHOW_PERSONAL_LINK" => "N",
					"SHOW_PRICE" => "Y",
					"SHOW_PRODUCTS" => "Y",
					"SHOW_SUBSCRIBE" => "N",
					"SHOW_SUMMARY" => "Y",
					"SHOW_TOTAL_PRICE" => "Y"
				)
			);

			//Аксессуары, сопустствующие товары
			$arBasketResult['attachedProducts'] = $this->getAttachedProducts($modelXmlId);

			echo json_encode($arBasketResult);
		}
	}

	public function getAttachedProducts($modelXmlId)
	{
		global $DB;

		$arAttachedProducts = [];
		if(!empty($modelXmlId))
		{
			$arAttachedProducts1 = [];
			$arIblocks = SilverSiteCatalogSettings::getIblocksId();

			$arQuery = [];
			foreach($arIblocks as $iblockId)
			{
				$arQuery[] = "
				(SELECT `IBLOCK_ELEMENT_ID`
				FROM `b_iblock_element_prop_m$iblockId`
				WHERE VALUE = '$modelXmlId')
				";
			}

			$q = implode("\nUNION\n", $arQuery);
			$q .= ' LIMIT 20';
			$dbRes = $DB->Query($q);
			$arElementId = [];
			while($row = $dbRes->GetNext())
				$arElementId[] = $row['IBLOCK_ELEMENT_ID'];

			if(!empty($arElementId))
			{
				$arAttachedProducts1 = $this->getProductsAndOffersByFilter(
					[
						'ID' => $arElementId,
						'ACTIVE' => 'Y'
					]
				);
			}

			$this->attachedProductsLimit = $this->attachedProductsLimit - count($arAttachedProducts1);

			$arAlreadyAttachedId = [];
			foreach($arAttachedProducts1 as $arProduct)
			{
				$arAlreadyAttachedId[] = $arProduct['id'];
			}

			$arAttachedProducts2 = [];
			if($this->attachedProductsLimit > 0)
			{
				$aksValueYesElementId = $this->findAccessoryId();
				if(!empty($aksValueYesElementId))
				{
					$arAttachedProducts2 = $this->getProductsAndOffersByFilter(
						[
							'!ID' => $arAlreadyAttachedId,
							'ID' => $aksValueYesElementId,
							'ACTIVE' => 'Y'
						],
						true
					);
				}
			}
			$arAttachedProducts = array_merge($arAttachedProducts1, $arAttachedProducts2);
		}

		return $arAttachedProducts;
	}


	public function getProductsAndOffersByFilter($arFilter, $random = false)
	{
		$arAttachedProducts = [];
		$dbResult = \CIBlockElement::GetList(
			$random ? ["RAND" => "ASC"] : ['SORT' => 'ASC'],
			$arFilter,
			false,
			[
				'nTopCount' => $this->attachedProductsLimit
			],
			[
				'ID',
				'IBLOCK_ID',
				'NAME',
				'DETAIL_PAGE_URL',
				'DETAIL_PICTURE'
			]
		);
		$arAttachedProducts = array();
		while($arRelatedProduct = $dbResult->GetNext())
		{
			$arElementsId[] = $arRelatedProduct["ID"];
			$arIblocks[] = $arRelatedProduct["IBLOCK_ID"];
			$arRelatedProduct["OFFER"] = array();
			$arAttachedProducts[$arRelatedProduct["ID"]] = $arRelatedProduct;
		}

		$arIblocks = array_unique($arIblocks);

		if(!empty($arElementsId) && !empty($arIblocks))
		{

			foreach($arIblocks as $iblockId)
			{
				$arOffers = \CIBlockPriceTools::GetOffersArray(
					array(
						"IBLOCK_ID" => $iblockId,
						"ACTIVE" => "Y",
						"PROPERTY_CML2_LINK_VALUE" => $arElementsId,
					),
					$arElementsId,
					array(), //order
					array("ID", "NAME", "IBLOCK_ID"), //fields
					array("CML2_LINK"), //props
					0,      //limit
					\CIBlockPriceTools::GetCatalogPrices($iblockId, array("BASE")),
					""
				);
				if(!empty($arOffers))
				{
					foreach($arOffers as &$offer)
					{
						unset($offer["PROPERTIES"]);
						$productId = $offer["DISPLAY_PROPERTIES"]["CML2_LINK"]["VALUE"];
						if(empty($arAttachedProducts[$productId]["OFFER"])
							|| $arAttachedProducts[$productId]["OFFER"]["PRICES"]["BASE"]["DISCOUNT_VALUE"] > $offer["PRICES"]["BASE"]["DISCOUNT_VALUE"])
							$arAttachedProducts[$productId]["OFFER"] = $offer;

					}
				}
			}
		}

		//Форматируем массив
		if(!empty($arAttachedProducts))
		{
			$arAttachedProducts = array_values($arAttachedProducts);
			foreach($arAttachedProducts as &$arRelatedProduct)
			{
				$arImage = \Silversite\Toolkit\Components::resizeImage($arRelatedProduct["DETAIL_PICTURE"], array("width" => 130*1.5, "height" => 105*1.5), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
				$arRelatedProduct = array(
					"id" => $arRelatedProduct['ID'],
					"iblockId" => $arRelatedProduct['IBLOCK_ID'],
					"href" => $arRelatedProduct["DETAIL_PAGE_URL"],
					"price" => !empty($arRelatedProduct["OFFER"]["PRICES"]["BASE"]["DISCOUNT_VALUE"]) ? "<span class='sst-text--thin'>от</span> ".number_format($arRelatedProduct["OFFER"]["PRICES"]["BASE"]["DISCOUNT_VALUE"], 0, "", " ") : "",
					"discount_price" => null,
					"name" => $arRelatedProduct["NAME"],
					"picture" => array(
						"src" => $arImage["src"]
					)
				);
			}
		}

		return $arAttachedProducts;
	}

	public function findAccessoryId()
	{
		global $DB;
		$arIblocks = \Silversite\Toolkit\Catalog\SilverSiteCatalogSettings::getIblocksId();

		$qProp = "SELECT ID, IBLOCK_ID
			FROM b_iblock_property
			WHERE CODE = 'AKSESSUAR' AND IBLOCK_ID IN (" . implode(', ' ,$arIblocks) . ")";
		$propRes = $DB->Query($qProp);
		$arResFilter = [];
		$arPropsId = [];
		while($propRow = $propRes->GetNext())
		{
			$arPropsId[] = $propRow["ID"];
			$arResFilter[$propRow['IBLOCK_ID']]['PROPERTY_AKS_ID'] = $propRow["ID"];
		}

		//Все ID значения "Да" для свойства AKSESSUAR
		$q = '
			SELECT ID, PROPERTY_ID
			FROM b_iblock_property_enum
			WHERE PROPERTY_ID IN (
				' . implode(',', $arPropsId) . '
			) 
			AND VALUE LIKE \'Да\'
			';

		$dbRes = $DB->Query($q);
		$arAksessuarYesValueId = [];
		while($arRow = $dbRes->GetNext())
		{
			foreach($arResFilter as $k => $f)
			{
				if($f['PROPERTY_AKS_ID'] == $arRow['PROPERTY_ID'])
				{
					$arResFilter[$k]['PROPERTY_YES_VALUE'] = $arRow['ID'];
				}
			}
		}

		$arQuery = [];
		foreach($arResFilter as $iblockId => $propData)
		{
			$arQuery[] = "
				(SELECT `IBLOCK_ELEMENT_ID`
				FROM `b_iblock_element_prop_s$iblockId`
				WHERE PROPERTY_{$propData['PROPERTY_AKS_ID']} = {$propData['PROPERTY_YES_VALUE']})
				";
		}

		$q = implode("\nUNION\n", $arQuery);
		$q .= ' LIMIT 20';

		$dbAksRes = $DB->Query($q);

		$arAksElementId = [];
		while($arAksRow = $dbAksRes->GetNext())
			$arAksElementId[] = $arAksRow['IBLOCK_ELEMENT_ID'];

		return $arAksElementId;
	}
}