<?php

use Core\Router;

Router::add('^/$', 'Main@index');
Router::add('^/(?P<controller>[a-z-?]+)/?(?P<action>[a-z-?]+)?$');




/**
 * URL handling and route selection
 */
Router::dispatch($_SERVER['REQUEST_URI']);


