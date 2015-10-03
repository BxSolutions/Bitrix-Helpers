<?php

namespace BxHelpers;

use \CSaleBasket;

/**
 * Полезные функции для работы с корзиной
 * 
 * @author aleksey.m https://github.com/BxSolutions/Bitrix-Helpers
 */
Class Basket {

	/**
	 * Находим стоимость товаров в корзине пользователя
	 * 
	 * @return float
	 */
	public static function getUserBasketProductsCost() {

		$totalCost = 0;

		$q = CSaleBasket::GetList(false, array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL'), false, false, array('PRICE', 'QUANTITY'));

		while ($r = $q->fetch()) {

			$totalCost+=$r['PRICE'] * $r['QUANTITY'];
		}

		return $totalCost;
	}

	/**
	 * Находим общее количество товаров в корзине пользователя
	 * 
	 * @return float
	 */
	public static function getUserBasketProductsCount() {

		$q = CSaleBasket::GetList(false, array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL'), array('SUM' => 'QUANTITY'), false, array('ID'))->fetch();
		return $q['QUANTITY'];
	}

	/**
	 * Находим число уникальных товаров в корзине пользователя
	 * 
	 * @return int
	 */
	public static function getUserBasketSkuCount() {

		return CSaleBasket::GetList(false, array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL'), array(), false, array('PRODUCT_ID'));
	}

}
