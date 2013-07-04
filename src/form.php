<?php

/**
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
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
    $f3 = Base::instance();
    $fields = $this->object->properties;

    $output = "";

    $token  = CSRF::generateToken();
    $output = "<input type=\"hidden\" name=\"csrf_token\" value=\"$token\" />";

    foreach ($fields as $name => $field)
    {
      $datatype = sprintf("datatype\\%s", $field["type"]);
      $datatype = new $datatype();
      $output .= $datatype->renderForm($name, $this->object->$name, $f3->exists("form_errors.$name"), $field);
    }

    return $output;
  }

  /**
   *  
   *
   *  @param Array $data
   *    The Data send by the form
   *    In many cases this can be $_POST
   *
   *  return Boolean
   */
  public function validate($data)
  {
    $f3 = Base::instance();
    $fields = $this->object->properties;
    $errors = array();

    // CSRF Token valid?
    $valid_token = array_key_exists("csrf_token", $data)
                && CSRF::validateToken($data["csrf_token"]);

    if (!$valid_token)
      $errors["csrf_token"] =
        array_key_exists("csrf_token", $data) ? $data["csrf_token"] : "";

    // Validate fields
    foreach ($fields as $name => $field)
    {
      $datatype = sprintf("datatype\\%s", $field["type"]);
      $datatype = new $datatype();

      $optional = array_key_exists("optional", $field) && $field["optional"];
      $optional &= (!array_key_exists($name, $data) || $data[$name] === "");
      if ($optional)
        continue;

      if (!$datatype->validate($data[$name], $field))
        $errors[$name] = $data[$name];
    }
  
    $f3->set("form_errors", $errors);
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
    $f3 = Base::instance();
    $fields = $this->object->properties;

    if (count($f3->get("form_errors")) > 0)
      throw new FormInvalidException();
    
    foreach ($fields as $name => $field)
    {
      $optional = array_key_exists("optional", $field) && $field["optional"];
      $optional &= (!array_key_exists($name, $data) || $data[$name] === "");
      if ($optional)
        continue;

      $this->object->$name = $data[$name];
    }

    $this->object->save();
  }
}


class FormInvalidException extends Exception
{
  public function __construct(
    $msg = "Can not save a form that contains invalid data.")
  {
    parent::__construct($msg);
  }
}
