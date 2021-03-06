<?php
namespace Franky\Form;

class InputSelect{

    private $name = '';
    private $label = '';
    private $attrs = [];

    public function __construct() {


    }

    public function  name($name = null){
        if(isset($name))
        {
            $this->name = $name;
            return $this;
        }

        return $this->name;
    }

    public function  emptyOption($label = null){
        if(isset($label))
        {
            $this->label = $label;
            return $this;
        }

        return $this->label;
    }

    public function attrs($attr =null){
        if(isset($attr))
        {
            $this->attrs = $attr;
            return $this;
        }

        return $this->attrs;
    }


    public function attr($attr,$val= null){
        if(isset($val))
        {
            $this->attrs[$attr] = $val;
            return $this;
        }

        return $this->attrs[$attr];
    }

    public function options($options= null){
        if(isset($options))
        {
            $this->options = $options;
            return $this;
        }

        return $this->options;
    }

    public function attrs2txt(){

         $txt = '';
        if(!empty($this->attrs))
        {
            foreach($this->attrs as $k => $v)
            {
                $txt .= $k.'="'.$v.'" ';
            }
        }

        return trim($txt);
    }

    public function create()
    {
                $value = $this->attr("value");
        unset($this->attrs["value"]);
        $options = $this->options();
        $html = '<select name="'.$this->name().'" '.$this->attrs2txt().'>'
                .'<option value="">'.$this->emptyOption().'</option>';
                if(!empty($options))
                {
                    foreach($options as $k => $v)
                    {
                        if(is_array($value))
                        {
                            $html .= "<option value=\"$k\" ".(isset($value) && in_array($k, $value) ? "selected='selected'" : "").">$v</option>";
                        }
                        else {
                            $html .= "<option value=\"$k\" ".(isset($value) && $value == $k ? "selected='selected'" : "").">$v</option>";
                        }

                    }
                }
                $html .= '</select>';

        return $html;
    }

}
