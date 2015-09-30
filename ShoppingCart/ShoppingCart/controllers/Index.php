<?php
namespace Controllers;

class Index {
    public function index(){

       $view = \Framework\View::getInstance();
        $view->appendToLayout('body','index');
        $view->display('layouts.default');
    }
}