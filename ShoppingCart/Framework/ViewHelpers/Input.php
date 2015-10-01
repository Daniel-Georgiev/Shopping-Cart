<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/30/2015
 * Time: 8:55 PM
 */

namespace Framework\ViewHelpers;


class Input
{
    private $_attributes = [];
    private $_type = '';

    /**
     * @var Form
     */
    private $parent;

    public static function create(){
        return new self();
    }

    public function addAttribute($attributeName, $attributeValue){
        $this->_attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function setType($type){
        $this->_type = $type;
        return $this;
    }
    public function render(){
        $output = "<input type=" . $this->_type;
        foreach($this->_attributes as $key => $value){
            $output.=' ' . $key.'='.'"'.$value.'"';
        }
        $output.= ">\n";

        return $output;
    }

    public function setParent(Form $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Form
     */
    public function getParent()
    {
        return $this->parent;
    }
}