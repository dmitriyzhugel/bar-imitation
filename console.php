<?php

use classes\App;

require_once "autoload.php";

// Регистрация автолоадера
Autoloader::register();
// Запуск приложения
App::getInstance()->run($argv);
