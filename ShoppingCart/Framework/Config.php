<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/27/2015
 * Time: 4:59 PM
 */

namespace Framework;


class Config
{
    private static $inst = null;
    private $_configFolder = null;
    private $_configArray = array();

    private function __contruct(){

    }

    public function getConfigFolder(){
        return $this->_configFolder;
    }

    public function setConfigFolder($configFolder){
        if(!$configFolder){
            throw new \Exception("Empty config folder path:");
        }
        $_configFolder = realpath($configFolder);
        if($_configFolder != false && is_dir($_configFolder) && is_readable($_configFolder)){
            $this->_configArray = array();
            $this->_configFolder = $_configFolder . DIRECTORY_SEPARATOR;
//            $ns = $this->app['namespaces'];
//            if(is_array($ns)){
//                \Framework\Loader::registerNamespace($ns);
//            }
        }else{
            throw new \Exception("Config drectory read error:" . $configFolder);
        }

    }

    public function includeConfigFile($path){
        if(!$path){
            throw new \Exception;
        }
        $_file = realpath($path);

        if($_file != false && is_file($_file) && is_readable($_file)){
            $_basename = explode('.php', basename($_file))[0];
            $this->_configArray[$_basename] = include $_file;

        }else{
            throw new \Exception("Config file read error:" . $path);
        }
    }

    public function __get($name){
        if(!$this->_configArray[$name]){
            $this->includeConfigFile($this->_configFolder. $name. '.php');
        }
        if(array_key_exists($name, $this->_configArray)){
            return $this->_configArray[$name];
        }
        return null;
    }

    /**
     * @return \Framework\Config
     */
    public static function getInstance(){
        if(self::$inst == null){
            self::$inst = new \Framework\Config();
        }
        return self::$inst;
    }


}