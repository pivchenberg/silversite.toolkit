<?php

namespace Silversite\Toolkit\EditableFields;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Entity;
use Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

/**
 * Модель новостей.
 */
class EditableFieldsTable extends DataManager
{
	const CACHE_TIME = 31536000;
	const CACHE_PATH = "/editable_fields";

	/**
	 * {@inheritdoc}
	 */
	public static function getTableName()
	{
		return 'ss_editable_fields';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime',
				'title' => "Дата создания",
				'default_value' => new DateTime()
			),
			'CREATED_BY' => array(
				'data_type' => 'integer',
				'title' => "Кем создано",
				'default_value' => static::getUserId()
			),
			'MODIFIED_BY' => array(
				'data_type' => 'integer',
				'title' => "Кем изменено",
				'default_value' => static::getUserId()
			),
			'NAME' => array(
				'data_type' => 'string',
				'title' => "Название",
                'required' => true
			),
			'VALUE' => array(
				'data_type' => 'text',
				'title' => "Значение"
			),
			// Для всех полей, используемых визивигом, нужно создавать в таблице атрибут с суффиксом _TEXT_TYPE.
			// В нём будет храниться информация о типе сохранённого контента (ХТМЛ или обычный текст).
			'VALUE_TEXT_TYPE' => array(
				'data_type' => 'string'
			),
			'VALUE_TYPE' => array(
				'data_type' => 'string',
				'title' => "Тип значения"
			),
		);
	}

	public static function onBeforeUpdate(Entity\Event $event)
	{
		self::clearEditableFieldsCache();
		/*
		$result = new Entity\EventResult;
		$data = $event->getParameter("fields");

		$result->addError(new Entity\FieldError(
			$event->getEntity()->getField('ID'),
			'Запрещено менять ID код'
		));

		return $result;
		*/
	}

	static function getEditableFieldsArray()
	{
		$obCache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheId = self::CACHE_TIME.self::CACHE_PATH;
		if($obCache->initCache(self::CACHE_TIME, $cacheId, self::CACHE_PATH))
		{
			$arResult = $obCache->getVars();
		}
		elseif($obCache->startDataCache())
		{
			$dbResult = self::getList();
			while($row = $dbResult->fetch()) 
			{
				//TODO: вывод разных типов значений
				static::setDisplaedValue($row);
				$arResult[$row["ID"]] = $row;
			}
			$cache_manager = Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache(self::CACHE_PATH);
			$cache_manager->registerTag(self::CACHE_PATH);
			$cache_manager->endTagCache();
			$obCache->endDataCache($arResult);
		}
		return $arResult;
	}

	static function setDisplaedValue(array &$row) {

		switch($row["VALUE_TYPE"])
		{
			case "number":
				$row["DISPLAYED_VALUE"] = (int) $row["VALUE"];
				break;
			case "file":
				$row["DISPLAYED_VALUE"] = \CFile::GetFileArray($row["VALUE"]);
				break;
			case "image":
				$row["DISPLAYED_VALUE"] = \CFile::GetFileArray($row["VALUE"]);
				break;
			case "gmap":
				list($lat, $lng) = explode(",", $row["VALUE"]);
				$row["DISPLAYED_VALUE"] = round($lat, 5) . ", " . round($lng, 5);
				break;
			default:
				$row["DISPLAYED_VALUE"] = $row["VALUE"];
			break;
		}
	}

	static function clearEditableFieldsCache()
	{
		$cache_manager = Application::getInstance()->getTaggedCache();
		$cache_manager->clearByTag(self::CACHE_PATH);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function update($primary, array $data)
	{
		$data['MODIFIED_BY'] = static::getUserId();

		return parent::update($primary, $data);
	}

	/**
	 * Возвращает идентификатор пользователя.
	 *
	 * @return int|null
	 */
	public static function getUserId()
	{
		global $USER;

		return $USER->GetID();
	}

	public static function getFilePath()
	{
		return __FILE__;
	}
}
