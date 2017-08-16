<?php
namespace Silversite\Toolkit\SimpleAjax;

use \Bitrix\Main\Context;

Class SimpleAjaxController
{
	protected static $instance = null;
	public $ajaxFieldName = "ajaxOperationType";
	public $handlersInterfaceName = 'Silversite\Toolkit\SimpleAjax\IAjaxHandler';

	protected function __construct(){}

	static function getInstance()
	{
		if(empty(self::$instance))
			self::$instance = new self;

		return self::$instance;
	}

	public function catchSimpleAjaxRequest()
	{
		global $APPLICATION;

		$request = Context::getCurrent()->getRequest();
		$isAjax = $request->isAjaxRequest();
		$ajaxType = $request->getPost($this->ajaxFieldName);

		//looking for handler class
		$className = "Silversite\\Toolkit\\SimpleAjax\\Handlers\\" . ucfirst($ajaxType) . "SimpleHandler";
		if($isAjax && !empty($ajaxType) && class_exists($className))
		{
			$rc = new \ReflectionClass($className);
			$arInterfaces = $rc->getInterfaceNames();

			if(
				$rc->isInstantiable() &&
				in_array($this->handlersInterfaceName, $arInterfaces) &&
				!defined("ERROR_404")
			)
			{
				$APPLICATION->RestartBuffer();
				$obHandler = $rc->newInstance();
				$obHandler->handleRequest();
				die();
			}
		}
	}
}
