<?php
namespace Controllers;
class Index{
    public function index(){
       $view = \Framework\View::getInstance();
        $view->appendToLayout('body','admin.index');
        $view->display('layouts.default', array('c'=>array(1,2,3,4)),false);
    }
}