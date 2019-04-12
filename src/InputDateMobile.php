<?php
namespace Franky\Form;


class InputDateMobile{

    private $name = '';
    private $attrs = [];
    private $InputSelect;

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

        if(isset($this->attrs["min_year"]) && !empty($this->attrs["min_year"]))
        {
            $min_y = $this->attrs["min_year"];
            unset($this->attrs["min_year"]);
        }
        else
        {
            $min_y = date('Y')-95;
        }
        if(isset($this->attrs["max_year"]) && !empty($this->attrs["max_year"]))
        {
            $max_y = $this->attrs["max_year"];
            unset($this->attrs["max_year"]);
        }
        else
        {
            $max_y = date('Y');
        }

        $input = '<input type="date" id="' . $this->name() . '" name="' . $this->name() . '" ' . $this->attrs2txt() . '  />';

        $label_error = "<label name='".$this->name()."-error' for='".$this->name()."' class='error' style='display:none;'></label>";

        return $input.$label_error;

    }

}
