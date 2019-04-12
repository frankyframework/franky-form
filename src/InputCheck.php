<?php
namespace Franky\Form;


class InputCheck{

    private $name = '';
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

        $html = "<ul>";
        if(!empty($options))
        {
            foreach($options as $k => $v)
            {
                  $this->attr("value",$k);
                if(is_array($value))
                {
                    $ch = (isset($value) && in_array($k,$value) ? "checked='checked'" : "");
                }
                else
                {
                    $ch = (isset($value) && $k == $value ? "checked='checked'" : "");
                }
                $html .= '<li><label><input type="checkbox" name="'.$this->name().'" '.$this->attrs2txt().' '.$ch.' /><span>'.$v.'</span></label></li>';
            }
        }
        $html .= "</ul>";
        return $html;
    }

}
