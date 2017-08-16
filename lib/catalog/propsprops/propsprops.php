<?php

namespace Silversite\Toolkit\Catalog\PropsProps;

use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\Query;

class PropsProps implements \ArrayAccess, \Iterator
{
	private $arPropsProps;

	public function __construct($iblockId, $boolList)
	{
		if(empty($iblockId))
			throw new ArgumentException("empty iblock id");

		$obProperties = PropertyTable::getList(
			array(
				"select" => array("ID", "XML_ID"),
				"filter" => array(
					"IBLOCK_ID" => $iblockId,
					"ACTIVE" => "Y"
				)
			)
		);
		$arPropsXmlId = array();
		while($arPropRow = $obProperties->fetch())
			$arPropsXmlId[$arPropRow["ID"]] = $arPropRow["XML_ID"];

		\Bitrix\Main\Loader::includeModule("highloadblock");
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById(1)->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();


		$arFilter = array(
			"select" => array("*"),
			"filter" => array(
				"UF_IBLOCKLINK" => $arPropsXmlId
			)
		);

		if($boolList)
		{
			$arFilter["filter"]["=UF_SHOWLIST"] = 1;
		}

		$obPropsProps = $strEntityDataClass::getList($arFilter);

		$arPropsProps = array();
		while($arPropsPropsRow = $obPropsProps->fetch())
			$arPropsProps[$arPropsPropsRow["UF_IBLOCKLINK"]] = $arPropsPropsRow;

		$this->arPropsProps = $arPropsProps;
	}

	public function addPropertyData()
	{
		if(!empty($this->arPropsProps))
		{
			$dbPropertyResult = PropertyTable::getList(
				[
					"filter" => [
						"ACTIVE" => 1,
						"XML_ID" => array_keys($this->arPropsProps)
					]
				]
			);
			while($arPropertyRow = $dbPropertyResult->fetch())
			{
				$xmlId = $arPropertyRow["XML_ID"];
				if(array_key_exists($xmlId, $this->arPropsProps))
					$this->arPropsProps[$xmlId]["IBLOCK_PROP"] = $arPropertyRow;
			}
		}
		return $this;
	}

	public function getArPropsProps()
	{
		return $this->arPropsProps;
	}

	public function offsetExists($offset)
	{
		return isset($this->arPropsProps[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->arPropsProps[$offset]) ? $this->arPropsProps[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->arPropsProps[] = $value;
		} else {
			$this->arPropsProps[$offset] = $value;
		}
	}

	public function offsetUnset($offset)
	{
		unset($this->arPropsProps[$offset]);
	}

	public function current()
	{
		return current($this->arPropsProps);
	}

	public function next()
	{
		next($this->arPropsProps);
	}

	public function key()
	{
		return key($this->arPropsProps);
	}

	public function valid()
	{
		return isset($this->arPropsProps[$this->key()]);
	}

	public function rewind()
	{
		reset($this->arPropsProps);
	}
}