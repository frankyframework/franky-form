<?php
namespace Franky\Form;


class InputPassword{

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

    public function script()
    {
         return '<script >'
                . '$(".show_password").click(function(){'
                .   'if($(this).is(":checked")) { $(this).parent().prev("input").attr("type", "text"); } '
                .   'else { $(this).parent().prev("input").attr("type", "password"); } '
                . '});'
                . '</script>';
    }

    public function eye()
    {
         return '<label><input type="checkbox" name="valueshowpassword" class="show_password"/>Mostrar valor</label>';
    }

    public function create()
    {
        $type = "password";
      

        return '<input type="'.$type.'" name="'.$this->name().'"  '.$this->attrs2txt().' />'.$this->eye().$this->script();
    }

}
