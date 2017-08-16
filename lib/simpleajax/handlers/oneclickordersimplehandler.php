<?php
namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;
use Bitrix\Sale;
use Silversite\Toolkit\SimpleAjax\Helpers\SimpleOrderHelper;

class OneClickOrderSimpleHandler extends SimpleOrderHelper implements IAjaxHandler
{
	protected $offerId;

	public function  __construct()
	{
		global $USER;
		Loader::includeModule("sale");

		$request = Context::getCurrent()->getRequest();
		$this->username = $request->getPost(parent::$usernameRequestName);
		if(empty($this->username) && $USER->IsAuthorized())
			$this->username = $USER->GetFirstName();
		$this->phone = $request->getPost(parent::$phoneRequestName);
		$this->offerId = abs((int) $request->getPost("offerId"));
		$this->basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
	}

	public function handleRequest()
	{
		$arReturn = [];

		if(empty($this->phone))
		{
			$arReturn["success"] = false;
			$arReturn["errors"][parent::$phoneRequestName] = "Необходимо ввести телефон";
		}

		if(empty($this->offerId))
		{
			$arReturn["success"] = false;
			$arReturn["errors"]["system_exception"] = "Пустой идентификатор товара.";
		}

		if(empty($arReturn["errors"]))
		{
			$oldBasket = $this->basket->createClone();

			//Удаляем корзину
			foreach($this->basket as $basketItem)
				$basketItem->delete();

			//Добавляем новый
			$newItem = $this->basket->createItem('catalog', $this->offerId);
			$newItem->setFields(array(
				'QUANTITY' => 1,
				'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
				'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
				'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
			));
			$this->basket->save();

			$arReturn["orderId"] = $this->createSimpleOrder('Заказ в 1 клик');

			//Возвращаем все в зад
			//Создаем новую корзину
			$this->basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
			foreach($oldBasket as $oldBasketItem)
			{
				$basketItem = $this->basket->createItem('catalog', $oldBasketItem->getField("PRODUCT_ID"));
				$basketItem->setFields(array(
					'QUANTITY' => $oldBasketItem->getField("QUANTITY"),
					'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
					'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
					'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
				));
				$arReturn[] = $oldBasketItem->getField("PRODUCT_ID");
			}
			$this->basket->save();
		}

		if(!empty($arReturn["orderId"]))
		{
			$arReturn["success"] = true;
			$arReturn["redirect"] = "/order/?ORDER_ID=" . $arReturn["orderId"];
		}
		else
			$arReturn["success"] = false;
		echo json_encode($arReturn);
	}
}