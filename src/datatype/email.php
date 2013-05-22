<?php

namespace datatype;

class Email extends DataType
{
  public function validate($value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
  }
}
