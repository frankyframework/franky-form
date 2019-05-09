<?php
namespace Franky\Form;

use Franky\Form\InputText;
use Franky\Form\InputPassword;
use Franky\Form\InputTextarea;
use Franky\Form\InputHidden;
use Franky\Form\InputFile;
use Franky\Form\InputButton;
use Franky\Form\InputSubmit;
use Franky\Form\InputImage;
use Franky\Form\InputSelect;
use Franky\Form\InputDate;
use Franky\Form\InputDateMobile;
use Franky\Form\InputRadio;
use Franky\Form\InputCheck;
use Franky\Form\InputLabel;

class Form
{

    private $fields;
    private $attrs;
    private $InputText;
    private $InputHidden;
    private $InputFile;
    private $InputPassword;
    private $InputTextarea;
    private $InputButton;
    private $InputSubmit;
    private $InputImage;
    private $InputSelect;
    private $InputRadio;
    private $InputCheck;
    private $InputDate;
    private $InputMobile;
    private $InputLabel;
    private $isMobile;

    function __construct() {


        $this->InputText = new InputText();
        $this->InputPassword = new InputPassword();
        $this->InputTextarea = new InputTextarea();
        $this->InputHidden = new InputHidden();
        $this->InputFile = new InputFile();
        $this->InputButton = new InputButton();
        $this->InputSubmit = new InputSubmit();
        $this->InputImage = new InputImage();
        $this->InputSelect = new InputSelect();
        $this->InputDate = new InputDate(new InputSelect());
        $this->InputDateMobile = new InputDateMobile();
        $this->InputRadio = new InputRadio();
        $this->InputCheck = new InputCheck();
        $this->InputLabel = new InputLabel();

        $this->fields = array();
        $this->attrs = array();
    }


    public function openTag(){ return "<form  ".$this->attrs2txt()." >"; }
    public function endTag(){ return "</form>"; }

    private function isMobile()
    {
      return $this->isMobile;
    }

    public function setMobile($mobile)
    {
       $this->isMobile = $mobile;
    }

    public function setAtributos($val)
    {
        $this->attrs = $val;
        return $this;
    }
    public function setAtributo($key,$val)
    {
        $this->attrs[$key] = $val;
        return $this;
    }

    public function getAtributos()
    {
        return $this->attrs;
    }

    public function add($val)
    {
        if(!isset($val["required"]))
        {
            $val["required"] = false;
        }
        if(!isset($val["label"]))
        {
            $val["label"] = '';
        }
        if(!isset($val["atributos"]))
        {
            $val["atributos"] = [];
        }
        if(!isset($val["label_atributos"]))
        {
            $val["label_atributos"] = [];
        }
        if(!isset($val["options"]))
        {
            $val["options"] = [];
        }
         if(!isset($val["empty_option"]))
        {
            $val["empty_option"] = '';
        }


        $this->fields[$val["name"]] = $val;

    }

    public function setData($data)
    {

        if(!empty($this->fields) && !empty($data))
        {
            foreach($this->fields as $key => $val)
            {
                $key2 = $key;
                if(!isset($data[$key]) && isset($data[str_replace("[]","",$key)]))
                {
                    $key2 = str_replace("[]","",$key);

                }

                if(isset($data[$key2])):


                    $this->setAtributoInput($key,"value",$data[$key2]);
                endif;
            }
        }

        return $this;
    }


    public function get($key)
    {

       switch (strtolower($this->fields[$key]["type"]))
       {
            case "text":
                if(isset($this->fields[$key]["atributos"]['type_mobile']) && $this->isMobile())
                {
                    $this->fields[$key]["atributos"]['type'] = strtolower($this->fields[$key]["atributos"]['type_mobile']);
                }
                $this->fields[$key]["atributos"]['type'] = strtolower($this->fields[$key]["type"]);
            return $this->InputText->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "password":
                return  $this->InputPassword->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "file":
                return  $this->InputFile->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "hidden":
                return  $this->InputHidden->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "select":
                return  $this->InputSelect->name($key)->attrs($this->fields[$key]["atributos"])
                    ->emptyOption($this->fields[$key]["empty_option"])->options($this->fields[$key]["options"])->create();
            case "radio":
                return  $this->InputRadio->name($key)->attrs($this->fields[$key]["atributos"])
                    ->options($this->fields[$key]["options"])->create();
            case "checkbox":
                  return  $this->InputCheck->name($key)->attrs($this->fields[$key]["atributos"])
                    ->options($this->fields[$key]["options"])->create();
            case "textarea":
               return  $this->InputTextarea->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "submit":
                return  $this->InputSubmit->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "button":
                return  $this->InputButton->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "image":
                return  $this->InputImage->name($key)->attrs($this->fields[$key]["atributos"])->create();
            case "date":
            
            unset($this->fields[$key]["type"]);
            if(isset($this->fields[$key]["atributos"]['type_mobile']) && $this->isMobile())
            {
                unset($this->fields[$key]["atributos"]['type_mobile']);
                return  $this->InputDateMobile->name($key)->attrs($this->fields[$key]["atributos"])->create();
            }
            unset($this->fields[$key]["atributos"]['type_mobile']);
            return  $this->InputDate->name($key)->attrs($this->fields[$key]["atributos"])->create();

       }
    }

    public function getRow($key)
    {

        if(isset($this->fields[$key])):

          if($this->fields[$key]['type'] == 'hidden'):
              return $this->get($key);
          endif;
          $string = $this->InputLabel->name($key)->attrs($this->fields[$key]["label_atributos"])->label($this->fields[$key]['label'])->required($this->fields[$key]['required'])->create();
          return sprintf($string,$this->get($key));

        endif;

        return '';
    }

    public function getAllRow()
    {
        $html = "";
        if(!empty($this->fields))
        {
            foreach($this->fields as $k =>$v)
            {
                $html .=  $this->getRow($k);
            }
        }
        return $html;
    }


    public function setAtributoInput($name,$key,$val)
    {
        $this->fields[$name]["atributos"][$key] = $val;

        return $this;
    }
    public function setAtributoBaseInput($name,$key,$val)
    {
        $this->fields[$name][$key] = $val;

        return $this;
    }
    public function setAtributoLabel($name,$key,$val)
    {
        $this->fields[$name]["label_atributos"][$key] = $val;

        return $this;
    }

    public function attrs2txt(){


        $this->attrs['id'] = $this->attrs['name'];
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

    public function setOptionsInput($name,$val)
    {
        $this->fields[$name]["options"] = $val;
        return $this;
    }

    public function getOptionsInput($name)
    {
        return $this->fields[$name]["options"];
    }

    public function setAtributoBase($name,$key,$val)
    {
        $this->fields[$name][$key] = $val;

        return $this;
    }
    public function getAtributoBase($name,$key)
    {
        return $this->fields[$name][$key];
    }

    public function deleteInput($name)
    {
        unset($this->fields[$name]);
    }
}
?>
