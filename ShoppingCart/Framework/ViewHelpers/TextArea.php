<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 9/30/2015
 * Time: 11:56 PM
 */

namespace Framework\ViewHelpers;


class TextArea
{
    private $_attributes = [];
    private $_content = '';

    public static function create(){
        return new self();
    }

    public function addAttribute($attributeName, $attributeValue){
        $this->_attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function setContent($content){
        $this->_content = $content;
    }

    public function render()
    {
        $output = "<textarea";
        foreach ($this->_attributes as $key => $value) {
            $output .= ' ' . $key . '=' . '"' . $value . '"';
        }
        $output .= ">\n";
        $output.= $this->_content;
        $output.= "\n</textarea>";
        return $output;
        }
}