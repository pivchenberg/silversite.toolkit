# silversite.toolkit
Модуль для CMS битрикс разработанный для компании Silversite.

## Функционал
* Класс с настройками всех каталогов *Silversite\Toolkit\Catalog\SilverSiteCatalogSettings*
* Классы адаптированные для генерации sitemap.xml отличные от стандартного поведения Bitrix *Silversite\Toolkit\CustomSitemap*
* Редактируемые поля для всего сайта *Silversite\Toolkit\EditableFields* (необходима установка стороннего модуля [adminHelper](https://github.com/DigitalWand/digitalwand.admin_helper))
* Классы для работы со свойствами инфоблоков. Копия с [репозитория](https://github.com/unnamed777/IblockOrm)
* Обработчик простых ajax-запросов *Silversite\Toolkit\SimpleAjax*
* Копия дампера [symfony](https://github.com/symfony/var-dumper) *Silversite\Toolkit\VarDumper*
* Логгер *Silversite\Toolkit\Logogo*
* Запись utm-меток в cookies *Silversite\Toolkit\UtmCookies*
* Определение города по IP-адресу *Silversite\Toolkit\YourCity* с использование библиотеки [SxGeo](https://sypexgeo.net/ru/docs/)

## Установка
1. Скопировать файлы в дирректорию local/modules/silversite.toolkit
2. Произвести установку модуля из административной части сайта:
	* *Marketplace > Установленные решения*
	* В списке найти *SilverSite Toolkit (silversite.toolkit)* и выполнить установку