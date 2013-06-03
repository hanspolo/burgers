<?php

namespace datatype;

class Integer extends DataType
{
  public function validate($value)
  {
    return is_int($value);
  }

  /**
   *  @see \datatype\DateType::renderForm($name, $value)
   */
  public function renderForm($name, $value = null)
  { 
    $f3 = \Base::instance();

    $form = "<label>";
    $form .= $f3->exists("lng.$name") ? $f3->get("lng.$name") : $name;
    $form .= "</label>";
    $form .= "<input name=\"$name\" type=\"number\" value=\"$value\">";

    return $form;
  }

}
