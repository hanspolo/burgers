<?php

namespace datatype;

class Boolean extends DataType
{
  public function validate($value, $options = array())
  {
    return is_bool($value);
  }

  /**
   *  @see \datatype\DateType::renderForm($name, $value)
   */
  public function renderForm($name, $value = null, $error = false, $options = array())
  { 
    $f3 = \Base::instance();

    $form = "<label class=\"checkbox\">";
    $form .= "<input name=\"$name\" type=\"checkbox\" ";
    if ($value === true) $form .= "checked=\"checked\"";
    $form .=">";
    $form .= $f3->exists("lng.$name") ? $f3->get("lng.$name") : $name;
    $form .= "</label>";

    return $form;
  }
}
