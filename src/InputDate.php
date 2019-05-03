<?php
namespace Franky\Form;


use Franky\Form\InputSelect;
class InputDate{

    private $name = '';
    private $attrs = [];
    private $InputSelect;

    public function __construct( InputSelect $InputSelect) {

        $this->InputSelect = $InputSelect;

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
                . '<!--'
                ."\n"
                . '$(document).ready(function(){'
                    . '$("select[name='.$this->name().'_dia], select[name='.$this->name().'_mes], select[name='.$this->name().'_ano]").change(function(){'
                        . 'if($("select[name='.$this->name().'_dia]").val() != "" && $("select[name='.$this->name().'_mes]").val() != "" && $("select[name='.$this->name().'_ano]").val() != ""){'
                            .'$("input[name='.$this->name().']").val($("select[name='.$this->name().'_ano").val()+"-"+$("select[name='.$this->name().'_mes]").val()+"-"+$("select[name='.$this->name().'_dia]").val());'
                        . '}else{ $("input[name='.$this->name().']").val(""); }'
                    . '});'
                . '});'
                ."\n"
                . '// -->'
                . '</script>';
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


          $input = '<div style="width: 1px; height:1px; overflow: hidden;"><input type="text" id="' . $this->name() . '" name="' . $this->name() . '" ' . $this->attrs2txt() . ' readonly="readonly"  /></div>';


        $f = array("","","");

        if(isset($this->attrs["value"]) && !empty($this->attrs["value"]))
        {
            $f = explode("-",$this->attrs["value"]);
        }


        unset($this->attrs["value"]);
        unset($this->attrs["class"]);
        $dias = array();
        for($x = 1; $x <= 31; $x++)
        {
            $dias[$x] = $x;
        }
        $this->attrs["value"] = $f[2];
        $input_dia = $this->InputSelect->name($this->name()."_dia")->attrs($this->attrs())
                    ->emptyOption(_("Día"))->options($dias)->create();
        $this->attrs["value"] = $f[1];
        $input_mes =  $this->InputSelect->name($this->name()."_mes")->attrs($this->attrs())
                    ->emptyOption(_("Mes"))->options(array(
                        "01" => _("Enero"),
                        "02" => _("Febrero"),
                        "03" => _("Marzo"),
                        "04" => _("Abril"),
                        "05" => _("Mayo"),
                        "06" => _("Junio"),
                        "07" => _("Julio"),
                        "08" => _("Agosto"),
                        "09" => _("Septiembre"),
                        "10" => _("Octubre"),
                        "11" => _("Noviembre"),
                        "12" => _("Diciembre")
                    ))->create();

        $anio = array();
        for($x = $min_y; $x <= $max_y; $x++)
        {
            $anio[$x] = $x;
        }
        $this->attrs["value"] = $f[0];
    $input_ano = $this->InputSelect->name($this->name()."_ano")->attrs($this->attrs())
                    ->emptyOption(_("Año"))->options($anio)->create();

        $label_error = "<label name='".$this->name()."-error' for='".$this->name()."' class='error' style='display:none;'></label>";


        return $input.$input_dia.$input_mes.$input_ano.$label_error.$this->script();
    }

}
