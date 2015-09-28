<?php
namespace Framework;
require_once 'Loader.php';

class App
{

    private static $inst = null;
    private $_config = null;
    private $router = null;
    private $_dbConnections = [];
    private $_session = null;

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

        $_sess = $this->_config->app['session'];
        if($_sess['autostart']){
            if($_sess['type'] == 'native'){
               $_s =  new \Framework\Sessions\NativeSession($_sess['name'],
                    $_sess['lifetime'],
                    $_sess['path'],
                    $_sess['domain'],
                    $_sess['secure']
                );

            }
            else if($_sess['type'] == 'database'){
                $_s = new \Framework\Sessions\DBSession(
                  $_sess['dbConnection'],
                    $_sess['name'],
                    $_sess['dbTable'],
                    $_sess['lifetime'],
                    $_sess['path'],
                    $_sess['domain'],
                    $_sess['secure']
                );

            }
            else{
                throw new \Exception("No valid session", 500);
            }
            $this->setSession($_s);

        }

        $this->_frontController->dispatch();

    }

    public function setSession(\Framework\Sessions\ISession $session){
        $this->_session = $session;
    }
    /**
     * @return \Framework\Sessions\ISession
     */
    public function getSession()
    {
        return $this->_session;
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

    public function __destruct(){
        if($this->_session !=null){
            $this->_session->saveSession();
        }
    }
}