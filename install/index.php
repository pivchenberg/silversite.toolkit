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

	        //Файлы
	        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/silversite.toolkit/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);

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
	}
	
	public function DoUninstall()
	{
		\Bitrix\Main\Loader::includeModule($this->MODULE_ID);
		$this->uninstallIblocks();
		$this->uninstallTables();
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/silversite.toolkit/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
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
