<?php
    namespace Framework;
    require_once 'Loader.php';
class App{

    private static $inst = null;
    private $_config = null;

    /*
     *
     * @var \Framework\FrontController
     */

    private $_frontController = null;
    private function __construct(){
        Loader::registerNamespace('Framework', dirname(__FILE__).DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = \Framework\Config::getInstance();


    }


    public function setConfigFolder($path){
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder(){
        return $this->_configFolder;
    }

    /**
     * @return \Framework\Config
     */
    public function getConfig(){
        return $this->_config;
    }
    public function run(){

        if($this->_config->getConfigFolder() == null){
            $this->setConfigFolder('../config');
        }
        $this->_frontController = \Framework\FrontController::getInstance();
        $this->_frontController->dispatch();

    }
    /**
     * @return \Framework\App
     */
    public static function getInstance(){
        if(self::$inst == null){
            self::$inst = new \Framework\App();
        }
        return self::$inst;
    }
}