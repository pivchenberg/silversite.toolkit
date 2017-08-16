<?php
namespace Silversite\Toolkit\SimpleAjax\Handlers;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Silversite\Toolkit\SimpleAjax\IAjaxHandler;
use Bitrix\Sale;


class NotInStockRequestSimpleHandler implements IAjaxHandler
{
	private $request;
	private $context;
	private $phone;
	private $username;
	private $offerId;
	const MAIL_EVENT_NAME = 'SILVERSITE_CALLBACK';

	public function __construct()
	{
		$this->context = Context::getCurrent();
		$this->request = $this->context->getRequest();
		$this->phone = $this->request->get('phone');
		$this->username = $this->request->get('username');
		$this->offerId = abs((int) $this->request->get('offerId'));
	}

	public function handleRequest()
	{
		$arReturn = [];
		$arReturn["success"] = false;

		if(empty($this->phone))
		{
			$arReturn["errors"]['phone'] = "Необходимо ввести телефон";
		}

		if(empty($this->offerId))
		{
			$arReturn["errors"]['phone'] = "Не указан товар для оформления заявки";
		}

		if(empty($arReturn["errors"] && Loader::includeModule('iblock'))) {
			\CModule::IncludeModule('iblock');
			//Получаем информацию по модели торгового предложения
			$dbRes = \CIBlockElement::GetList(
				[],
				["=ID" => \CIBlockElement::SubQuery(
					"PROPERTY_CML2_LINK",
					array(
						"ID" => $this->offerId
					)
				)
				],
				false,
				false,
				[
					"ID",
					"IBLOCK_ID",
					"NAME",
					"DETAIL_PAGE_URL"
				]
			);
			$arProduct = $dbRes->GetNext();

			if(!empty($arProduct))
			{

				\CEvent::Send(
					self::MAIL_EVENT_NAME,
					$this->context->getSite(),
					[
						'FORMTYPE' => 'Заявка на товар (нет в наличии)',
						'USERNAME' => $this->username,
						'PHONE' => $this->phone,
						'FORMURL' => $arProduct['DETAIL_PAGE_URL'],
						'PRODUCT_NAME' => $arProduct['NAME']
					]
				);

				$arReturn['success'] = true;
			}
		}

		echo json_encode($arReturn);
	}
}