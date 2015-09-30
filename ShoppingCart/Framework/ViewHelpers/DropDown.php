<?php


namespace Framework\ViewHelpers;

class DropDown
{
    private $_output = '';
    private $_attributes = [];
    private $_options = '';

    public static function create(){
        return new self();
    }

    public function addAttribute($attributeName, $attributeValue){
        $this->_attributes[$attributeName] = $attributeValue;
        return $this;
    }

    public function setContent($content, $valueKey = 'id', $valueContent = 'value', $keySelected = null, $valueSelected = null){
        foreach ($content as $model ) {
            $this->_options.= "\t<option";
            if($keySelected && $valueSelected){
                if($model[$keySelected] == $valueSelected){
                    $this->_options.= " selected ";
                }
            }
            $this->_options.= "value=[$model[$valueKey]" . $model[$valueContent] . "</options>\n";
        }
        return $this;
    }

    public function setDefaultOption($valueContent){
        $this->_options = "\t<option value=\"\">$valueContent</option>\n".$this->_options;

        return $this;
    }

    public function render(){
        $output = "<select";
        foreach($this->_attributes as $key => $value){
            $output.=" " . $key."=".'"'.$value.'"';
        }
        $output.= ">\n";
        $output.= $this->_options;
        $output.="</select>";

        echo $output;
    }


}