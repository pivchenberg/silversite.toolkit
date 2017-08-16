<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Silversite\Toolkit\EditableFields\AdminInterface\EditableFieldsEditHelper;
use Silversite\Toolkit\EditableFields\AdminInterface\EditableFieldsListHelper;

if (!Loader::includeModule('digitalwand.admin_helper') || !Loader::includeModule('silversite.toolkit')) return;

Loc::loadMessages(__FILE__);

return array(
	array(
		'parent_menu' => 'global_menu_content',
		'sort' => 140,
		'icon' => 'fileman_sticker_icon',
		'page_icon' => 'fileman_sticker_icon',
		'text' => "Редактируемые поля",
		'url' => EditableFieldsListHelper::getUrl(),
		'more_url' => array(
			EditableFieldsEditHelper::getUrl(),
		)
	),
	array(
		"parent_menu" => "global_menu_marketing",
		"section" => "seo",
		"sort" => 900,
		"icon" => "extension_menu_icon",
		"page_icon" => "seo_page_icon",
		"module_id" => "seo",
		"items_id" => "menu_seo_custom",
		"url" => "seo_sitemap_custom.php?lang=".LANGUAGE_ID,
		"more_url" => array("seo_sitemap_edit.php?lang=".LANGUAGE_ID),
		"text" => "Создание sitemap.xml"
	)

);