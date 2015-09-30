<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/30/2015
 * Time: 8:39 PM
 */

namespace Framework\ViewHelpers;


class Form
{
    private $_attributes = [];
    private $_feilds = [];
    private $_type = '';
    private $_inputs = [];
    private $_method = '';

    public static function create(){
        return new self();
    }

    public function addAttribute($attributeName, $attributeValue){
        $this->_attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function addInput($type){
        array_push($this->_inputs, $type);
        return $this;
    }

    public function setMethod($method){
        $this->_method = $method;
        return $this;
    }
    public function render(){
        $output = '<form method="' . $this->_method;
        foreach($this->_attributes as $key => $value){
            $output.=" " . $key."=".'"'.$value.'"';
        }
        $output.=  '>';
        foreach($this->_inputs as $inputType){
            $output.= "\n" .\Framework\ViewHelpers\Input::create()->setType($inputType)->render();
        }
        $output .=  \Framework\ViewHelpers\Input::create()->setType('submit')->render();
        $output.= "\n</form>";

        echo $output;
    }




}