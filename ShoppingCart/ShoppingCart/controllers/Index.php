<?php
namespace Controllers;
class Index{
    public function index(){
       $view = \Framework\View::getInstance();
        $view->display('admin.index');
    }
}