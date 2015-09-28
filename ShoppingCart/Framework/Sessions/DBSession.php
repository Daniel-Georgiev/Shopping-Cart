<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/28/2015
 * Time: 6:12 PM
 */

namespace Framework\Sessions;


class DBSession extends \Framework\DB\SimpleDb implements \Framework\Sessions\ISession
{
    private $sessionName;
    private $tableName;
    private $lifetime;
    private $path;
    private $domain;
    private $secure;
    private $sessionId;
    private $sessionData = array();

    public function __construct($dbconnection, $name, $tableName = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = null){
        parent::__construct($dbconnection);
        $this->tableName = $tableName;
        $this->sessionName = $name;
        $this->lifetime = $lifetime;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->sessionId = $_COOKIE[$name];

        if(rand(0,50)==1){
            $this->_gc();
        }
        if(strlen($this->sessionId)< 32){
            $this->_startNewSession();
        } else if(!$this->_validateSession()){
            $this->_startNewSession();

        }

    }



    private function _startNewSession(){
        $this->sessionId = md5(uniqid('Framework', true));
        var_dump($this->sessionId);
        $this->prepare('INSERT INTO '.$this->tableName.'(id, valid_until) VALUES(?,?)',
                array($this->sessionId, (time()+ $this->lifetime)))->execute();
        setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
    }

    private function _validateSession(){
        if($this->sessionId){
            $d = $this->prepare('SELECT * FROM ' . $this->tableName . 'WHERE id = ? and valid_until<= ?',
            array($this->sessionId,(time() + $this->lifetime)))->execute()->fetchAllAssoc();
            if(is_array($d) && count($d) == 1 && $d[0]){
                $this->sessionData = unserialize($d[0]['sess_data']);
                return true;
            }
        }
        return false;
    }

    public function getSessionId()
    {
        // TODO: Implement getSessionId() method.
    }

    public function saveSession()
    {
        if($this->sessionId){
            $this->prepare('UPDATE' .$this->tableName. 'SET sess_data = ?, valid_until = ? WHERE id = ?',
                array(serialize($this->sessionData), (time() + $this->lifetime), $this->sessionId))->execute();
            setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);

        }
    }

    public function destroySession()
    {
        if($this->sessionId){
            $this->prepare('DELETE FROM' .$this->tableName . 'WHERE id =?', array($this->sessionId))->execute();
        }
    }

    public function __get($name)
    {
        return $this->sessionData[$name];
    }

    public function __set($name, $value)
    {
        $this->sessionData[$name] = $value;
        $this->saveSession();
    }
    private function _gc(){
        $this->prepare('DELETE FROM '. $this->tableName. 'WHERE valid_until<?',array(time()))->execute();
    }
}