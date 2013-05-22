<?php

namespace datatype;

class Float extends DataType
{
  public function validate($value)
  {
    return is_float($value);
  }
}
