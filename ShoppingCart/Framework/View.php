<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/28/2015
 * Time: 10:32 PM
 */

namespace Framework;


class View
{
    private static $inst = null;
    private $___viewPath = null;
    private $___viewDir = null;
    private $___extension = '.php';
    private $___data = array();
    private $___layoutParts = array();
    private $___layoutData = array();


    private function __construct(){
        $this->___viewPath = \Framework\App::getInstance()->getConfig()->app['viewsDirectory'];
        if($this->___viewPath==null){
            $this->___viewPath = realpath('../views/');
        }
    }

    public function setViewDirectory($path){
        $path = trim($path);
        if($path){
            $path = realpath($path).DIRECTORY_SEPARATOR;
            if(is_dir($path) && is_readable($path)){
                $this->___viewDir = $path;
            }else{
                throw new \Exception('viw path', 500);
            }
        }else{
            throw new \Exception('view path', 500);
        }
    }

    public function display($name, $data = array(), $returnAsString = false){
        if(is_array($data)){
            $this->___data = array_merge($this->___data, $data);
        }

        if(count($this->___layoutParts)>0){
            foreach($this->___layoutParts as $k => $v){
                $r = $this->_includeFile($v);
                if($r){
                    $this->___layoutData[$k] = $r;
                }
            }
        }
        if($returnAsString){
            return $this->_includeFile($name);
        }else{
            echo $this->_includeFile($name);
        }
    }
    public function getLayoutData($name){
        return $this->___layoutData[$name];
    }

    public function appendToLayout($key, $template){
        if($key && $template){
            $this->___layoutParts[$key] = $template;
        }else{
            throw new \Exception('Layout requires valid key and template', 500);
        }
    }

    private function _includeFile($file){
        if($this->___viewDir == null){
            $this->setViewDirectory($this->___viewPath);
        }
        $___fl = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
        if(file_exists($___fl) && is_readable($___fl)){
            ob_start();
            include $___fl;
            return ob_get_clean();
        }else{
            throw new \Exception('View ' . $file . ' cannot be included', 500);
        }
    }




    /**
     * @return \Framework\View
     */
    public static function getInstance()
    {
        if (self::$inst == null) {
            self::$inst = new \Framework\View();
        }
        return self::$inst;
    }
}