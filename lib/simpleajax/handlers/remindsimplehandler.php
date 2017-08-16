<?php

namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Silversite\Toolkit\Components;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;

class RemindSimpleHandler implements IAjaxHandler
{
	public function handleRequest()
	{
		$request = Context::getCurrent()->getRequest();
		$mailTemplate = "CHANGE_PASSWORD";
		$userEmail = $request->getPost("login");

		//достаем запись о пользователе
		$arUser = \CUser::GetList(
			$by = "ASC",
			$order = "ID",
			array(
				"LOGIC" => "OR",
				array(
					"LOGIN" => $userEmail
				),
				array(
					"EMAIL" => $userEmail
				)
			),
			array("SELECT" => array("ID", "EMAIL", "CHECKWORD", "UF_DO_NOT_REGISTER"))
		)->GetNext();

		if(!empty($arUser) && !$arUser["UF_DO_NOT_REGISTER"])
		{
			$newUserPassword = randString(7);
			$obUser = new \CUser;
			$fields = array(
				"PASSWORD"          => $newUserPassword,
				"CONFIRM_PASSWORD"  => $newUserPassword,
			);
			
			if($obUser->Update($arUser["ID"], $fields))
			{
				$userName = Components::makeUpUserName($arUser["NAME"], $arUser["LAST_NAME"]);

				$arSendResult = array(
					"LOGIN" => $arUser["LOGIN"],
					"PASSWORD" => $newUserPassword,
					"EMAIL" => $userEmail,
					"USER_NAME" => $userName
				);

				if(\CEvent::Send($mailTemplate, "s1", $arSendResult))
				{
					$arResult["success"] = true;
					$arResult["test"] = $arSendResult;
				}
				else
					$arResult["errors"]["login"] = "Не удалось отправить письмо";

			}
			else
			{
				$arResult["errors"]["login"] = "Не удалось обновить пароль";
			}
		}
		else
		{
			$arResult["errors"]["login"] = "Неверно указана почта";
		}
		echo json_encode($arResult);
	}
}