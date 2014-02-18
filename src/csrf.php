<?php

/**
 *
 *  @author Philipp Hirsch <itself@hanspolo.net>
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

class CSRF
{
  /**
   *  Generates a CSRF Token and stores it in the Session
   *
   *  @return String
   */
  public static function generateToken()
  {
    $f3 = Base::instance();
    $token = md5(time() * mt_rand(1, 100));

    $f3->set("SESSION.csrf_token", $token);
    $f3->set("SESSION.csrf_used", false);

    return $token;
  } 

  /**
   *  Compares the given token with the value in the Session
   *
   *  @param String $token
   *
   *  @return Boolean
   */
  public static function validateToken($token)
  {
    $f3 = Base::instance();

    if ($f3->get("SESSION.csrf_used"))
      return false;

    $f3->set("SESSION.csrf_used", true);

    return $f3->get("SESSION.csrf_token") == $token;
  }
}