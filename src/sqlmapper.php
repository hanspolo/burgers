<?php

/**
 *
 */
class SqlMapper extends \DB\SQL\Mapper
{
  protected $properties;

  /**
   *  @see \DB\SQL\Mapper::__set($key, $value)
   *
   *  @throws FieldNotExistException
   *  @throws FieldInvalidException
   */
  public function __set($key, $value)
  {
    if (!array_key_exists($key, $this->properties))
      throw new FieldNotExistsException("$key does not exist.");

    $class = sprintf("datatype\\%s", $this->properties[$key]["type"]);
    $instance = new $class();

    if (!$instance->validate($value))
      throw new FieldInvalidException("'$value' is not allowed for field '$key'");

    parent::__set($key, $value);
  }
}

class FieldInvalidException extends Exception
{
}

class FieldNotExistsException extends Exception
{
}
