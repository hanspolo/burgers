<?php

namespace datatype;

/**
 *  Describes a abstract Datatype for validation and form generation
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

abstract class DataType
{
  /**
   *  Checks the value with datatype specific validations
   *
   *  @param Mixed $value
   *  @param Array $options
   *
   *  @return Boolean
   */
  abstract public function validate($value, $options = array());

  /**
   *  Renders the form output
   *
   *  @param String $name
   *  @param Mixed $value
   *    Sets a default value to the form element
   *  @param Boolean $error
   *    Set to true to mark the value as invalid
   *  @param Array $options
   *
   *  @return String
   */
  public function renderForm($name, $value = null, $error = false, $options = array())
  {
    return "";
  }
}
