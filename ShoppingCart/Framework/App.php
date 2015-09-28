<?php
namespace Framework;
require_once 'Loader.php';

class App
{

    private static $inst = null;
    private $_config = null;
    private $router = null;
    private $_dbConnections = [];

    /**
     * @return null
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
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


        if ($this->router instanceof \Framework\Routers\IRouter) {
            $this->_frontController->setRouter($this->router);
        } else if ($this->router == 'JsonRPCRouter') {
            //LOAD RPC ROUTER
            $this->_frontController->setRouter(new \Framework\Routers\DefaultRouter());
        } else if ($this->router == 'CLIRouter') {
            //LOAD CLI ROUTER
            $this->_frontController->setRouter(new \Framework\Routers\DefaultRouter());
        } else {
            $this->_frontController->setRouter(new \Framework\Routers\DefaultRouter());
        }

        $this->_frontController->dispatch();

    }

    public function getDBConnection($connection = 'default')
    {
        if (!$connection) {
            throw new \Exception("No connection identifier provided", 500);
        }
        if ($this->_dbConnections[$connection]) {
            return $this->_dbConnections[$connection];
        }
        $_cnf = $this->getConfig()->database;
        if (!$_cnf[$connection]) {
            throw new \Exception("No valid connection identificator is provided", 500);
        }
        $dbh = new \PDO($_cnf[$connection]['connection_uri'], $_cnf[$connection]['username'],
            $_cnf[$connection]['password'], $_cnf[$connection]['pdo_options']);

        $this->_dbConnections[$connection] = $dbh;
        return $dbh;


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