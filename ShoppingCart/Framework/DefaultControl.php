<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/30/2015
 * Time: 1:40 PM
 */

namespace Framework;


class DefaultController
{
    /**
     * @var App
     */
    public $app;
    /**
     * @var View
     */
    public $view;
    /**
     * @var Config
     */
    public $config;
    /**
     * @var InputData
     */
    public $input;

    public function __construct(){
        $this->app = \Framework\App::getInstance();
        $this->view = \Framework\View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = \Framework\InputData::getInstance();
    }

    public function jsonResponse(){

    }
}