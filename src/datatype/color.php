<?php

namespace datatype;

class Color extends DataType
{
  public function validate($value, $options = array())
  {
    $valid = !is_null($value);
    $valid &= preg_match("/\b\#?(([a-fA-F0-9]{3}){1,2})\b/", $value) === 1;

    return $valid;   
  }

  /**
   *  @see \datatype\DateType::renderForm($name, $value)
   */
  public function renderForm($name, $value = null, $error = false, $options = array())
  { 
    $f3 = \Base::instance();

    $form = "<label>";
    $form .= $f3->exists("lng.$name") ? $f3->get("lng.$name") : $name;
    $form .= "</label>";
    $form .= "<input name=\"$name\" type=\"color\" value=\"$value\" ";
    if ($error)  $form .= "class=\"error\" ";
    $form .= "/>";

    return $form;
  }

}
