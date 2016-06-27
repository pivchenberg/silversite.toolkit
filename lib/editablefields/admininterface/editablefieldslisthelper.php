<?php

namespace Silversite\Toolkit\EditableFields\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminListHelper;

/**
 * Хелпер описывает интерфейс, выводящий список новостей.
 *
 * {@inheritdoc}
 */
class EditableFieldsListHelper extends AdminListHelper
{
	protected static $model = '\Silversite\Toolkit\EditableFields\EditableFieldsTable';
}