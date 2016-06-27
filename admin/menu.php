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
	)
);