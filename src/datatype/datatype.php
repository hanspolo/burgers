<?php

namespace datatype;

abstract class DataType
{
  abstract public function validate($value);
}
