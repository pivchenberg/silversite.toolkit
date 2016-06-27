<?php

namespace Silversite\Toolkit\EditableFields\AdminInterface;

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\FileWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\UrlWidget;
use DigitalWand\AdminHelper\Widget\ComboBoxWidget;
use DigitalWand\AdminHelper\Widget\UserWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;
use DigitalWand\AdminHelper\Widget\GMapWidget;
use Silversite\Toolkit\EditableFields\EditableFieldsTable;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class EditableFieldsAdminInterface extends AdminInterface
{
    /**
     * {@inheritdoc}
     */
    public function fields()
    {
	    $fieldsType = array(
		    "string" => "Строка",
		    "number" => "Число",
		    "visualEditor" => "Визуальный редактор",
		    "datetime" => "Дата и время",
		    "url" => "Url",
		    "file" => "Файл",
		    "image" => "Изображение",
		    "gmap" => "Google карты"
	    );

	    $request = Application::getInstance()->getContext()->getRequest();
	    $id = (int) $request->getQuery("ID");
	    $view = $request->getQuery("view");
	    $module = $request->getQuery("module");

	    $arEditFieldWidget = array(
		    'WIDGET' => new StringWidget(),
		    'HEADER' => true
	    );

	    if(!empty($id) && $module == "silversite.toolkit")
	    {
		    $listPage = true;
		    $arEditableField = EditableFieldsTable::getList(array("filter" => array("=ID" => $id)))->fetch();

		    switch($arEditableField["VALUE_TYPE"])
		    {
			    case "string":
				    $arEditFieldWidget = array(
					    'WIDGET' => new StringWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "number":
				    $arEditFieldWidget = array(
					    'WIDGET' => new NumberWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "visualEditor":
				    $arEditFieldWidget = array(
					    'WIDGET' => new VisualEditorWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "datetime":
				    $arEditFieldWidget = array(
					    'WIDGET' => new DateTimeWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "url":
				    $arEditFieldWidget = array(
					    'WIDGET' => new UrlWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "file":
				    $arEditFieldWidget = array(
					    'WIDGET' => new FileWidget(),
					    'REQUIRED' => true,
					    'HEADER' => true
				    );
			    break;
			    case "image":
				    $arEditFieldWidget = array(
					    'WIDGET' => new FileWidget(),
					    'HEADER' => true,
					    'IMAGE' => true
				    );
			    break;
			    case "gmap":
				    $arEditFieldWidget = array(
					    'WIDGET' => new GMapWidget(),
					    'HEADER' => true,
					    'REQUIRED' => true
				    );
			    break;
			    default:
				    $arEditFieldWidget = array(
					    'WIDGET' => new StringWidget(),
					    'HEADER' => true
				    );
			    break;
		    }
	    }

        return array(
            'MAIN' => array(
                'NAME' => "Редактируемые поля",
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    'NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => '%',
                        'REQUIRED' => true
                    ),
                    'VALUE' => $arEditFieldWidget,
	                "VALUE_TYPE" => array(
		                "WIDGET" => new ComboBoxWidget(),
		                "VARIANTS" => $fieldsType,
		                "HEADER" => true,
		                "EDIT_IN_LIST" => false,
                        'READONLY' => isset($listPage) ? $listPage : false,
	                )
                )
            ),
	        "META" => array(
		        "NAME" => "Данные записи",
		        "FIELDS" => array(
			        'DATE_CREATE' => array(
				        'WIDGET' => new DateTimeWidget(),
				        'READONLY' => true,
				        'HIDE_WHEN_CREATE' => true
			        ),
			        'CREATED_BY' => array(
				        'WIDGET' => new UserWidget(),
				        'READONLY' => true,
				        'HIDE_WHEN_CREATE' => true
			        ),
			        'MODIFIED_BY' => array(
				        'WIDGET' => new UserWidget(),
				        'READONLY' => true,
				        'HIDE_WHEN_CREATE' => true
			        ),
		        )
	        )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function helpers()
    {
        return array(
            '\Silversite\Toolkit\EditableFields\AdminInterface\EditableFieldsListHelper',
            '\Silversite\Toolkit\EditableFields\AdminInterface\EditableFieldsEditHelper'
        );
    }
}