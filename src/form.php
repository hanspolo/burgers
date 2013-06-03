<?php

/**
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.1
 */

class Form
{
  private $object;

  public function __construct($object)
  {
    $this->object = $object;
  }

  /**
   *
   */
  public function render()
  {
    $fields = $this->object->properties;

    $output = "";

    foreach ($fields as $name => $field)
    {
      $datatype = sprintf("datatype\\%s", $field["type"]);
      $datatype = new $datatype();
      $output .= $datatype->renderForm($name, $this->object->$name);
    }

    return $output;
  }

  /**
   *
   */
  public function validate()
  {

  }

  /**
   *
   */
  public function save()
  {

  }
}
