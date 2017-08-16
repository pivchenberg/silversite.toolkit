<?php

namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Mail\EventManager;
use Bitrix\Main\UserTable;
use Bitrix\Sale\Internals\OrderTable;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;

class WhereIsMyOrderSimpleHandler implements IAjaxHandler
{
	public function handleRequest()
	{
		global $USER, $APPLICATION;
		$context = Context::getCurrent();
		$request = $context->getRequest();
		$orderId = abs((int) $request->get("orderId"));

		Loader::includeModule("sale");
		$arOrder = OrderTable::getList(
			[
				"select" => ["ID"],
				"filter" => [
					"USER_ID" => $USER->GetID(),
					"ID" => $orderId
				],
				"limit" => 1
			]
		)->fetch();

		if(!empty($arOrder))
		{
			$arUser = UserTable::getList([
				"select" => ["*"],
				"filter" =>
					[
						"ID" => $USER->GetID(),
						"ACTIVE" => "Y"
					],
				"limit" => 1
			])->fetch();
			//$arUser;
			$sendResult = Event::send(
				[
					"EVENT_NAME" => "WHERE_IS_MY_ORDER",
				    "LID" => $context->getSite(),
				    "C_FIELDS" => [
						"ORDER_ID" => $arOrder["ID"],
					    "ORDER_URL" => "http://" . $_SERVER["SERVER_NAME"] . "/bitrix/admin/sale_order_view.php?ID=" . $arOrder["ID"] . "&filter=Y&set_filter=Y&lang=ru",
						"USER_NAME" => $arUser["NAME"],
						"USER_ID" => $arUser["ID"],
					    "EMAIL" => $arUser["EMAIL"],
					    "PHONE" => $arUser["PERSONAL_PHONE"],
					    "FORMTYPE" => "состояние заказа",
					    "FORMURL" => $APPLICATION->GetCurPage(),
					    "FORMQUERYSTRING" => $_SERVER["QUERY_STRING"]
					],
				]
			);
			
			if($sendResult)
			{
				echo json_encode(["success" => true]);
				return;
			}
		}

		echo json_encode(["success" => false]);
	}
}