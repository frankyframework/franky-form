<?php
namespace Franky\Form;

use vendor\mobile_detect\Mobile_Detect;

class InputButton{
    
    private $name = '';
    private $attrs = [];
    private $Mobile_Detect = false;
    
    public function __construct(Mobile_Detect $Mobile_Detect) {
        
        $this->Mobile_Detect = $Mobile_Detect;
        
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
         $value = $this->attrs["value"];
        unset($this->attrs["value"]);
        return '<button name="'.$this->name().'" '.$this->attrs2txt().' >'.$value.'</button>';
    }
    
}