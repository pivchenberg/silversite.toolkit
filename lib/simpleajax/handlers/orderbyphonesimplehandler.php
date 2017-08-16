<?php
namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;
use Bitrix\Sale;
use Silversite\Toolkit\SimpleAjax\Helpers\SimpleOrderHelper;

class OrderByPhoneSimpleHandler extends SimpleOrderHelper implements IAjaxHandler
{

	public function handleRequest()
	{
		$arReturn = [];

		if(empty($this->phone))
		{
			$arReturn["success"] = false;
			$arReturn["errors"][parent::$phoneRequestName] = "Необходимо ввести телефон";
		}

		if(empty($arReturn["errors"]))
		{
			$arReturn["orderId"] = $this->createSimpleOrder('Быстрый заказ по телефону');

			if(!empty($arReturn["orderId"]))
			{
				$arReturn["success"] = true;
				$arReturn["redirect"] = "/order/?ORDER_ID=" . $arReturn["orderId"];
			}
			else
				$arReturn["success"] = false;
		}

		echo json_encode($arReturn);
	}
}