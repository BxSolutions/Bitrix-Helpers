<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class SaleOrderQuery extends AbstractQuery
{

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('sale');

		$this->dataProvider = New \CSaleOrder;
	}

	/**
	 * Run CSaleOrder::GetList(
	 * array arOrder = Array("ID"=>"DESC"),
	 * array arFilter = Array(),
	 * array arGroupBy = false,
	 * array arNavStartParams = false,
	 * array arSelectFields = array()
	 * );
	 * https://dev.1c-bitrix.ru/api_help/sale/classes/csaleorder/csaleorder__getlist.41061294.php
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

}
