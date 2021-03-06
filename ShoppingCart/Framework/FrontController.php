<?php

namespace Framework;


use Framework\Routers\DefaultRouter;

class FrontController
{
    private static $inst = null;
    private $ns = null;
    private $controller = null;
    private $method = null;
    /**
     * @var \Framework\Routers\IRouter
     */
    private $router = null;

    private function __construct(){

    }
    public function dispatch(){
        if($this->router == null){
            throw new \Exception("No valid router found", 500);
        }
        $_uri = $this->router->getURI();
        $routes = \Framework\App::getInstance()->getConfig()->routes;
        $_rc = null;
        if(is_array($routes) && count($routes)>0){
            foreach($routes as $k => $v){
                if(stripos($_uri, $k)=== 0
                    && ($_uri == $k || stripos($_uri, $k . '/') === 0)
                    && $v['namespace']){
                    $this->ns = $v['namespace'];
                    $_uri = substr($_uri, strlen($k) + 1);
                    $_rc = $v;
                    break;
                }
            }
        }else{
            throw new \Exception('Default route missing', 500);
        }

        if ($this->ns == null && $routes['*']['namespace']) {
            $this->ns = $routes['*']['namespace'];
            $_rc = $routes['*'];
        } else if ($this->ns == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }
        $input = \Framework\InputData::getInstance();
        $_params = explode('/', $_uri);
        if($_params[0]){
            $this->controller= strtolower($_params[0]);
            if($_params[1]){
                $this->method = strtolower($_params[1]);
                unset($_params[0],$_params[1]);
                $input->setGet(array_values($_params));
            }else{
                $this->method=$this->getDefaultMethod();
            }
        }else{
            $this->controller= $this->getDefaultController();
            $this->method=$this->getDefaultMethod();
        }
        if(is_array($_rc) && $_rc['controllers']){
            if($_rc['controllers'][$this->controller]['methods'][$this->method]){
                $this->method=  strtolower($_rc['controllers'][$this->controller]['methods'][$this->method]);
            }
            if(isset($_rc['controllers'][$this->controller]['to'])){
                $this->controller=  strtolower($_rc['controllers'][$this->controller]['to']);
            }
        }
        $input->setPost($this->router->getPost());
        $f = $this->ns.'\\'.ucfirst($this->controller);
        $newController = new $f();
        $newController->{$this->method}();

    }

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
    public function setRouter(\Framework\Routers\IRouter $router)
    {
        $this->router = $router;
    }

    public function getDefaultController(){
        $controller = \Framework\App::getInstance()->getConfig()->app['default_controller'];
        if($controller){
            return strtolower($controller);
        }

        return 'Index';
    }

    public function getDefaultMethod(){
        $method = \Framework\App::getInstance()->getConfig()->app['default-_method'];
        if($method){
            return strtolower($method);
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