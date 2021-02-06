<?php

use classes\App;

/**
 * Simple autoloader, so we don't need Composer just for this.
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }

            return false;
        });
    }
}

// Регистрация автолоадера
Autoloader::register();
// Запуск приложения
App::getInstance()->run();
