<?php


namespace Core;

/**
 * Class Router
 * @package Core
 * @var array $routes = []
 * @var array $route = []
 */
class Router
{
    protected static $routes = [];
    protected static $route = [];

    /**
     * Creates new routes and adds them to the array of routes
     * @method void add(string $regexp, string $router)
     * @param string $regexp
     * @param string $route
     */
    public static function add(string $regexp, string $route = ''){
        self::$routes[$regexp] = $route ? [ 'controller' => explode('@', $route)[0], 'action' => explode('@', $route)[1] ] : [];
    }

    /**
     * Returns an array of all routes
     * @method array getRoutes()
     * @return array
     */
    public static function getRoutes(){
        return self::$routes;
    }

    /**
     * Returns the current route
     * @method array getRoute()
     * @return array
     */
    public static function getRoute(){
        return self::$route;
    }

    /**
     * @method dispatch($url)
     */
    public static function dispatch($url){
        if(self::matchRoute($url)){
            $controller = self::uppercaseStringFormatting(self::$route['controller']);
            $action = self::camelcaseStringFormatting(self::$route['action']);
            $classController = "App\Controllers\\{$controller}Controller";
            if(class_exists($classController)){
                $object = new $classController();
                if(method_exists($object, $action)){
                    $object->$action();
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
     * @method matchroute($url)
     * @param string $url
     * @return bool
     */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#{$pattern}#i", $url, $matches)){
                if($route == []){
                    foreach ($matches as $k => $v){
                        if(is_string($k))  $route[$k] = $v;
                    }
                }
                $route['action'] ? $route['action'] : $route['action'] = 'index';
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Removes all spaces and hyphens, returns a string in camelcase
     * @method string camelcaseStringFormatting(string $string)
     * @param string $string
     * @return string
     * @example camelcaseStringFormatting('bay-product') return bayProduct
     */
    protected static function camelcaseStringFormatting(string $string){
        return $str = lcfirst(implode('', explode(' ', ucwords( strtolower(str_replace('-', ' ', $string)) )) ));
    }

    /**
     * Removes all spaces and hyphens, returns a string in uppercase
     *@method string  uppercaseStringFormatting(string $string)
     * @param string $string
     * @return string
     * @example uppercaseStringFormatting('new-products') return NewProducts
     */
    protected static function uppercaseStringFormatting(string $string){
        return $str = ucfirst( implode('', explode(' ', ucwords( strtolower(str_replace('-', ' ', $string)))) ));
    }

}