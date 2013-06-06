<?php

namespace datatype;

class Numeric extends DataType
{
  public function validate($value, $options = array())
  {
    return false; 
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
    $form .= "<input name=\"$name\" type=\"text\" value=\"$value\" ";
    if ($error)  $form .= "class=\"error\" ";
    $form .= "/>";

    return $form;
  }

}
