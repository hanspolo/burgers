<?php

/**
 *
 *
 *  @author Hanspolo <ph.hanspolo@googlemail.com>
 *  @copyright 2013 Hanspolo
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.1
 */
class User extends SqlMapper
{
  /**
   *  @see SqlMapper::__construct($db, $table, $ttl)
   */
  function __construct($db, $table="Users", $ttl=60)
  {
    parent::__construct($db, $table, $ttl);

    $this->properties = array(
      "id" => array(
        "type" => "Integer",
      ),
      "groupId" => array(
        "type" => "Integer",
      ),
      "name" => array(
        "type" => "Text",
      ),
      "email" => array(
        "type" => "Email",
      ),
      "password" => array(
        "type" => "Text",
      ),
    );
  }

  /**
   *  Creates a Salt used for hashing passwords
   *
   *  @return String
   */
  function createSalt()
  {
    $factor = rand(5, 500);
    return md5(time() * $factor);
  }

  /**
   *  Checks if a User can login
   *
   *  @param String $email
   *  @param String $password
   *
   *  @return Boolean
   */
  function checkLogin($email, $password)
  {
    $clone = clone $this;
    $clone->reset();
    $clone->load(array("email = ?", $email));
    if ($clone->dry())
      return false;

    return Bcrypt::instance()->verify($password, $clone->password);
  }

  /**
   *  @see SqlMapper::__set($key, $value);
   */
  function __set($key, $value)
  {
    if ($key == "password")
      $value = Bcrypt::instance()->hash($value, $this->createSalt(), 16);

    parent::__set($key, $value);  
  }
}
