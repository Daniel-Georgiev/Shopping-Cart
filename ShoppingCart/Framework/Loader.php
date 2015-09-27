<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/27/2015
 * Time: 4:16 PM
 */

namespace Framework;


final class Loader
{
    private static $namespaces = array();

    private function __construct()
    {

    }

    public static function registerAutoLoad()
    {
        spl_autoload_register(array("\\Framework\\Loader", "autoload"));
    }

    public static function autoload($class)
    {

        self::loadClass($class);
    }

    public static function loadClass($class)
    {
        foreach(self::$namespaces as $k => $v){
            if(strpos($class, $k) === 0){
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
                $file = substr_replace($file, $v, 0, strlen($k)) . '.php';
                $fileName = realpath($file);
                if($fileName && is_readable($fileName)){
                    include $file;
                } else {
                    throw new \Exception('File not be included: ' . $file);
                }
                break;
            }
        }
    }

    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                throw new \Exception("Invalid path");
            }
            $_path = realpath($path);

            if ($_path && is_dir($_path) && is_readable($_path)) {
                self::$namespaces[$namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception("Namespace directory read error:" . $path);
            }
        } else {
            throw new \Exception("Invalid namespace:" . $namespace);
        }
    }

}