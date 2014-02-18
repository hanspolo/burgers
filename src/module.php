<?php

/**
 *  
 *
 *  @author Philipp Hirsch <itself@hanspolo.net>
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */

class Module
{
  /**
   *  Checks if a module exists
   *
   *  @param String $module
   */
  private function moduleExists($module)
  {
    try {
      return class_exists($module);
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   *  Executes a module
   *
   *  @param String $module
   *
   *  @throws ModuleNotFoundException
   *  @throws ModuleIncorrectException
   */
  public function execute($module)
  {
    if (!$this->moduleExists($module))
      throw new ModuleNotFoundException("$module does not exist.");

    $instance = new $module();

    if (!($instance instanceof AbstractModule))
      throw new ModuleIncorrectException("$module is not a wellformed Module");

    return $instance->execute();
  }

}

/**
 *
 *
 *  @author Philipp Hirsch <itself@hanspolo.net>
 *  @license https://gnu.org/licenses/gpl.html GNU Public License
 *  @version 0.2
 */
abstract class AbstractModule
{
  abstract public function execute();
}


class ModuleNotFoundException extends Exception
{
}

class ModuleIncorrectException extends Exception
{
}
