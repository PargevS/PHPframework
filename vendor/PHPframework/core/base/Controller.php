<?php


namespace Core\Base;

/**
 * Class Controller
 * @package Core\Base
 * @var array $route
 * @var file $view
 */
abstract class Controller
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
     * user data
     * @var array $vars
     */
    public $vars = [];

    /**
     * Controller constructor.
     * @param array $route
     */
    public function __construct($route = [])
    {
        $this->route = $route;
        $this->view = $route['action'];
    }

    /**
     * getting the required view
     * @method void getView()
     */
    public function getView(){
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    /**
     * passing data to a variable $this->vars for use in views
     * @param array $vars
     */
    public function set(array $vars){
        $this->vars = $vars;
    }

}