<?php

use Core\Router;

/**
 * pages route
 */
Router::add('^/page/?(?P<alias>[a-z]+)?$', 'Page@view');
/**
 * defaults routes
 */
Router::add('^$', 'Main@index');
Router::add('^/?(?P<controller>[a-z-?]+)/?(?P<action>[a-z-?]+)?$');




/**
 * URL handling and route selection
 */
Router::dispatch($_SERVER['QUERY_STRING']);



