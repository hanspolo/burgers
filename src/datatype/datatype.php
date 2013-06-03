<?php

namespace datatype;

/**
 *  Describes a abstract Datatype for validation and form generation
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.1
 */
abstract class DataType
{
  /**
   *  Checks the value with datatype specific validations
   *
   *  @param Mixed $value
   *
   *  @return Boolean
   */
  abstract public function validate($value);

  /**
   *  Renders the form output
   *
   *  @param String $name
   *  @param Mixed $value
   *    Sets a default value to the form element
   *
   *  @return String
   */
  public function renderForm($name, $value = null)
  {
    return "";
  }
}
