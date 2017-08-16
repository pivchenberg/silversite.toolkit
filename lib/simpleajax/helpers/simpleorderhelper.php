<?php
namespace Silversite\Toolkit\SimpleAjax\Helpers;

use Bitrix\Sale;
use Bitrix\Main\Context;
use Bitrix\Sale\Delivery;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\Order;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;

class SimpleOrderHelper
{
	protected $username;
	protected $phone;
	protected $basket;
	static $usernameRequestName = "username";
	static $phoneRequestName = "phone";

	public function  __construct()
	{
		global $USER;
		Loader::includeModule("sale");

		$request = Context::getCurrent()->getRequest();
		$this->username = $request->getPost(self::$usernameRequestName);
		if(empty($this->username) && $USER->IsAuthorized())
			$this->username = $USER->GetFirstName();
		$this->phone = $request->getPost(self::$phoneRequestName);
		$this->basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());
	}

	public function createSimpleOrder($comment)
	{
		global $USER;

		//Оформляем заказ
		$siteId = Context::getCurrent()->getSite();
		$currencyCode = Option::get('sale', 'default_currency', 'RUB');
		
		$userId = $this->getUserId();
		$order = Order::create($siteId, $userId);
		$order->setPersonTypeId(1);
		$order->setBasket($this->basket);

		//Доставка
		$shipmentCollection = $order->getShipmentCollection();
		$shipment = $shipmentCollection->createItem();
		$shipmentItemCollection = $shipment->getShipmentItemCollection();
		$shipment->setField('CURRENCY', $order->getCurrency());
		foreach ($order->getBasket() as $item)
		{
			$shipmentItem = $shipmentItemCollection->createItem($item);
			$shipmentItem->setQuantity($item->getQuantity());
		}
		$arDeliveryServiceAll = Delivery\Services\Manager::getRestrictedObjectsList($shipment);
		$shipmentCollection = $shipment->getCollection();
		if (!empty($arDeliveryServiceAll)) {
			reset($arDeliveryServiceAll);
			$deliveryObj = current($arDeliveryServiceAll);
			if ($deliveryObj->isProfile()) {
				$name = $deliveryObj->getNameWithParent();
			} else {
				$name = $deliveryObj->getName();
			}
			$shipment->setFields(array(
				'DELIVERY_ID' => $deliveryObj->getId(),
				'DELIVERY_NAME' => $name,
				'CURRENCY' => $order->getCurrency()
			));
			$shipmentCollection->calculateDelivery();
		}

		//Оплата
		$arPaySystemServiceAll = [];
		$paySystemId = 1;
		$paymentCollection = $order->getPaymentCollection();
		$remainingSum = $order->getPrice() - $paymentCollection->getSum();
		if ($remainingSum > 0 || $order->getPrice() == 0)
		{
			$extPayment = $paymentCollection->createItem();
			$extPayment->setField('SUM', $remainingSum);
			$arPaySystemServices = PaySystem\Manager::getListWithRestrictions($extPayment);
			$arPaySystemServiceAll += $arPaySystemServices;
			if (array_key_exists($paySystemId, $arPaySystemServiceAll))
			{
				$arPaySystem = $arPaySystemServiceAll[$paySystemId];
			}
			else
			{
				reset($arPaySystemServiceAll);
				$arPaySystem = current($arPaySystemServiceAll);
			}
			if (!empty($arPaySystem))
			{
				$extPayment->setFields(array(
					'PAY_SYSTEM_ID' => $arPaySystem["ID"],
					'PAY_SYSTEM_NAME' => $arPaySystem["NAME"]
				));
			}
			else
				$extPayment->delete();
		}

		$order->doFinalAction(true);
		$propertyCollection = $order->getPropertyCollection();

		if(!empty($this->username))
		{
			$usernameProperty = self::getPropertyByCode($propertyCollection, 'username');
			$usernameProperty->setValue($this->username);
		}

		$phoneProperty = self::getPropertyByCode($propertyCollection, 'phone');
		$phoneProperty->setValue($this->phone);

		$order->setField('CURRENCY', $currencyCode);
		$order->setField('COMMENTS', $comment);
		$order->save();

		$sendArray = self::getSendArrays($order);
		$sendArray["ADMIN"]["COMMENT"] = $comment;
		\CEvent::SendImmediate("ORDER_CREATED_ADMIN", Context::getCurrent()->getSite(), $sendArray["ADMIN"]);
		$orderId = $order->getId();
		$_SESSION["SALE_ORDER_ID"][] = $orderId;

		return $orderId;
	}


	static function getPropertyByCode($propertyCollection, $code)  {
		foreach ($propertyCollection as $property)
		{
			if($property->getField('CODE') == $code)
				return $property;
		}
	}
	
	public function getUserId()
	{
		global $USER;
		
		if($USER->IsAuthorized())
		{
			$userId = $USER->GetID();
		}
		else
		{
			//Проверяем существует ли пользователь с таким телефоном
			$dbUserResult = UserTable::getList([
				"filter" => [
					"LOGIC" => "OR",
					[
						"LOGIN" => $this->phone,
					],
					[
						"PERSONAL_PHONE" => $this->phone
					],
				],
				"select" => ["ID", "NAME"]
			]);
			if($dbUserResult->getSelectedRowsCount() == 1)
			{
				$arUser = $dbUserResult->fetch();
				$userId = $arUser["ID"];
			}
			else
			{
				$userId = $this->createNewAnonUser();
			}
		}
		
		return $userId;
	}

	public function createNewAnonUser()
	{
		$anonUserEmail = "no_".randString(9)."@email.net";
		$arErrors = array();
		$userId = \CSaleUser::DoAutoRegisterUser(
			$anonUserEmail,
			array("NAME" => !empty($this->username) ? $this->username : "Анонимный пользователь"),
			SITE_ID,
			$arErrors,
			array("ACTIVE" => "N", "PERSONAL_PHONE" => $this->phone, "LOGIN" => $this->phone)
		);

		return $userId;
	}

	static public function getSendArrays(Order $order)
	{
		$arSend = [];
		$arOrder = $order->getFieldValues();
		$arOrder["PROPS"] = [];
		foreach($order->getPropertyCollection()->getArray()["properties"] as $arOrderProp)
		{
			$code = $arOrderProp["CODE"];
			$value = current($arOrderProp["VALUE"]);
			$arOrder["PROPS"][$code] = $value;
		}

		$arOrder["USER"] = UserTable::getByPrimary($arOrder["USER_ID"])->fetch();
		if(empty($arOrder["PROPS"]["email"]) || !filter_var($arOrder["PROPS"]["email"], FILTER_VALIDATE_EMAIL))
			$arOrder["PROPS"]["email"] = $arOrder["USER"]["EMAIL"];

		if(empty($arOrder["PROPS"]["username"]))
			$arOrder["PROPS"]["username"] = !empty($arOrder["USER"]["NAME"]) ? $arOrder["USER"]["NAME"] : "покупатель";

		//Корзина
		$arOrder["BASKET"] = [];
		foreach($order->getBasket() as $arBasketItem)
		{
			$arOrder["BASKET"][] = [
				"NAME" => $arBasketItem->getField("NAME"),
				"QUANTITY" => (int) $arBasketItem->getField("QUANTITY"),
				"PRICE" => $arBasketItem->getFinalPrice()
			];
		}

		//Доставка
		foreach($order->getShipmentCollection() as $obShipment)
			$arOrder["DELIVERY"] = $obShipment->getFieldValues();
		self::setDeliveryCustomName($arOrder["DELIVERY"]);
		$arOrder["DELIVERY"]["SERVICE"] = \Bitrix\Sale\Delivery\Services\Table::getById($arOrder["DELIVERY_ID"])->fetch();


		//Оплата
		foreach($order->getPaymentCollection() as $obPayment)
		{
			$arOrder["PAYMENT"] = $obPayment->getFieldValues();

			$paySystemService = PaySystem\Manager::getObjectById($obPayment->getPaymentSystemId());
			if (!empty($paySystemService)) {
				$arPaySysAction = $paySystemService->getFieldsValues();

				/** @var PaySystem\ServiceResult $initResult */
				$initResult = $paySystemService->initiatePay($obPayment, null, PaySystem\BaseServiceHandler::STRING);
				if ($initResult->isSuccess())
					$arPaySysAction['BUFFERED_OUTPUT'] = $initResult->getTemplate();
				else
					$arPaySysAction["ERROR"] = $initResult->getErrorMessages();
			}

			$arOrder["PAYMENT"]["ACTION"] = $arPaySysAction;
		}

		/*
		 * Переменные письма пользователю
		 * */
		$arSend = [
			"USER_EMAIL" => $arOrder["PROPS"]["email"],
			"NAME" => $arOrder["PROPS"]["username"],
			"ORDER_ID" => $arOrder["ID"],
			"AR_CART" => $arOrder["BASKET"],
			"DELIVERY_PRICE" => $arOrder["PRICE_DELIVERY"],
			"DELIVERY_NAME" => $arOrder["DELIVERY"]["DELIVERY_NAME"],
			"SUMM" => $arOrder["PRICE"] - $arOrder["PRICE_DELIVERY"],
			"ALL_SUMM" => $arOrder["PRICE"],
			"PAYMENT" => $arOrder["PAYMENT"]["PAY_SYSTEM_NAME"],
			"ADDRESS" => $arOrder["PROPS"]["address"],
			"COMMENT" => $arOrder["PROPS"]["comment"],
			"IS_ONLINE_PAYMENT" => !empty($arOrder["PAYMENT"]["ACTION"]["BUFFERED_OUTPUT"]),
			"IS_DELIVERY_BY_COURIER" => $arOrder["DELIVERY"]["DELIVERY_TYPE_CUSTOM_CODE"] == "courier",
			"STORE_ADDRESS" => !empty($arOrder["DELIVERY"]["SERVICE"]["DESCRIPTION"]) ? preg_replace('/###.+?###/i', "", strip_tags($arOrder["DELIVERY"]["SERVICE"]["DESCRIPTION"])) : "",
			//"ORDER" => $arOrder, //
		];

		/*
		 * Переменные письма админу
		 * */
		$arSendAdmin = $arSend;
		$arSendAdmin["NAME"] = $arOrder["PROPS"]["username"];
		$arSendAdmin["PHONE"] = $arOrder["PROPS"]["phone"];
		$arSendAdmin["IP"] = $_SERVER["REMOTE_ADDR"];

		return array("USER" => $arSend, "ADMIN" => $arSendAdmin);
	}


	public static function setDeliveryCustomName(array &$arDelivery)
	{
		$name = !empty($arDelivery["NAME"]) ? $arDelivery["NAME"] : $arDelivery["DELIVERY_NAME"];
		if(preg_match("/.*(самов|Самов).*/i", $name))
		{
			$arDelivery["DELIVERY_TYPE_CUSTOM_CODE"] = "pickup";
			$arDelivery["DELIVERY_TYPE_CUSTOM_NAME"] = "Самовывоз";
		}
		else
		{
			$arDelivery["DELIVERY_TYPE_CUSTOM_CODE"] = "courier";
			$arDelivery["DELIVERY_TYPE_CUSTOM_NAME"] = "Курьер";
		}
	}
}