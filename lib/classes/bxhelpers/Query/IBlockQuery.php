<?php

namespace BxHelpers\Query;

use BxHelpers\Query\AbstractQuery;
use \CModule;

class IBlockQuery extends AbstractQuery
{

	/**
	 * A mark that does not select all fields.
	 * @var booleaan 
	 */
	protected $customSelect = false;

	/*
	 * Temporary variable for saving selected fields
	 */
	protected $flippedSelect = array();

	public function __construct()
	{
		parent::__construct();

		CModule::IncludeModule('iblock');

		$this->dataProvider = New \CIBlock;
	}

	public function select(array $arSelect)
	{
		$this->customSelect = count($arSelect) > 0;

		return parent::select($arSelect);
	}

	/**
	 * Run CIBlock::GetList(
	  array arOrder = Array("SORT"=>"ASC"),
	  array arFilter = Array(),
	  bool bIncCnt = false
	  );
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblock/getlist.php
	 * 
	 * @return CDBResult
	 */
	protected function getList()
	{
		return $this->dataProvider->GetList($this->getOrder(), $this->getWhere());
	}

	public function fetch()
	{
		$res = parent::fetch();

		if ($this->customSelect === true) {

			if (empty($this->flippedSelect)) {
				$this->flippedSelect = array_flip($this->getSelect());
			}

			return array_intersect_key($res, $this->flippedSelect);
		}
		else
			return $res;
	}

}

