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

  public function __construct(&$object)
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
   *
   *  @param Array $data
   *    The Data send by the form
   *    In many cases this can be $_POST
   *  @param Array &$erros
   *    If the Data is not valid errors are added to this Array
   *
   *  return Boolean
   */
  public function validate($data, &$errors)
  {
    $fields = $this->object->properties;

    foreach ($fields as $name => $field)
    {
      $datatype = sprintf("datatype\\%s", $field["type"]);
      $datatype = new $datatype();

      if (!$datatype->validate($data[$name]))
        $errors[$name] = $data[$name];
    }

    return count($errors) == 0;
  }

  /**
   *  
   *
   *  @param Array $data
   *    The Data send by the form
   *    In many cases this can be $_POST
   */
  public function save($data)
  {
    $fields = $this->object->properties;
    
    foreach ($fields as $name => $field)
      $this->object->$name = $data[$name];

    $this->object->save();
  }
}
