<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class SaleOrderPropsValueQuery extends AbstractQuery
{

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('sale');

		$this->dataProvider = New \CSaleOrderPropsValue;
	}

	/**
	 * Run CSaleOrderPropsValue::GetList(
	 * array arOrder = array(),
	 * array arFilter = array(),
	 * array arGroupBy = false,
	 * array arNavStartParams = false,
	 * array arSelectFields = array()
	 * );
	 * https://dev.1c-bitrix.ru/api_help/sale/classes/csaleorderpropsvalue/csaleorderpropsvalue__getlist.52da0d54.php
	 * 
	 * @return CDBResult
	 */
	protected function getList()
	{
		$limit = $this->getLimit();

		if ($limit > 0) {
			$arNavStartParams = array('nTopCount' => $limit);
		} else {
			$arNavStartParams = false;
		}

		return $this->dataProvider->GetList($this->getOrder(), $this->getWhere(), false, $arNavStartParams, $this->getSelect());
	}

	/**
	 * Deletes row.
	 * 
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id)
	{
		return $this->dataProvider->delete($id)->result;
	}

}
