<?php

namespace datatype;

class Numeric extends DataType
{
  public function validate($value)
  {
    return is_numeric($value);
  }
}
