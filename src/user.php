<?php

/**
 *
 *
 *  @author Philipp Hirsch <itself@hanspolo.net>
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

class User
{
  public static function createUser($db = null)
  {
    $f3 = \Base::instance();

    if ($f3->exists("LOGIN") && $f3->get("LOGIN") == "LDAP")
      return new LdapUser();
    else
      return new DbUser($db);
  }
}

/**
 *
 */
class DbUser extends SqlMapper
{
  /**
   *  @see SqlMapper::__construct($db, $table, $fluid, $ttl)
   */
  function __construct($db, $table="Users", $fluid=null, $ttl=60)
  {
    $f3 = \Base::instance();
    
    if ($f3->exists("LOGIN") && $f3->get("LOGIN") == "LDAP")
      return ;

    parent::__construct($db, $table, $fluid, $ttl);

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
  private function createSalt()
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
   *  @return Mixed
   */
  public function checkLogin($login, $password)
  {
    $f3 = \Base::instance();
    $type = null;

    $clone = clone $this;
    $clone->reset();
    $clone->load(array("email = ?", $login));
    if ($clone->dry())
      return false;

    if (Bcrypt::instance()->verify($password, $clone->password))
    {
      return $clone;
    }
    else
    {
      return false;
    }
  }

  /**
   *  @see SqlMapper::__set($key, $value);
   */
  function __set($key, $value)
  {
    if ($key == "password")
      $value = Bcrypt::instance()->hash($value, $this->createSalt(), 14);

    parent::__set($key, $value);  
  }
}

/**
 *
 */
class LdapUser
{
  private $ldap_ds;

  public function __construct()
  {
    $f3 = \Base::instance();

    $this->ds = ldap_connect($f3->get("LDAP_HOST"));
    if (!$this->ds)
      throw Exception("Can not connect to LDAP.");
  }

  /**
   *  Checks if a User can login
   *
   *  @param String $email
   *  @param String $password
   *
   *  @return Boolean
   */
  public function checkLogin($login, $password)
  {
    if (!$password)
      return false;

    $f3 = \Base::instance();
 
    $login = $login . '@' . $f3->get("LDAP_DOMAIN");
    return @ldap_bind($this->ds, $login, $password);
  }

  /** 
   *
   */
  public function authorize($login, $group)
  {
    $f3 = \Base::instance();

    ldap_set_option($this->ds, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3);

    ldap_bind(
      $this->ds, 
      $f3->get("LDAP_USER") . "@" . $f3->get("LDAP_DOMAIN"),
      $f3->get("LDAP_PASS")
    );

    $dcs = explode(".", $f3->get("LDAP_DOMAIN"));
    $dn = "dc=" . implode(",dc=", $dcs);

    $results = ldap_search(
      $this->ds, $dn, 
      "(&(memberOf=CN=" . $group . ",OU=" . $f3->get("LDAP_GROUPS") . "," . $dn . ")(sAMAccountName=" . $login . "))"
    );
    $entries = ldap_get_entries($this->ds, $results);

    return $entries["count"] > 0;
  }
}
