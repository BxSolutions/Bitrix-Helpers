<?php

namespace BxHelpers\Query;

/**
 * Standart methods for working with data in database.
 * 
 * @author Aleksey M (alekseym@bxsolutions.ru) 2015
 * https://github.com/BxSolutions
 * http://bitrixsolutions.ru/
 */
interface QueryInterface
{

	public function select(array $arSelect);

	public function where(array $arFilter);

	public function andWhere(array $arFilter);

	public function orderBy(array $arOrder);

	public function limit($limit);

	public function getResult();

	public function fetch();

	public function add(array $arFields);

	public function update($id, array $arFields);

	public function delete($id);
}
