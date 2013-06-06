<?php

namespace datatype;

class Email extends DataType
{
  public function validate($value, $options = array())
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
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
    $form .= "<input name=\"$name\" type=\"email\" value=\"$value\" ";
    if ($error)  $form .= "class=\"error\" ";
    $form .= "/>";

    return $form;
  }
}
