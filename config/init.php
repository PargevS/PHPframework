<?php

define('ROOT', dirname(__DIR__) );
define('CONF', ROOT . '/config');
define('CORE', ROOT . '/vendor/PHPframework/core');
define('LIBS', ROOT . '/vendor/PHPframework/libs');
define('TEMPLEATES', ROOT . '/templates');
define('CACHE', ROOT . '/var/cache');
define('LOG', ROOT . '/var/log');






/**
 * autolaod classes
 */
require_once ROOT . '/vendor/autoload.php';
/**
 * functions
 */
require_once LIBS . '/functiones.php';
/**
 * routes
 */
require_once CONF . '/routes/web.php';
