<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class UserQuery extends AbstractQuery
{

	/**
	 * User fields in select
	 * @var array 
	 */
	protected $ufFields = array();

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('main');

		$this->dataProvider = New \CUser;
	}

	/**
	 * Run CDBResult CUser::GetList(
	  mixed &by = "timestamp_x",
	  string &order = "desc",
	  array filter = array(),
	  array arParams=array()
	  )
	 * https://dev.1c-bitrix.ru/api_help/main/reference/cuser/getlist.php
	 * 
	 * @return CDBResult
	 */
	protected function getList()
	{
		
		$arParams = array();

		$select = $this->getSelect();

		$arParams['FIELDS'] = $select;

		foreach ($select as $field) {
			if (substr($field, 0, 3) === 'UF_') {
				$arParams['SELECT'][] = $field;
			}
		}

		$limit = $this->getLimit();

		if ($limit > 0) {
			$arParams['NAV_PARAMS']['nTopCount'] = $limit;
		}

		return $this->dataProvider->GetList(($this->getOrder()), ($asc = ''), $this->getWhere(), $arParams);
	}

}
