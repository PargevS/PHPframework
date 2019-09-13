<?php


namespace App\Controllers;


class PageController extends AppController
{



    public function view(){
        echo 'Page view';
        dd($_GET);
    }

}