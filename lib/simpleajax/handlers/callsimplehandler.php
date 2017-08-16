<?php
namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Silversite\Toolkit\SimpleAjax\IAjaxHandler;

class CallSimpleHandler implements IAjaxHandler
{
	public function handleRequest()
	{
		//settings
		$formID = 1;
		$mailTemplate = "SILVERSITE_CALLBACK";
		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		$arResult = array();
		//Список входящих полей
		$arPostFields = array(
			"username" => array("FORM_NAME_ID" => "form_text_1"),
			"phone" => array("FORM_NAME_ID" => "form_text_2"),
			"email" => array("FORM_NAME_ID" => "form_email_3"),
			"comment" => array("FORM_NAME_ID" => "form_textarea_4"),
			"formtype" => array("FORM_NAME_ID" => "form_text_5"),
			"formurl" => array("FORM_NAME_ID" => "form_text_6"),
			"formquerystring" => array("FORM_NAME_ID" => "form_text_7")
		);
		//settings

		foreach($arPostFields as $k => &$arPost)
			$arPost["VALUE"] = $request->getPost($k);

		if(!empty($arPostFields["email"]["VALUE"]) && !filter_var($arPostFields["email"]["VALUE"], FILTER_VALIDATE_EMAIL))
			$arResult["errors"]["email"] = "Значение поля Email некорректно";

		if(empty($arPostFields["phone"]["VALUE"]) && empty($arPostFields["email"]["VALUE"]))
		{
			$arResult["errors"]["email"] = "Одно из полей должно быть заполнено";
			$arResult["errors"]["phone"] = "Одно из полей должно быть заполнено";
		}

		if(empty($arResult["errors"])) {
			if(\CModule::IncludeModule("form")) {
				$arFormResult = array();
				$arSendResult = array();
				foreach($arPostFields as $k => $arFields)
				{
					$arFormResult[$arFields["FORM_NAME_ID"]] = $arFields["VALUE"];
					$arSendResult[strtoupper($k)] = $arFields["VALUE"];
				}

				if($resultID = \CFormResult::Add($formID, $arFormResult, "N", false)) {
					$arSendResult["RESULT_ID"] = $resultID;
					$arSendResult["RESULT_URL"] = "http://". $_SERVER["SERVER_NAME"] ."/bitrix/admin/form_result_edit.php?lang=ru&WEB_FORM_ID=1&RESULT_ID=" . $resultID ."&WEB_FORM_NAME=SIMPLE_FORM_1";

					\CEvent::Send(
						$mailTemplate,
						"s1",
						$arSendResult
					);
					$arResult["success"] = true;
					$arResult["res"] = $arSendResult;
					//$arResult["ADD_RESULT"] = $arFormResult;
					//$arResult["RESULT_ID"] = $resultID;
					//$arResult["POST"] = $arPostFields;
				} else {
					global $strError;
					$arResult["errors"]["username"] = $strError;
				}
			} else {
				$arResult["errors"]["username"] = "Модуль форм не подключен";
			}
		}

		echo json_encode($arResult);
	}
}