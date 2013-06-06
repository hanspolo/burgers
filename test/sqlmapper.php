<?php

$f3=require('lib/base.php');
$f3->set("AUTOLOAD", "../lib");

class MyTestSqlMapper extends SqlMapper
{
  function __construct()
  {
    parent::__construct(new DB\SQL("sqlite:/tmp/test.sqlite"), "MyTest");
    $this->properties = array(
      "mybool" => array(
        "type" => "Boolean",
      ),
      "mycolor" => array(
        "type" => "Color",
      ),
      "myemail" => array(
        "type" => "Email",
      ),
      "myfloat" => array(
        "type" => "Float"
      ),
      "myint" => array(
        "type" => "Integer",
      ),
      "mynumeric" => array(
        "type" => "Numeric",
      ),
      "mytext" => array(
        "type" => "Text",
      ),
    );
  }
}

$test=new Test;
$instance=new MyTestSqlMapper;

/**
 *  Boolean
 */
try {
  $instance->mybool = true;
  $test->expect(true, "Can set true to a bool field");
} catch (Exception $e) {
  $test->expect(false, "Can set true to a bool field");
}

try {
  $instance->mybool = false;
  $test->expect(true, "Can set false to a bool field");
} catch (Exception $e) {
  $test->expect(false, "Can set false to a bool field");
}

try {
  $instance->mybool = "abc";
  $test->expect(false, "Can't set 'abc' to a bool field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'abc' to a bool field");
}

try {
  $instance->mybool = 1;
  $test->expect(false, "Can't set 1 to a bool field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 1 to a bool field");
}

/**
 *  Color
 */
try {
  $instance->mycolor = "#000";
  $test->expect(true, "Can set #000 to a color field");
} catch (Exception $e) {
  echo $e->getTraceAsString();
  $test->expect(false, "Can set #000 to a color field");
}

try {
  $instance->mycolor = "#0F1AB6";
  $test->expect(true, "Can set #0F1AB6 to a color field");
} catch (Exception $e) {
  $test->expect(false, "Can set #0F1AB6 to a color field");
}

try {
  $instance->mycolor = "#0f1ab6";
  $test->expect(true, "Can set #0f1ab6 to a color field");
} catch (Exception $e) {
  $test->expect(false, "Can set #0f1ab6 to a color field");
}

try {
  $instance->mycolor = "0F1AB6";
  $test->expect(true, "Can set 0F1AB6 to a color field");
} catch (Exception $e) {
  $test->expect(false, "Can set 0F1AB6 to a color field");
}

try {
  $instance->mycolor = "Hallo Welt!";
  $test->expect(false, "Can't set 'Hallo Welt!' to a color field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'Hallo Welt!' to a color field");
}

try {
  $instance->mycolor = 1;
  $test->expect(false, "Can't set 1 to a color field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 1 to a color field");
}

try {
  $instance->mycolor = "#00FAG8";
  $test->expect(false, "Can't set #00FAG8 to a color field");
} catch (Exception $e) {
  $test->expect(true, "Can't set #00FAG8 to a color field");
}

/**
 *  Date
 */

/**
 *  Email
 */
try {
  $instance->myemail = "hanspolo@github.io";
  $test->expect(true, "Can set 'hanspolo@github.io' to an email field");
} catch (Exception $e) {
  $test->expect(false, "Can set 'hanspolo@github.io' to an email field");
}

try {
  $instance->myemail = "Hallo Welt!";
  $test->expect(false, "Can't set 'Hallo Welt!' to an email field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'Hallo Welt!' to an email field");
}

try {
  $instance->myemail = true;
  $test->expect(false, "Can't set true to an email field");
} catch (Exception $e) {
  $test->expect(true, "Can't set true to an email field");
}

/**
 *  Float
 */
try {
  $instance->myfloat = 1.0;
  $test->expect(true, "Can set 1.0 to a float field");
} catch (Exception $e) {
  $test->expect(false, "Can set 1.0 to a float field");
}

try {
  $instance->myfloat = 1;
  $test->expect(false, "Can't set 1 to a float field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 1 to a float field");
}

try {
  $instance->myfloat = '';
  $test->expect(false, "Can't set '' to a float field");
} catch (Exception $e) {
  $test->expect(true, "Can't set '' to a float field");
}

/**
 *  Integer
 */
try {
  $instance->myint = 1;
  $test->expect(true, "Can set 1 to an int field");
} catch (Exception $e) {
  $test->expect(false, "Can set 1 to an int field");
}

try {
  $instance->myint = 0;
  $test->expect(true, "Can set 0 to an int field");
} catch (Exception $e) {
  $test->expect(false, "Can set 0 to an int field");
}

try {
  $instance->myint = "abc";
  $test->expect(false, "Can't set 'abc' to an int field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'abc' to an int field");
}

/**
 *  IP
 */

/**
 *  Numeric
 */
try {
  $instance->mynumeric = 1;
  $test->expect(true, "Can set 1 to a numeric field");
} catch (Exception $e) {
  $test->expect(false, "Can set 1 to a numeric field");
}

try {
  $instance->mynumeric = 0;
  $test->expect(true, "Can set 0 to a numeric field");
} catch (Exception $e) {
  $test->expect(false, "Can set 0 to a numeric field");
}

try {
  $instance->mynumeric = 1.0;
  $test->expect(true, "Can set 1.0 to a numeric field");
} catch (Exception $e) {
  $test->expect(false, "Can set 1.0 to a numeric field");
}

try {
  $instance->mynumeric = "abc";
  $test->expect(false, "Can't set 'abc' to a numeric field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'abc' to a numeric field");
}

/**
 *  Text
 */
try {
  $instance->mytext = "abc";
  $test->expect(true, "Can set 'abc' to a text field");
} catch (Exception $e) {
  $test->expect(false, "Can set 'abc' to a text field");
}

try {
  $instance->mytext = "";
  $test->expect(true, "Can set '' to a text field");
} catch (Exception $e) {
  $test->expect(false, "Can set '' to a text field");
}

try {
  $instance->mytext = 1234;
  $test->expect(false, "Can't set 1234 to a text field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 1234 to a text field");
}

// Display the results; not MVC but let's keep it simple
foreach ($test->results() as $result) {
  echo $result['text']."\t";
  if ($result['status'])
    echo 'Pass';
  else
    echo 'Fail ('.$result['source'].')';
  echo "\n";
}
