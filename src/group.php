<?php

/**
 *  Grouping Users to match ACL
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.1
 */
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
