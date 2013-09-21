<?php

namespace datatype;

class Integer extends DataType
{

  public function validate($value, $options = array())
  {
    $valid = is_numeric($value);
    $valid &= preg_match("/\b[0-9]+\b/", $value) === 1;
    $valid &= (!array_key_exists("min", $options) || $value >= $options["min"]);
    $valid &= (!array_key_exists("max", $options) || $value <= $options["max"]);
    
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
    $form .= "<input name=\"$name\" type=\"number\" value=\"$value\" ";
    if (array_key_exists("min", $options)) $form .= "min=\"$options[min]\" ";
    if (array_key_exists("max", $options)) $form .= "max=\"$options[max]\" ";
    if ($error)  $form .= "class=\"error\" ";
    $form .= "/>";

    return $form;
  }

}
