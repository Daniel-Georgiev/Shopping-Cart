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
    /**
     * @var Input[]
     */
    private $_inputs = [];
    private $_method = '';

    public static function create(){
        return new self();
    }

    public function addAttribute($attributeName, $attributeValue){
        $this->_attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function setMethod($method){
        $this->_method = $method;
        return $this;
    }

    /**
     * @param $type
     * @return \Framework\ViewHelpers\Input
     */
    public function addInput($type){
        $this->_inputs[$type] = \Framework\ViewHelpers\Input::create()->setType($type);
        $this->_inputs[$type]->setParent($this);

        return $this->_inputs[$type];
    }

    public function addTextArea(){
        $textArea = TextArea::create();
        array_push($this->_feilds,$textArea );

        return $textArea;
    }

    public function render(){
        $output = '<form method="' . $this->_method;

        foreach($this->_attributes as $key => $value){
            $output.=" " . $key."=".'"'.$value.'"';
        }
        $output.=  '>';
        foreach($this->_inputs as $input){
            $output .= $input->render();
        }
        $output .=  \Framework\ViewHelpers\Input::create()->setType('submit')->render();
        $output.= "\n</form>";

        echo $output;
    }




}