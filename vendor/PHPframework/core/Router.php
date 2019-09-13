<?php


namespace Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * all routes
     * @var array $routes
     */
    protected static $routes = [];
    /**
     * current route
     * @var array $route
     */
    protected static $route = [];

    /**
     * Creates new routes and adds them to the array of routes
     * @param string $regexp
     * @param string $route
     */
    public static function add(string $regexp, $route = ""){
        self::$routes[$regexp] = $route ? ( stristr($route, '@') ? [ 'controller' => explode('@', $route)[0], 'action' => explode('@', $route)[1] ] : ['controller' => $route]) : [];
    }

    /**
     * Returns an array of all routes
     * @return array
     */
    public static function getRoutes(){
        return self::$routes;
    }

    /**
     * Returns the current route
     * @return array
     */
    public static function getRoute(){
        return self::$route;
    }

    /**
     * Finds a controller that matches the current route
     * @param string $url
     */
    public static function dispatch($url){
        $url = self::removeQueryString($url);
        if(self::matchRoute($url)){
            $controller = self::$route['controller'];
            $action = self::$route['action'];
            $classController = "App\Controllers\\{$controller}Controller";
            if(class_exists($classController)){
                $object = new $classController(self::$route);
                if(method_exists($object, $action)){
                    $object->$action();
                    $object->getView();
                }else{
                    echo "<p style='color: red;'>action {$action} note existe!!!</p>";
                }
            }else{
                echo "<p style='color: red;'>class {$classController} note existe!!!</p>";
            }
        }
    }

    /**
     * Searches for a route by URL, if it finds a route, adds to the current route: self::$route
     * @param string $url
     * @return bool
     */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#{$pattern}#i", $url, $matches)){
                if($route == [] || $route['controller']){
                    foreach ($matches as $k => $v){
                        if(is_string($k))  $route[$k] = $v;
                    }
                }
                $route['action'] ? self::camelcaseStringFormatting($route['action']) : $route['action'] = 'index';
                $route['controller'] = self::uppercaseStringFormatting($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Removes all spaces and hyphens, returns a string in camelcase
     * @param string $string
     * @return string
     * @example camelcaseStringFormatting('bay-product') return bayProduct
     */
    protected static function camelcaseStringFormatting(string $string){
        return $str = lcfirst(implode('', explode(' ', ucwords( strtolower(str_replace('-', ' ', $string)) )) ));
    }

    /**
     * Removes all spaces and hyphens, returns a string in uppercase
     * @param string $string
     * @return string
     * @example uppercaseStringFormatting('new-products') return NewProducts
     */
    protected static function uppercaseStringFormatting(string $string){
        return $str = ucfirst( implode('', explode(' ', ucwords( strtolower(str_replace('-', ' ', $string)))) ));
    }

    /**
     * accepts the entire url, returns without get parameters
     * @example removeQueryString('post-new/&test=4&id=4') return post-new
     */
    public static function removeQueryString($queryString){
        if($queryString != ''){
            $queryString = str_replace( '_url=/', '', $queryString);
            $params = explode('&', $queryString, 2);
            if(false === strpos($params[0], '=')){
                return rtrim($params[0], '/');
            }
        }else return '';
    }

}