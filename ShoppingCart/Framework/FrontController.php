<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/27/2015
 * Time: 7:04 PM
 */

namespace Framework;


class FrontController
{
    private static $inst = null;

    private function __construct(){

    }
    public function dispatch(){

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