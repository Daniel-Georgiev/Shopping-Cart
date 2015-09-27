<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/27/2015
 * Time: 7:04 PM
 */

namespace Framework;


use Framework\Routers\DefaultRouter;

class FrontController
{
    private static $inst = null;

    private function __construct(){

    }
    public function dispatch(){
        $a = new DefaultRouter();
        $controller = $a->getController();
        $method = $a->getMethod();
        if($controller == null){
            $controller = $this->getDefaultController();
        }
        if($method == null){
            $method = $this->getDefaultMethod();
        }
    }

    public function getDefaultController(){
        $controller = \Framework\App::getInstance()->getConfig()->app['default_controller'];
        if($controller){
            return $controller;
        }
        return 'Index';
    }

    public function getDefaultMethod(){
        $method = \Framework\App::getInstance()->getConfig()->app['default-_method'];
        if($method){
            return $method;
        }
        return 'index';
    }

    /**
     * @return \Framework\FrontController
     */
    public static function getInstance(){
        if(self::$inst == null){
            self::$inst = new \Framework\FrontController();
        }
        return self::$inst;
    }
}