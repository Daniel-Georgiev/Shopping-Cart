<?php
namespace Framework;
require_once 'Loader.php';

class App
{

    private static $inst = null;
    private $_config = null;
    private $router = null;
    /**
 * @return null
 */
public function getRouter()
{
    return $this->router;
}/**
 * @param null $router
 */
public function setRouter($router)
{
    $this->router = $router;
}

    /*
     *
     * @var \Framework\FrontController
     */

    private $_frontController = null;
    private function __construct()
    {
        Loader::registerNamespace('Framework', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = \Framework\Config::getInstance();


    }


    public function setConfigFolder($path)
    {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder()
    {
        return $this->_configFolder;
    }

    /**
     * @return \Framework\Config
     */
    public function getConfig()
    {
        return $this->_config;
    }
    public function run()
    {

        if ($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder('../config');
        }
        $this->_frontController = \Framework\FrontController::getInstance();
    if($this->router instanceof \Framework\Routers\IRouter){
        $this->_frontController = $this->setRouter($this->router);
    }
    else if ($this->router == 'JsonRPCRouter') {
            $this->_frontController = $this->setRouter(new \Framework\Routers\DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            $this->_frontController = $this->setRouter(new \Framework\Routers\DefaultRouter());
        } else {
            $this->_frontController = $this->setRouter(new \Framework\Routers\DefaultRouter());
        }
        $this->_frontController->dispatch();

    }
    /**
     * @return \Framework\App
     */
    public static function getInstance()
    {
        if (self::$inst == null) {
            self::$inst = new \Framework\App();
        }
        return self::$inst;
    }
}