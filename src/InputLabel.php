<?php
namespace Franky\Form;



class InputLabel{
    
    private $name = '';
    private $label = '';
    private $required = false;
    private $attrs = [];
    
    public function __construct() {
        
    }
    
  
    public function attrs($attr =null){
        if(isset($attr))
        {
            $this->attrs = $attr;
            return $this;
        }
       
        return $this->attrs;   
    }
    
    public function  name($name = null){
        if(isset($name))
        {
            $this->name = $name;
            return $this;
        
        }
    
       
        return $this->name;   
    }
    
    public function  required($required = null){
        if(isset($required))
        {
            $this->required = $required;
            return $this;
        }
       
        return $this->required;   
    }
    
    public function  label($label = null){

        if(isset($label))
        {
            $this->label = $label;
            return $this;
        }

        return $this->label;   
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
   
        return $html =  "<div class=\"form-group form_".$this->name()."\">"
                    . "<label ".$this->attrs2txt().">"
                    . ($this->required() ? "*" : "")
                    . (empty($this->label) ? '' : '<span>'.$this->label().'</span>')
                    . "%s"
                    . "</label>"
                    . "</div>";
       
    }
    
}