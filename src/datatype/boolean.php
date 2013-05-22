<?php

namespace datatype;

class Boolean extends DataType
{
  public function validate($value)
  {
    return is_bool($value);
  }
}
