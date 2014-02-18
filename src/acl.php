<?php

define("ACL_READ", 1);
define("ACL_CREATE", 2);
define("ACL_EDIT", 4);
define("ACL_DELETE", 8);

/**
 *  Access Controll List for authorization by group
 *
 *  @author Philipp Hirsch <itself@hanspolo.net>
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

class ACL extends SqlMapper
{
  /**
   *  @see SQLMapper::__construct($db, $table, $ttl)
   */
  function __construct($db, $table="ACL", $ttl=60)
  {
    parent::__construct($db, $table, $ttl);

    $this->properties = array(
      "id" => array(
        "type" => "Integer",
      ),
      "action" => array(
        "type" => "Text",
      ),
      "rule" => array(
        "type" => "Integer",
      ),
      "groupId" => array(
        "type" => "Integer",
      ),
    );
  }

  /**
   *  Checks if a User is authorized to preform an Action
   *
   *  @param Integer $groupId
   *  @param String $action
   *  @param Integer $rule
   *    ACL_READ
   *    ACL_CREATE
   *    ACL_EDIT
   *    ACL_DELETE
   *
   *  @return Boolean
   *
   *  @throws ActionNotFoundException
   */
  public function check($groupId, $action, $rule)
  {
    $this->load(array("groupId = ? AND action = ?", $groupId, $action));

    if ($this->dry())
      throw new ActionNotFoundException("'$action' is not in the ACL Database.");

     return ($this->rule & $rule) > 0;
  }
}

class ActionNotFoundException extends Exception
{
}
