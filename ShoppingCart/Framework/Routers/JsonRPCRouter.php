<?php

namespace Framework\Routers;


class JsonRPCRouter implements \Framework\Routers\IRouter
{
    private $_map = array();
    private $_requestId;
    private $_post = array();
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] != 'application/json') {
            throw new \Exception('Require json request', 400);
        }
    }


    public function getURI()
    {
        if (!is_array($this->_map) || count($this->_map) == 0) {
            $ar = \Framework\App::getInstance()->getConfig()->rpcRoutes;
            if (is_array($ar) && count($ar) > 0) {
                $this->_map = $ar;
            } else {
                throw new \Exception('Router require method map', 500);
            }
        }

        $request = json_decode(file_get_contents('php://input'), true);
        if(!is_array($request) || !isset($request['method'])){
            throw new \Exception('Require json request', 400);
        }else{
            if($this->_map[$request['method']]) {
                $this->_requestId = $request['id'];
                $this->_post = $request['params'];
                return $this->_map[$request['method']];
            }
            else{
                throw new \Exception('Method not found', 501);
            }
        }
    }
    public function getRequestId(){
        return $this->_requestId;
    }

    public function getPost()
    {
        return $this->_post;
    }
}