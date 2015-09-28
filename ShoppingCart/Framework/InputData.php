<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/28/2015
 * Time: 2:24 PM
 */

namespace Framework;


class InputData
{
    private static $inst = null;
    private $_get = array();
    private $_post = array();
    private $_cookies = array();

    private function __construct(){
        $this->_cookies = $_COOKIE;
    }



    public function setPost($ar){
        if(is_array($ar)){
            $this->_post = $ar;
        }
    }

    public function setGet($ar){
        if(is_array($ar)){
            $this->_get = $ar;
        }
    }

    public function hasGet($id){
        return array_key_exists($id, $this->_get);
    }

    public function hasPost($name){
        return array_key_exists($name, $this->_post);
    }

    public function get($id,$normalize = null, $default = null){
        if($this->hasGet($id)){
            if($normalize!=null){
                
            }
            return $this->_get[$id];
        }
        return $default;
    }
    /**
     * @return \Framework\InputData
     */
    public static function getInstance(){
        if(self::$inst == null){
            self::$inst = new \Framework\InputData();
        }
        return self::$inst;
    }
}