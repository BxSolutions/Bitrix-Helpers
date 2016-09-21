# Helpers
Helper Classes for Bitrix

Здесь собраны полезные классы для более удобной работы с Bitrix Framework.

BxHelpers\Basket - класс для работы с корзиной.
BxHelpers\Query\ - набор классов с единым синтаксисом написания запросов к БД.

Для использования библиотеки нужно:

1. Выгрузить библиотеку в папку /local/php_interface на сервере.
2. Добавить автозагрузчик классов в /local/php_interface/init.php

 ```php
 require_once __DIR__ . '/bxhelpers_autoloader.php';
 spl_autoload_register('BxHelpers\Autoloader::load', true);
 ```

3. Подключить необходимый класс, например:
```php
use BxHelpers\Basket;

echo Basket::getUserBasketProductsCost();
```
