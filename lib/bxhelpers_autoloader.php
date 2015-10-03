<?php

namespace BxHelpers;

/* * *
 * Autoload classes with namespace BxHelpers
 * 
 * @author aleksey.m https://github.com/BxSolutions/Bitrix-Helpers
 */

Class Autoloader {

    private static $namespaces = array('BxHelpers');

    private static $folders = array(
        '/local/php_interface/classes/bxhelpers',
    );

    public static function load($class) {

        $foreign_namespace = true;

        $namespaces = static::$namespaces;

        $namespaces = array_map((function($a) {
                    return $a . '\\';
                }), $namespaces);

        foreach ($namespaces as $namespace)
        {
            if (strrpos($class, $namespace) !== false)
            {
                $foreign_namespace = false;
                break;
            }
        }

        if ($foreign_namespace === true)
        {
            return;
        }

        $filename = str_replace($namespaces, '', $class);

        $filename = str_replace('\\', '', $filename);

        foreach (static::$folders as $folder)
        {
            $class_path = $_SERVER['DOCUMENT_ROOT'] . $folder . '/' . $filename . '.php';

            if (is_file($class_path))
            {
                require_once $class_path;
            }

            if (class_exists($class))
            {
                return true;
            }
        }
    }

}
