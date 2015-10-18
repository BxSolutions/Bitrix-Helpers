<?php

namespace BxHelpers\Query;

use BxHelpers\Exception;
use BxHelpers\Query\AbstractQuery;

/**
 * Adapter for some Bitrix Framework classes.
 *
 * @author Aleksey M (alekseym@bxsolutions.ru) 2015
 * https://github.com/BxSolutions
 * http://bitrixsolutions.ru/
 */
class Query extends AbstractQuery
{
	/**
	 * Available classes
	 */

	const IBlock = 'IBlock';
	const IBElement = 'IBlockElement';
	const IBSection = 'IBlockSection';
	const Basket = 'SaleBasket';
	const Order = 'SaleOrder';
	const OrderPropsValue = 'SaleOrderPropsValue';
	const User = 'User';

	public function __construct($from = null)
	{

		if (!is_null($from)) {
			$this->setFrom($from);
		}
		return $this;
	}

	public function from($from)
	{
		$this->setFrom($from);

		return $this;
	}

	protected function setFrom($from)
	{

		$class = __NAMESPACE__ . '\\' . $from . 'Query';

		if (!class_exists($class)) {
			throw new Exception('Class "' . $class . '" not found.');
		}

		$this->dataProvider = New $class;

		return false;
	}

	public function getResult()
	{
		if (is_null($this->selectResult)) {

			if (is_null($this->dataProvider)) {
				throw new Exception('Data provider not loaded.');
			}

			$this->selectResult = $this->dataProvider
					->select($this->getSelect())
					->where($this->getWhere())
					->orderBy($this->getOrder())
					->limit($this->getLimit())
					->getList();
		}

		return $this->selectResult;
	}

}
