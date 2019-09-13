<?php


namespace Core\base;

use Core\Router;

/**
 * Class View
 * @package Core\base

 * @var $view
 * @var $layout
 */
class View
{
    /**
     * current route
     *  @var $route
     */
    public $route = [] ;
    /**
     * current view
     * @var $view
     */
    public $view;
    /**
     * current layout
     * @var $layout
     */
    public $layout;

    /**
     * function constructor.
     * @param array $route
     * @param string $layout
     * @param string $view
     */
    public function __construct(array $route, $layout = '', $view = '')
    {
        $this->route = $route;
        if($layout === false){
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    /**
     * Makes the connection of the necessary template, transferring the received data to the template
     * @param $vars
     */
    public function render($vars){
        if(is_array($vars)) extract($vars);
        $file_view = VIEWS . "/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if(file_exists($file_view)){
            require_once $file_view;
        }else{
            echo  "<p>404 Note existe view {$file_view}</p>";
        }
        $content = ob_get_clean();
        if(false !== $this->layout){
            $file_layout = VIEWS . "/layouts/{$this->layout}.php";
            if(is_file($file_layout)){
                require_once $file_layout;
            }else{
                echo "<p>404 Note existe layout {$file_layout}</p>";
            }
        }

    }

}