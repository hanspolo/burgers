<?php

namespace datatype;

class Text extends DataType
{
  public function validate($value, $options = array())
  {
    $valid = is_string($value); 
    $valid &= (!array_key_exists("maxlength", $options) ||
               strlen($value) <= $options["maxlength"]);

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
    $form .= "<input name=\"$name\" type=\"text\" value=\"$value\" ";
    if (array_key_exists("maxlength", $options)) 
      $form .= "maxlength=\"$options[maxlength]\" ";
    if ($error)  $form .= "class=\"error\" ";
    $form .= "/>";

    return $form;
  }

}
