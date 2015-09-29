<?php
namespace Controllers;
class Index{
    public function index(){

        $val = new \Framework\Validation();
        $val->setRule('url', 'http://sada.c/')->setRule('minlength','http://sa.c/',100);
        var_dump($val->validate());
       $view = \Framework\View::getInstance();
        $view->appendToLayout('body','admin.index');
        $view->display('layouts.default', array('c'=>array(1,2,3,4)),false);
    }
}