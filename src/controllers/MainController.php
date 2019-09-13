<?php


namespace App\Controllers;


class MainController extends AppController
{
    public $layout = 'main';

    public function index(){
//        $this->layout = false;
        $this->view = 'test';
        $name = 'Ani';
        $age = 25;
        $page_title = "Main Page";
        $this->set(compact('name', 'age', 'page_title'));
    }
}