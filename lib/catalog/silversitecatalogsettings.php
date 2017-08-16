<?php
namespace Silversite\Toolkit\Catalog;

Class SilverSiteCatalogSettings {
	const REVIEWS_IBLOCK_ID = 121;

	protected static $arCatalogInfo = array(
		/*
		 *
		 * 1. Ванны
		 *
		 * */
		"bath" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "bath",
				"IBLOCK_ID" => 116,
				"LP_IBLOCK_ID" => 119, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/bath/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 2. Аксессуары для ванной комнаты
		 *
		 * */
		"bathroomaccessories" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "bathroomaccessories",
				"IBLOCK_ID" => 132,
				"LP_IBLOCK_ID" => 139, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/bathroom-accessories/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 3. Мебель для ванных комнат
		 *
		 * */
		"furnitureforbathrooms" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "furnitureforbathrooms",
				"IBLOCK_ID" => 131,
				"LP_IBLOCK_ID" => 154, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/furniture-for-bathrooms/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 4. Унитазы
		 *
		 * */
		"toilets" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "toilets",
				"IBLOCK_ID" => 140,
				"LP_IBLOCK_ID" => 155, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/toilets/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 5. Комплектующие для ванн
		 *
		 * */
		"bathroomcomponents" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "bathroomcomponents",
				"IBLOCK_ID" => 146,
				"LP_IBLOCK_ID" => 156, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/bathroom-components/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 6. Душевые кабины и боксы
		 *
		 * */
		"showerenclosuresandboxes" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "showerenclosuresandboxes",
				"IBLOCK_ID" => 145,
				"LP_IBLOCK_ID" => 157, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/shower-enclosures-and-boxes/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 7. Душевая программа
		 *
		 * */
		"shower" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "shower",
				"IBLOCK_ID" => 147,
				"LP_IBLOCK_ID" => 158, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/shower/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
/*
		 *
		 * 8. Смесители
		 *
		 * */
		"mixers" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "mixers",
				"IBLOCK_ID" => 128,
				"LP_IBLOCK_ID" => 159, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/mixers/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
	/*
		 *
		 * 9. Инсталляции
		 *
		 * */
		"installations" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "installations",
				"IBLOCK_ID" => 148,
				"LP_IBLOCK_ID" => 162, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/installations/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 10. Душевые ограждения и поддоны
		 *
		 * */
		"showerenclosuresandtrays" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "showerenclosuresandtrays",
				"IBLOCK_ID" => 143,
				"LP_IBLOCK_ID" => 163, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/shower-enclosures-and-trays/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 11. Раковины и кухонные мойки
		 *
		 * */
		"sinks" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "sinks",
				"IBLOCK_ID" => 160,
				"LP_IBLOCK_ID" => 164, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/sinks/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 12. Писсуары и биде
		 *
		 * */
		"urinalsandbidets" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "urinalsandbidets",
				"IBLOCK_ID" => 165,
				"LP_IBLOCK_ID" => 169, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/urinals-and-bidets/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 13. Комплектующие для санфаянса
		 *
		 * */
		"toiletcomponents" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "toiletcomponents",
				"IBLOCK_ID" => 172,
				"LP_IBLOCK_ID" => 174, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/toilet-components/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 14. Пьедесталы и полупьедесталы
		 *
		 * */
		"pedestals" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "pedestals",
				"IBLOCK_ID" => 166,
				"LP_IBLOCK_ID" => 175, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/pedestals/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
		/*
		 *
		 * 15. Комплектующие для раковин и моек
		 *
		 * */
		"sinkscomponents" => array(
			//Настройка каталога
			"catalogParams" => array(
				"IBLOCK_TYPE" => "sinkscomponents",
				"IBLOCK_ID" => 170,
				"LP_IBLOCK_ID" => 176, //id инфоблока посадочных страниц
				"REVIEWS_IBLOCK_ID" => self::REVIEWS_IBLOCK_ID,
				//"EDITABLE_FIELD_ID" => 8,
				"SEF_MODE" => "Y",
				"SEF_FOLDER" => "/sinks-components/",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PRICE_CODE" => array(
					"BASE" //Символьный код типов цен
				),
				"PAGE_ELEMENT_COUNT" => 20,
				"ELEMENT_SORT_FIELD" => "PROPERTY_POPULAR_PRICE_SORT",
				"ELEMENT_SORT_ORDER" => "desc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"SECTION_USER_FIELDS" => array("UF_BANNER_TEXT", "UF_BANNER_BRAND_TEXT"),
				//"DETAIL_OFFERS_PROPERTY_CODE" => array("DLINA", "SHIRINA"),
				//"DETAIL_OFFERS_FIELD_CODE" => array("ID", "NAME"),
				"FILTER_NAME" => "arrFilter"
			),
			//Список товаров
			"productsListParams" => array(
				"OFFERS_SORT_FIELD" => "PROPERTY_DLINA",
				"OFFERS_SORT_FIELD2" => "PROPERTY_SHIRINA",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_ORDER2" => "asc",
				"OFFERS_PROPERTY_CODE" => array(
					//"DLINA",
					//"SHIRINA",
				), //Выбрать свойства торговых предложений
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				"OFFERS_FIELD_CODE" => array("NAME", "ID", "IBLOCK_ID"),
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PRICE_VAT_INCLUDE" => "Y",
				"ELEMENT_PROPERTIES_SELECT" => array(
					"PROPERTY_STIKER_NOVINKA",
					"PROPERTY_STIKER_KHIT_PRODAZH",
					"PROPERTY_NALICHIE_NA_SAYTE",
					"PROPERTY_RATING",
					"PROPERTY_REVIEWS_COUNT"
				),
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"EDITABLE_FIELD_ID",
					"ELEMENT_SORT_FIELD",
					"ELEMENT_SORT_FIELD2",
					"ELEMENT_SORT_ORDER",
					"ELEMENT_SORT_ORDER2",
					"SECTION_USER_FIELDS",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"PRICE_CODE",
					"PAGE_ELEMENT_COUNT",
					"DEFAULT_LENGTH",
					"DEFAULT_WIDTH",
					"FILTER_NAME"
				)
			),
			//Настройка фильтра
			"filterParams" => array(
				"DISPLAY_ELEMENT_COUNT" => "Y",
				"XML_EXPORT" => "N",
				"CONVERT_CURRENCY" => "N",
				//"FILTER_NAME" => "arrFilter",
				"HIDE_NOT_AVAILABLE" => "N",
				"INSTANT_RELOAD" => "N",
				"PAGER_PARAMS_NAME" => "arrPager",
				"POPUP_POSITION" => "left",
				"SAVE_IN_SESSION" => "N",
				"SEF_MODE" => "N",
				"CURRENCY_ID" => 1,
				//Наследуемые свойства
				"INHERIT" => array(
					"IBLOCK_ID",
					"IBLOCK_TYPE",
					"LP_IBLOCK_ID",
					"PRICE_CODE",
					"CACHE_FILTER",
					"CACHE_GROUPS",
					"CACHE_TIME",
					"CACHE_TYPE",
					"FILTER_NAME",
				)
			),
			//Поля по которым возможна сортировка
			"sortFields" => array(
				"PROPERTY_POPULAR_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //Популярное
				"PROPERTY_MIN_PRICE_SORT" => array("DELETE_SORT_FIELD2" => false), //По минимальной цене
				"PROPERTY_DISCOUNT_SORT" => array("DELETE_SORT_FIELD2" => false), //По скидке
				"PROPERTY_RATING" => array("DELETE_SORT_FIELD2" => false), //По рейтингу
				"PROPERTY_REVIEWS_COUNT" => array("DELETE_SORT_FIELD2" => false), //По отзывам
				"id" => array("DELETE_SORT_FIELD2" => true), //По новизне
			),
			//Вид каталога
			"viewTypes" => array(
				"short" => array("TYPE" => "short", "CLASS" => "sst-icon--view-list-t1"),
				"tiles" => array("TYPE" => "tiles", "CLASS" => "sst-icon sst-icon--view-tile-t1"),
				"row" => array("TYPE" => "row", "CLASS" => "sst-icon--view-block-t1"),
			),
			//Настройки для автообновления свойства сортировки по популярности
			"sortPropertiesUpdateSettings" => array(
				"INTERMEDIATE_PRICE_VALUE" => 50,
				"LEFT_LIMIT" => 20,
				"RIGHT_LIMIT" => 20
			)
		),
	);

	static $arExcludePropsFromDetail = array(
		"CML2_BAR_CODE",
		"CML2_ATTRIBUTES",
		"CML2_BASE_UNIT",
		"CML2_TAXES",
		"STIKER_NOVINKA",
		"NALICHIE_NA_SAYTE",
		"CML2_TRAITS",
		"CML2_ARTICLE",
		"STIKER_KHIT_PRODAZH",
		"KOLICHESTVO_DNEY_DOSTAVKI_OT",
		"KOLICHESTVO_DNEY_DOSTAVKI_DO",
		"MASSA_DLYA_DOSTAVKI",
		"OBEM_DLYA_DOSTAVKI",
		"VYSOTA_DLYA_DOSTAVKI",
		"GLUBINA_DLYA_DOSTAVKI",
		"SHIRINA_DLYA_DOSTAVKI",
		"MORE_PHOTO",
		"SPETSIALNOE_PREDLOZHENIE",
		"FILES",
		"VIDEO",
		"CML2_MANUFACTURER",
		"KOLICHESTVO_MEST",
		"POPULAR_PRICE_SORT",
		"MIN_PRICE_SORT",
		"REVIEWS_COUNT",
		"RATING",
		"PRODUKT",
		"VYVOD_V_VIDZHET_KHIT_PRODAZH",
		"VYVOD_V_VIDZHET_NOVINKA",
		"NE_VYGRUZHAT_V_YANDEKS_MARKET",
		"NALICHIE_V_YANDEKS_MARKETE",
		"STOIMOST_PODEMA_NA_ETAZH",
		"STOIMOST_USTANOVKI",
	);

	static function getCatalogParams($catalogType = "", $arKey = "", $inherit = false)
	{
		$catalogInfo = $return = self::$arCatalogInfo;
		if(!empty($catalogType) && array_key_exists($catalogType, $catalogInfo))
		{
			$return = $catalogInfo[$catalogType];
			$catalogTypeExists = true;
		}
		if($catalogTypeExists && !empty($arKey) && array_key_exists($arKey, $catalogInfo[$catalogType]))
			$return = $catalogInfo[$catalogType][$arKey];

		if($inherit)
			$return = self::getInheritedParams($catalogType, $return);

		return $return;
	}

	static function getInheritedParams($catalogType, $arParams)
	{
		$arCatalogParams = self::getCatalogParams($catalogType, "catalogParams");
		if(!empty($arParams["INHERIT"]))
		{
			foreach($arParams["INHERIT"] as $paramName)
			{
				if(!empty($arCatalogParams[$paramName]))
				{
					$arParams[$paramName] = $arCatalogParams[$paramName];
				}
			}
		}
		unset($arParams["INHERIT"]);
		
		return $arParams;
	}

	static function getLengthWidthArray(array $arLength, array $arWidth)
	{
		if(empty($arLength) || empty($arWidth))
			return false;

		$arResult = array();

		//Все значения длины
		$arLength = array_unique(array_filter($arLength, function($v){
			if(!empty($v))
				return $v;
		}));
		arsort($arLength);
		$arLength = array_values($arLength);

		//Все значения ширины
		$arWidth = array_unique(array_filter($arWidth, function($v){
			if(!empty($v))
				return $v;
		}));
		arsort($arWidth);
		$arWidth = array_values($arWidth);

		//Все значения комбинаций длины и ширины
		for($lengthIteration = count($arLength); $lengthIteration > 0; $lengthIteration--)
		{
			for($widthIteration = count($arWidth); $widthIteration > 0; $widthIteration--) {
				$arResult[] =  $arLength[$lengthIteration - 1] . "x" . $arWidth[$widthIteration - 1];
			}
		}
		unset($arWidth);
		unset($arLength);
		
		return $arResult;
	}

	static function getIblocksId()
	{
		$arIblocks = [];
		$arCatalogs = self::getCatalogParams();
		foreach($arCatalogs as $arCatalog)
		{
			if(!empty($arCatalog['catalogParams']['IBLOCK_ID']))
				$arIblocks[] = $arCatalog['catalogParams']['IBLOCK_ID'];
		}

		return $arIblocks;
	}
}