<?php
namespace Franky\Form;


class InputPassword{

    private $name = '';
    private $labelShow = '';
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
        if(!isset($this->attrs[$attr])){
            return "";
        }
        return $this->attrs[$attr];
    }


    public function attrs2txt(){

         $txt = '';
        if(!empty($this->attrs))
        {
            foreach($this->attrs as $k => $v)
            {
                if($k != "showLabel") {
                    $txt .= $k.'="'.$v.'" ';
                }
            }
        }

        return trim($txt);
    }

    public function script()
    {
         return '<script >'
                . '$(".show_password'.$this->name().'").click(function(){'
                .   'if($(this).is(":checked")) { $("input[name='.$this->name().']").attr("type", "text"); } '
                .   'else { $("input[name='.$this->name().']").attr("type", "password"); } '
                . '});'
                . '</script>';
    }

    public function eye()
    {
         return '<label><input type="checkbox" name="valueshowpassword'.$this->name().'" class="show_password show_password'.$this->name().'"/>'.(!empty($this->attr('showPassword')) ? $this->attr('showPassword') : 'Mostrar valor').'</label>';
    }

    public function errorLabel()
    {
        return '<label id="'.$this->name().'-error" class="error" for="'.$this->name().'" style="display: none;"></label>';
    }
    public function create()
    {
        $type = "password";
      

        return '<input type="'.$type.'" name="'.$this->name().'"  '.$this->attrs2txt().' />'.$this->eye().$this->errorLabel().$this->script();
    }

}
