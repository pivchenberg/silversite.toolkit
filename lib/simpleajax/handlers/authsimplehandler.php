<?php

namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;

class AuthSimpleHandler implements IAjaxHandler
{
	public function handleRequest()
	{
		global $USER, $APPLICATION;
		$request = Context::getCurrent()->getRequest();
		$login = $request->getPost("login");
		$password = $request->getPost("password");

		$arAuthResult = $USER->Login($login, $password, "Y", "Y");
		if(is_array($arAuthResult) && isset($arAuthResult["MESSAGE"]))
		{
			$arResult["errors"]["login"] = strip_tags($arAuthResult["MESSAGE"]);
			$arResult["errors"]["password"] = strip_tags($arAuthResult["MESSAGE"]);
		}
		else
		{
			$arResult["success"] = true;
			$arResult["redirect"] = $APPLICATION->GetCurPage();
		}

		echo json_encode($arResult);
	}
}