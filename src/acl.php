<?php

define("ACL_READ", 1);
define("ACL_CREATE", 2);
define("ACL_EDIT", 4);
define("ACL_DELETE", 8);

/**
 *
 */
class ACL extends SQLMapper
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
      "right" => array(
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
  public static function check($groupId, $action, $rule)
  {
    $acl = new \model\ACL();
    $acl->load(array("groupId = ? AND action = ?", $groupId, $action);

    if ($acl->dry())
      throw new ActionNotFoundException("'$action' is not in the ACL Database.");

    return $acl->right | $rule > 0;
  }
}

class ActionNotFoundException extends Exception
{
}
