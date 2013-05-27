<?php

namespace datatype;

class Date extends DataType
{
  public function validate($value)
  {
    return strtotime($value) > 0;
  }
}
