<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class IBlockElementQuery extends AbstractQuery
{

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('iblock');

		$this->dataProvider = New \CIBlockElement;
	}

	/**
	 * Run CIBlockElement::GetList(
	  array arOrder = Array("SORT"=>"ASC"),
	  array arFilter = Array(),
	  mixed arGroupBy = false,
	  mixed arNavStartParams = false,
	  array arSelectFields = Array()
	  );
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/getlist.php
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
