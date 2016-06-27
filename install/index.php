<?
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use Silversite\Toolkit\EditableFields\EditableFieldsTable;

Loc::loadMessages(__FILE__);


Class silversite_toolkit extends CModule
{
	public $MODULE_ID = 'silversite.toolkit';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_CSS;
	public $strError = '';

	protected $newsIblockId = "";

	const NEWS_IBLOCK_TYPE_ID = "silvetsite_news";
	const NEWS_IBLOCK_CODE = "silversite_news_line";

	function __construct()
	{
		$arModuleVersion = array();
		include(__DIR__."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("SS_TK_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("SS_TK_MODULE_DESCRIPTION");

		$this->PARTNER_NAME = Loc::getMessage("SS_TK_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("SS_TK_PARTNER_URI");
	}
	

	function DoInstall()
	{
		global $APPLICATION;
		
        if($this->isVersionD7())
        {
	        //Регистрируем модуль
	        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
	        \Bitrix\Main\Loader::includeModule($this->MODULE_ID);

	        //Добавляем инфоблоки
	        $this->installIblocks();
	        $this->installTables();

        }
        else
        {
	        throw new Bitrix\Main\LoaderException(Loc::getMessage("SS_TK_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("SS_TK_INSTALL_TITLE"), $this->GetPath()."/install/step.php");
	}

	public function installIblocks() {
		//Создадаем инфоблок новостей
		//$this->createNewsIblock();
	}

	public function installTables() {

		$arQuery = EditableFieldsTable::getEntity()->compileDbTableStructureDump();
		if($arQuery[0])
			$this->GetConnection()->query($arQuery[0]);
	}

	//Создание инфоблока новостей с тестовыми данными
	public function createNewsIblock() {
		
		global $APPLICATION, $DB, $USER;

		if(!\Bitrix\Main\Loader::includeModule("iblock"))
			throw new  Bitrix\Main\LoaderException(Loc::getMessage("SS_TK_IBLOCKS_NOT_INSTALLED"));

		//Тип инфоблока
		$arFields = array(
			'ID' => self::NEWS_IBLOCK_TYPE_ID,
			'SECTIONS' => 'N',
			'IN_RSS' => 'N',
			'SORT' => 100,
			'LANG' => array(
				'en'=> array(
					'NAME' => 'News',
					'ELEMENT_NAME' => 'Article'
				),
				'ru'=> array(
					'NAME' => 'Новости',
					'ELEMENT_NAME' => 'Новость'
				)
			)
		);

		$obBlockType = new \CIBlockType;
		$DB->StartTransaction();
		$res = $obBlockType->Add($arFields);
		if(!$res)
		{
			$DB->Rollback();
			throw new Bitrix\Main\DB\ConnectionException($obBlockType->LAST_ERROR);
		}
		else
			$DB->Commit();

		//Инфоблок новостей
		//TODO: включить автозаполнение символьного кода
//		$obIblock = new \CIBlock();
//		$arFields = array(
//			"ACTIVE" => "Y",
//			"NAME" => "Новостная лента",
//			"CODE" => self::NEWS_IBLOCK_CODE,
//			"IBLOCK_TYPE_ID" => self::NEWS_IBLOCK_TYPE_ID,
//			"SITE_ID" => "s1", //TODO: захардкодил, переделать
//			"SORT" => 100,
//			"GROUP_ID" => Array("1" => "X", "2"=>"R"),
//			"VERSION" => 2 //Хранить свойства в отдельной таблице
//		);
//		$iblockId = $obIblock->Add($arFields);
//
//		if(!$iblockId)
//			throw new Bitrix\Main\DB\ConnectionException($obIblock->LAST_ERROR);

		$iblockId = ImportXMLFile(
			$this->getPath()."/install/xml/silversite-news-line.xml", //file path
			self::NEWS_IBLOCK_TYPE_ID,                                //iblock type
			"s1",                                                     //site id
			"N",                                                      //section action
			"A",                                                      //element action
			true,                                                     //use_crc
			false,                                                    //preview
			true,                                                     //sync
			true,                                                     //return_last_error
			true                                                      //return_iblock_id
		);


		if((int) $iblockId == 0)
			throw new Bitrix\Main\DB\ConnectionException($iblockId);


		//TODO: проверки, лог!
		$this->newsIblockId = $iblockId;
		//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/admin/iblock_convert.php");


		//NOPE
//		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/install/wizard_sol/utils.php");
//		$test = WizardServices::ImportIBlockFromXML(
//			$this->getPath()."/install/xml/silversite-news-line.xml",
//			self::NEWS_IBLOCK_CODE,
//			self::NEWS_IBLOCK_TYPE_ID,
//			"s1"
//		);
//		tdump($test);
//		tdump(13231);





//
//		//Инфоблок новостей
//		//TODO: включить автозаполнение символьного кода
//		//TODO: изменить место хранения свойст в отдельной таблице
//		$obIblock = new \CIBlock();
//		$arFields = array(
//			"ACTIVE" => "Y",
//			"NAME" => "Новостная лента",
//			"CODE" => "silversite_news",
//			"LIST_PAGE_URL" => "#SITE_DIR#/silversite-news/",
//			"SECTION_PAGE_URL" => "",
//			"DETAIL_PAGE_URL" => "#SITE_DIR#/silversite-news/#ELEMENT_CODE#/",
//			"IBLOCK_TYPE_ID" => self::NEWS_IBLOCK_TYPE_ID,
//			"SITE_ID" => "s1", //TODO: захардкодил, переделать
//			"SORT" => 100,
//			"GROUP_ID" => Array("1" => "X", "2"=>"R")
//		);
//		$iblockId = $obIblock->Add($arFields);
//
//		if(!$iblockId)
//			throw new Bitrix\Main\DB\ConnectionException($obIblock->LAST_ERROR);
//
//		//Свойства
//		//Время чтения статьи
//		$arFields = Array(
//			"NAME" => "Время чтения статьи",
//			"ACTIVE" => "Y",
//			"SORT" => "100",
//			"CODE" => "READ_TIME",
//			"PROPERTY_TYPE" => "N",
//			"IBLOCK_ID" => $iblockId,
//		);
//
//		$ibp = new \CIBlockProperty;
//		$PropID = $ibp->Add($arFields);
//
//		//Популярная статья
//		$arFields = array(
//			"NAME" => "Популярная статья",
//			"ACTIVE" => "Y",
//			"SORT" => "100",
//			"CODE" => "POPULAR",
//			"PROPERTY_TYPE" => "L",
//			"LIST_TYPE" => "C",
//			"IBLOCK_ID" => $iblockId
//		);
//		$arFields["VALUES"][0] = Array(
//			"VALUE" => "Y",
//			"DEF" => "N",
//			"SORT" => "100"
//		);
//		$ibp = new \CIBlockProperty;
//		$PropID = $ibp->Add($arFields);
//
//		//Просмотры
//		$arFields = array(
//			"NAME" => "Просмотры",
//			"ACTIVE" => "Y",
//			"SORT" => "100",
//			"CODE" => "VIEWS",
//			"PROPERTY_TYPE" => "N",
//			"IBLOCK_ID" => $iblockId
//		);
//		$ibp = new \CIBlockProperty;
//		$PropID = $ibp->Add($arFields);
//
//		//Добавление тестовых элементов
//		//TODO: возможно перенести добавлением тестовых значений в xml
//		$property_enums = CIBlockPropertyEnum::GetList(
//			array(),
//			array(
//				"IBLOCK_ID" => $iblockId,
//				"CODE" => "POPULAR"
//			)
//		);
//		$arPopularProp = $property_enums->GetNext();
//
//		$arLoadElements = array();
//		$arLoadElements = array(
//			array(
//				"MODIFIED_BY"    => $USER->GetID(),
//				"IBLOCK_SECTION_ID" => false,
//				"ACTIVE"         => "Y",
//				"IBLOCK_ID"      => $iblockId,
//				"CODE"           => "news-1",
//				"NAME"           => "Задачи интернет магазина - продажи",
//				"PREVIEW_TEXT"   => "Бесплатный вводный семинар для владельцев интернет-магазинов и тех, кто только собирается перейти из оффлайна в онлайн.",
//				"DETAIL_TEXT"    => "Detail text",
//				"PREVIEW_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news2.jpg"),
//				"DETAIL_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news8.png"),
//				"PROPERTY_VALUES"=> array(
//					"READ_TIME" => 60*4,
//					"POPULAR" => $arPopularProp["ID"],
//					"VIEWS" => 2
//				)
//			),
//			array(
//				"MODIFIED_BY"    => $USER->GetID(),
//				"IBLOCK_SECTION_ID" => false,
//				"ACTIVE"         => "Y",
//				"IBLOCK_ID"      => $iblockId,
//				"CODE"           => "news-2",
//				"NAME"           => "Совместный семинар SilverSite и Binario",
//				"PREVIEW_TEXT"   => "17 мая состоялся совместный семинар веб-студии SilverSite с агентством интернет-маркетинга Binario на тему «Повышение эффективности рекламы в интернете».",
//				"DETAIL_TEXT"    => "Detail text",
//				"PREVIEW_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news1.jpg"),
//				"DETAIL_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news7.png"),
//				"PROPERTY_VALUES"=> array(
//					"READ_TIME" => 60,
//					"VIEWS" => 5
//				)
//			),
//			array(
//				"MODIFIED_BY"    => $USER->GetID(),
//				"IBLOCK_SECTION_ID" => false,
//				"ACTIVE"         => "Y",
//				"IBLOCK_ID"      => $iblockId,
//				"CODE"           => "news-3",
//				"NAME"           => "Он-лайн бизнес за 80 000 рублей",
//				"PREVIEW_TEXT"   => "Если у вас есть готовый бизнес, и вы хотите запустить его в онлайн через 3 дня – у нас есть специальное предложение!",
//				"DETAIL_TEXT"    => "Detail text",
//				"PREVIEW_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news1.jpg"),
//				"DETAIL_PICTURE" => \CFile::MakeFileArray($this->getPath()."/install/images/news-list-test-images/news7.png"),
//				"PROPERTY_VALUES"=> array(
//					"READ_TIME" => 60*3,
//					"VIEWS" => 15
//				)
//			)
//		);
//
//		$el = new \CIBlockElement;
//		foreach($arLoadElements as $arLoadElement) {
//			if($PRODUCT_ID = $el->Add($arLoadElement)) {
//				echo 'New ID: '.$PRODUCT_ID;
//			} else {
//				echo 'Error: '.$el->LAST_ERROR;
//			}
//		}

	}
	
	public function DoUninstall()
	{
		\Bitrix\Main\Loader::includeModule($this->MODULE_ID);
		$this->uninstallIblocks();
		$this->uninstallTables();
		\Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
	}

	/*
	 * Удаляем инфоблоки
	 *
	 * */
	private function uninstallIblocks() {
		//Удаляем информационный блок новостей
		//$this->deleteNewsIblock();
	}

	/*
	 * Удаляем таблицы
	 *
	 * */
	public function uninstallTables() {
		$this->GetConnection()->dropTable(EditableFieldsTable::getTableName());
	}

	function deleteNewsIblock() {
		global $APPLICATION, $DB;

		if(!\Bitrix\Main\Loader::includeModule("iblock"))
			throw new Bitrix\Main\LoaderException(Loc::getMessage("SS_TK_IBLOCKS_NOT_INSTALLED"));

		$DB->StartTransaction();
		if(!\CIBlockType::Delete(self::NEWS_IBLOCK_TYPE_ID))
		{
			$DB->Rollback();
			throw new Bitrix\Main\LoaderException("News Iblock Delete error");
		}
		$DB->Commit();
	}


	public function GetPath($notDocumentRoot = false)
	{
		if($notDocumentRoot)
			return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
		else
			return dirname(__DIR__);
	}

	public function isVersionD7()
	{
		return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
	}


	protected function GetConnection()
	{
		return Application::getInstance()->getConnection(EditableFieldsTable::getConnectionName());
	}
}
?>
