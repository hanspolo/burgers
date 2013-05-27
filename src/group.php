<?php

class Group extends SqlMapper
{
  /**
   *  @see SqlMapper::__construct($db, $table, $ttl)
   */
  function __construct($db, $table="Groups", $ttl=60)
  {
    parent::__construct($db, $table, $ttl);

    $this->properties = array(
      "id" => array(
        "type" => "Integer",
      ),
      "name" => array(
        "type" => "Text",
      ),
    );
  }


}
