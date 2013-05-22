<?php

namespace datatype;

class Text extends DataType
{
  public function validate($value)
  {
    return is_string($value); 
  }
}
