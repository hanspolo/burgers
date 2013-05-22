<?php

class Email extends DataType
{
  public function validate($value)
  {
    return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
  }
}
