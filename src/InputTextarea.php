<?php
namespace Franky\Form;


class InputTextarea{

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
        $type = "textarea";
        $value = (isset($this->attrs["value"]) ? $this->attrs["value"] : "");
        unset($this->attrs["value"]);
        return '<'.$type.' name="'.$this->name().'" '.$this->attrs2txt().'>'.$value.'</textarea>';
    }

}
