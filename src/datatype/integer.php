<?php

namespace datatype;

class Integer extends DataType
{
  public function validate($value)
  {
    return is_numeric($value);
  }
}
