<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class IBlockSectionQuery extends AbstractQuery
{

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('iblock');

		$this->dataProvider = New \CIBlockSection;
	}

	/**
	 * Run CIBlockSection::GetList(
	 * array arOrder = Array("SORT"=>"ASC"),
	 * array arFilter = Array(),
	 * bool bIncCnt = false,
	 * array Select = Array(),
	 * array NavStartParams = false
	 * );
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblocksection/getlist.php
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

		return $this->dataProvider->GetList($this->getOrder(), $this->getWhere(), false, $this->getSelect(), $arNavStartParams);
	}

}
