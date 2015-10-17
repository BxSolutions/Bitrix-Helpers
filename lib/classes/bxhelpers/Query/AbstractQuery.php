<?php

namespace BxHelpers\Query;

use BxHelpers\Exception;

/**
 * Abstract class for working with data in database.
 * It provides a unified interface to Bitrix Framework classes that work with database. 
 * It provides autocomplete in IDE for parts of the query.
 * 
 * 
 * @author Aleksey M (alekseym@bxsolutions.ru) 2015
 * https://github.com/BxSolutions
 * http://bitrixsolutions.ru/
 */
class AbstractQuery implements QueryInterface
{

	/**
	 * $arSelectFields in GetList method.
	 * Selected fields.
	 * 
	 * @var type 
	 */
	protected $select = array();

	/**
	 * $arFilter in GetList method.
	 * WHERE part of the query.
	 * 
	 * @var array 
	 */
	protected $where = array();

	/**
	 * nTopCount in $arNavStartParams
	 * Number of rows in select.
	 * 
	 * @var int 
	 */
	protected $limit;

	/**
	 * $arOrder in GetList method.
	 * ORDER BY part of the query.
	 * 
	 * @var type 
	 */
	protected $order = array();

	/**
	 * Data provider class.
	 * For ex. CIBlock, CIBlockElement etc.
	 * 
	 * @var mixed 
	 */
	protected $dataProvider;

	/**
	 * Result of GetList method.
	 * 
	 * @var \CDBResult 
	 */
	protected $selectResult;

	/**
	 * Event name.
	 */

	const RESET_SELECT_RESULT = 'RESET_SELECT_RESULT';

	public function __construct()
	{
		
	}

	/**
	 * Sets the SELECT part of the query.
	 * $arSelectFields in GetList method.
	 * 
	 * @param array $arSelect
	 * @return \BxHelpers\Query\AbstractQuery
	 */
	public function select(array $arSelect)
	{
		$this->select = $arSelect;
		$this->trigger(self::RESET_SELECT_RESULT);

		return $this;
	}

	/**
	 * Sets the WHERE part of the query.
	 * $arFilter in GetList method.
	 * 
	 * @param array $arFilter
	 * @return \BxHelpers\Query\AbstractQuery
	 */
	public function where(array $arFilter)
	{
		$this->where = $arFilter;
		$this->trigger(self::RESET_SELECT_RESULT);

		return $this;
	}

	/**
	 * Adds additional condition to the WHERE part of the query.
	 * Extend the $arFilter in GetList method.
	 * 
	 * @param array $arFilter
	 * @return \BxHelpers\Query\AbstractQuery
	 */
	public function andWhere(array $arFilter)
	{
		$this->where = array_merge($this->where, $arFilter);
		$this->trigger(self::RESET_SELECT_RESULT);

		return $this;
	}

	/**
	 * Sets the ORDER BY part of the query.
	 * $arOrder in GetList method.
	 * 
	 * array(Field1=>ASC|DESC, Field2=>ASC|DESC)
	 * 
	 * @param array $arOrder
	 * @return \BxHelpers\Query\AbstractQuery
	 */
	public function orderBy(array $arOrder)
	{
		$this->order = $arOrder;
		$this->trigger(self::RESET_SELECT_RESULT);

		return $this;
	}

	/**
	 * Sets the LIMIT part of the query. 
	 * nTopCount in $arNavStartParams
	 * 
	 * @param int $limit
	 * @return \BxHelpers\Query\AbstractQuery
	 */
	public function limit($limit)
	{
		$this->limit = (int) $limit;
		$this->trigger(self::RESET_SELECT_RESULT);

		return $this;
	}

	/**
	 * Gets the SELECT part of the query.
	 * $arSelectFields in GetList method.
	 * 
	 * @return array
	 */
	public function getSelect()
	{
		return $this->select;
	}

	/**
	 * Gets the WHERE part of the query.
	 * $arFilter in GetList method.
	 * 
	 * @return array
	 */
	public function getWhere()
	{
		return $this->where;
	}

	/**
	 * Gets the ORDER BY part of the query.
	 * $arOrder in GetList method.
	 * 
	 * @return array
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Gets the LIMIT part of the query. 
	 * nTopCount in $arNavStartParams
	 * 
	 * @return int
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Get result of GetList method
	 * 
	 * @return CDBResult
	 */
	public function getResult()
	{
		if (is_null($this->selectResult)) {

			if (is_null($this->dataProvider)) {
				throw new Exception('Data provider not loaded.');
			}

			$this->selectResult = $this->getList();
		}

		return $this->selectResult;
	}

	/**
	 * Runs GetList method of the data provider in concrete realization.
	 * For ex. CIBlock::GetList, CIBlockElement::GetList etc.
	 * 
	 * @return CDBResult
	 */
	protected function getList()
	{
		
	}

	/**
	 * Gets array with one row of selected data.
	 * Calls CDBResult->Fetch()
	 * 
	 * @return array|false
	 */
	public function fetch()
	{
		if (is_null($this->selectResult)) {
			$this->getResult();
		}

		return $this->selectResult->Fetch();
	}

	/**
	 * Handles some events.
	 * 
	 * @param string $event
	 */
	protected function trigger($event)
	{
		switch ($event) {
			case self::RESET_SELECT_RESULT:
				$this->selectResult = null;
				break;

			default:
				break;
		}
	}

	/**
	 * Inserts row.
	 * @param array $arFields
	 * @return int|false
	 */
	public function add(array $arFields)
	{
		return $this->dataProvider->add($arFields);
	}

	/**
	 * Alias for the "add" method.
	 * 
	 * @param array $arFields
	 * @return int|false
	 */
	public function insert(array $arFields)
	{
		return $this->add($arFields);
	}

	/**
	 * Updates row.
	 * 
	 * @param int $id
	 * @param array $arFields
	 * @return boolean
	 */
	public function update($id, array $arFields)
	{
		return $this->dataProvider->update($id, $arFields);
	}

	/**
	 * Deletes row.
	 * 
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id)
	{
		return $this->dataProvider->delete($id);
	}

	/**
	 * Gets last error message if available.
	 * "LAST_ERROR" property available in data provider after executing "add", "update" methods.
	 * 
	 * @return string|false
	 */
	public function getLastError()
	{
		if (property_exists($this->dataProvider, 'LAST_ERROR')) {
			return $this->dataProvider->LAST_ERROR;
		}
		return false;
	}

}
