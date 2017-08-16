<?php

namespace Silversite\Toolkit\EditableFields\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminEditHelper;

/**
 * Хелпер описывает интерфейс, выводящий форму редактирования новости.
 *
 * {@inheritdoc}
 */
class EditableFieldsEditHelper extends AdminEditHelper
{
    protected static $model = '\Silversite\Toolkit\EditableFields\EditableFieldsTable';
}